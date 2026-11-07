<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BusController extends Controller
{
    /**
     * Get all buses with their assigned driver details.
     */
    public function index()
    {
        $buses = Bus::query()
            ->orderBy('bus_number')
            ->get();

        $drivers = User::query()
            ->where('role', 'driver')
            ->whereNotNull('bus_number')
            ->get()
            ->keyBy('bus_number');

        $buses->transform(function ($bus) use ($drivers) {
            $driver = $drivers->get($bus->bus_number);

            $bus->driver_name = $driver?->name;
            $bus->driver_email = $driver?->email;
            $bus->driver_id = $driver?->id;

            return $bus;
        });

        return response()->json($buses);
    }

    /**
     * Get a single bus and calculate ETA.
     */
    public function show($bus_number)
    {
        $bus = Bus::where('bus_number', $bus_number)->first();

        if (!$bus) {
            return response()->json([
                'message' => 'Bus not found.',
            ], 404);
        }

        $etaMinutes = null;
        $distanceKm = null;

        $coordinatesAvailable =
            $bus->latitude !== null &&
            $bus->longitude !== null &&
            $bus->destination_latitude !== null &&
            $bus->destination_longitude !== null;

        if ($coordinatesAvailable) {
            $latitude = (float) $bus->latitude;
            $longitude = (float) $bus->longitude;
            $destinationLatitude = (float) $bus->destination_latitude;
            $destinationLongitude = (float) $bus->destination_longitude;

            $earthRadius = 6371;

            $lat1 = deg2rad($latitude);
            $lon1 = deg2rad($longitude);
            $lat2 = deg2rad($destinationLatitude);
            $lon2 = deg2rad($destinationLongitude);

            $dLat = $lat2 - $lat1;
            $dLon = $lon2 - $lon1;

            $a = sin($dLat / 2) ** 2
                + cos($lat1) * cos($lat2)
                * sin($dLon / 2) ** 2;

            $a = max(0, min(1, $a));

            $c = 2 * atan2(
                sqrt($a),
                sqrt(1 - $a)
            );

            $distanceKm = round($earthRadius * $c, 2);

            $averageSpeedKmh = 30;

            $etaMinutes = (int) round(
                ($distanceKm / $averageSpeedKmh) * 60
            );

            if ($distanceKm > 0 && $etaMinutes < 1) {
                $etaMinutes = 1;
            }
        }

        return response()->json([
            'id' => $bus->id,
            'bus_number' => $bus->bus_number,
            'route' => $bus->route,
            'status' => $bus->status,
            'latitude' => $bus->latitude,
            'longitude' => $bus->longitude,
            'destination_latitude' => $bus->destination_latitude,
            'destination_longitude' => $bus->destination_longitude,
            'location_updated_at' => $bus->location_updated_at,
            'distance_km' => $distanceKm,
            'eta_minutes' => $etaMinutes,
        ]);
    }

    /**
     * Add a new bus.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'bus_number' => [
                'required',
                'string',
                'max:50',
                'unique:buses,bus_number',
            ],
            'route' => [
                'required',
                'string',
                'max:255',
            ],
            'status' => [
                'nullable',
                Rule::in(['On Time', 'Delayed']),
            ],
            'latitude' => [
                'nullable',
                'numeric',
                'between:-90,90',
            ],
            'longitude' => [
                'nullable',
                'numeric',
                'between:-180,180',
            ],
            'destination_latitude' => [
                'nullable',
                'numeric',
                'between:-90,90',
            ],
            'destination_longitude' => [
                'nullable',
                'numeric',
                'between:-180,180',
            ],
        ]);

        $validatedData['status'] = $validatedData['status'] ?? 'On Time';

        $bus = Bus::create($validatedData);

        return response()->json([
            'message' => 'Bus created successfully.',
            'bus_number' => $bus->bus_number,
            'bus' => $bus,
        ], 201);
    }

    /**
     * Update bus route, status and destination.
     */
    public function update(Request $request, $bus_number)
    {
        $bus = Bus::where('bus_number', $bus_number)->first();

        if (!$bus) {
            return response()->json([
                'message' => 'Bus not found.',
            ], 404);
        }

        $validatedData = $request->validate([
            'route' => [
                'sometimes',
                'required',
                'string',
                'max:255',
            ],
            'status' => [
                'sometimes',
                'required',
                Rule::in(['On Time', 'Delayed']),
            ],
            'destination_latitude' => [
                'sometimes',
                'nullable',
                'numeric',
                'between:-90,90',
            ],
            'destination_longitude' => [
                'sometimes',
                'nullable',
                'numeric',
                'between:-180,180',
            ],
        ]);

        $bus->update($validatedData);

        return response()->json([
            'message' => 'Bus updated successfully.',
            'bus' => $bus->fresh(),
        ]);
    }

    /**
     * Update a bus GPS location.
     */
    public function updateLocation(Request $request, $bus_number)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated.',
            ], 401);
        }

        if (
            $user->role === 'driver' &&
            (string) $user->bus_number !== (string) $bus_number
        ) {
            return response()->json([
                'message' => 'You are not assigned to this bus.',
            ], 403);
        }

        if (!in_array($user->role, ['driver', 'admin'], true)) {
            return response()->json([
                'message' => 'You are not authorized to update bus locations.',
            ], 403);
        }

        $bus = Bus::where('bus_number', $bus_number)->first();

        if (!$bus) {
            return response()->json([
                'message' => 'Bus not found.',
            ], 404);
        }

        $validatedData = $request->validate([
            'latitude' => [
                'required',
                'numeric',
                'between:-90,90',
            ],
            'longitude' => [
                'required',
                'numeric',
                'between:-180,180',
            ],
        ]);

        $bus->update([
            'latitude' => $validatedData['latitude'],
            'longitude' => $validatedData['longitude'],
            'location_updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Bus location updated successfully.',
            'bus' => $bus->fresh(),
        ]);
    }

    /**
     * Assign a driver to a bus.
     */
    public function assignDriver(Request $request, $bus_number)
    {
        $bus = Bus::where('bus_number', $bus_number)->first();

        if (!$bus) {
            return response()->json([
                'message' => 'Bus not found.',
            ], 404);
        }

        $validatedData = $request->validate([
            'driver_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],
        ]);

        $driver = User::query()
            ->where('id', $validatedData['driver_id'])
            ->where('role', 'driver')
            ->first();

        if (!$driver) {
            return response()->json([
                'message' => 'Selected user is not a driver.',
            ], 422);
        }

        DB::transaction(function () use ($driver, $bus_number) {
            User::where('role', 'driver')
                ->where('bus_number', $bus_number)
                ->where('id', '!=', $driver->id)
                ->update([
                    'bus_number' => null,
                ]);

            $driver->update([
                'bus_number' => $bus_number,
            ]);
        });

        $driver->refresh();

        return response()->json([
            'message' => 'Driver assigned successfully.',
            'driver' => [
                'id' => $driver->id,
                'name' => $driver->name,
                'email' => $driver->email,
                'bus_number' => $driver->bus_number,
            ],
        ]);
    }

    /**
     * Delete a bus.
     */
    public function destroy($bus_number)
    {
        $bus = Bus::where('bus_number', $bus_number)->first();

        if (!$bus) {
            return response()->json([
                'message' => 'Bus not found.',
            ], 404);
        }

        DB::transaction(function () use ($bus_number, $bus) {
            User::where('role', 'driver')
                ->where('bus_number', $bus_number)
                ->update([
                    'bus_number' => null,
                ]);

            $bus->delete();
        });

        return response()->json([
            'message' => 'Bus deleted successfully.',
        ]);
    }
}
