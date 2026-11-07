
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/routes', function () {
    return view('routes');
})->name('routes');

/*
|--------------------------------------------------------------------------
| Bus API Routes
|--------------------------------------------------------------------------
*/

// Public bus search and bus details
Route::get('/api/buses', [BusController::class, 'index'])
    ->name('api.buses.index');

Route::get('/api/buses/{bus_number}', [BusController::class, 'show'])
    ->name('api.buses.show');

// Admin-only bus management
Route::post('/api/buses', [BusController::class, 'store'])
    ->middleware(['auth', 'role:admin'])
    ->name('api.buses.store');

Route::put('/api/buses/{bus_number}', [BusController::class, 'update'])
    ->middleware(['auth', 'role:admin'])
    ->name('api.buses.update');

Route::delete('/api/buses/{bus_number}', [BusController::class, 'destroy'])
    ->middleware(['auth', 'role:admin'])
    ->name('api.buses.destroy');

// Driver-only GPS location updates
Route::put('/api/buses/{bus_number}/location', [
    BusController::class,
    'updateLocation',
])
    ->middleware(['auth', 'role:driver'])
    ->name('api.buses.location');

// Admin-only driver assignment
Route::put('/api/buses/{bus_number}/assign-driver', [
    BusController::class,
    'assignDriver',
])
    ->middleware(['auth', 'role:admin'])
    ->name('api.buses.assign-driver');

/*
|--------------------------------------------------------------------------
| Passenger, Driver and Admin Pages
|--------------------------------------------------------------------------
*/

// Tracking requires login, but allows all authenticated roles
Route::get('/tracking', function () {
    return view('tracking');
})
    ->middleware('auth')
    ->name('tracking');

// Driver dashboard
Route::get('/driver', function () {
    return view('driver');
})
    ->middleware(['auth', 'role:driver'])
    ->name('driver');

// Admin dashboard
Route::get('/admin', function () {
    return view('admin');
})
    ->middleware(['auth', 'role:admin'])
    ->name('admin');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    $user = auth()->user();

    return match ($user->role) {
        'admin' => redirect()->route('admin'),
        'driver' => redirect()->route('driver'),
        'passenger' => redirect()->route('tracking'),
        default => redirect()->route('home'),
    };
})
    ->middleware('auth')
    ->name('dashboard');
