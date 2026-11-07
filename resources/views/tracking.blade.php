<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>TrackMyBus | Live Bus Tracking</title>

    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    >

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f3f6fb;
            color: #1f2937;
        }

        header {
            background: #102a43;
            color: white;
            padding: 18px 6%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        header h1 {
            font-size: 25px;
        }

        nav {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-size: 15px;
        }

        nav a:hover {
            color: #60a5fa;
        }

        .container {
            max-width: 1250px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .page-heading {
            margin-bottom: 22px;
        }

        .page-heading h2 {
            font-size: 28px;
            margin-bottom: 8px;
            color: #102a43;
        }

        .page-heading p {
            color: #64748b;
            line-height: 1.6;
        }

        .search-box {
            background: white;
            padding: 22px;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.06);
            margin-bottom: 22px;
        }

        .search-box label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .search-controls {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .search-controls input {
            flex: 1;
            min-width: 200px;
            padding: 13px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            font-size: 16px;
        }

        button {
            border: none;
            border-radius: 7px;
            padding: 13px 20px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        .search-button {
            background: #2563eb;
            color: white;
        }

        .search-button:hover {
            background: #1d4ed8;
        }

        .location-button {
            background: #059669;
            color: white;
        }

        .location-button:hover {
            background: #047857;
        }

        .message {
            margin-top: 12px;
            font-size: 14px;
            line-height: 1.5;
        }

        .error-message {
            color: #dc2626;
        }

        .success-message {
            color: #047857;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 22px;
        }

        .info-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.05);
            min-width: 0;
        }

        .info-card h3 {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .info-card p {
            color: #102a43;
            font-size: 20px;
            font-weight: bold;
            overflow-wrap: anywhere;
        }

        .status-badge {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 14px !important;
            font-weight: bold;
        }

        .status-ontime {
            color: #047857 !important;
            background: #d1fae5;
        }

        .status-delayed {
            color: #b91c1c !important;
            background: #fee2e2;
        }

        .status-unknown {
            color: #92400e !important;
            background: #fef3c7;
        }

        .map-section {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 22px;
        }

        .map-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 15px;
        }

        .map-heading h3 {
            color: #102a43;
            font-size: 20px;
        }

        .map-heading span {
            color: #64748b;
            font-size: 13px;
        }

        #map {
            width: 100%;
            height: 480px;
            border-radius: 9px;
            z-index: 1;
        }

        .bus-list-section {
            background: white;
            padding: 22px;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        .bus-list-section h3 {
            color: #102a43;
            margin-bottom: 15px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 500px;
        }

        th, td {
            text-align: left;
            padding: 13px;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background: #f1f5f9;
            color: #334155;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        .select-bus {
            background: #2563eb;
            color: white;
            padding: 8px 12px;
            font-size: 13px;
        }

        footer {
            background: #102a43;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 30px;
        }

        .legend {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            margin-top: 15px;
            color: #475569;
            font-size: 13px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .legend-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
        }

        @media (max-width: 768px) {
            header {
                padding: 18px 5%;
            }

            .container {
                margin-top: 20px;
                padding: 0 12px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            #map {
                height: 350px;
            }

            .page-heading h2 {
                font-size: 24px;
            }

            nav {
                gap: 12px;
            }
        }
    </style>
</head>

<body>

<header>
    <h1>🚌 TrackMyBus</h1>

    <nav>
        <a href="/">Home</a>
        <a href="/routes">Routes</a>
        <a href="/tracking">Live Tracking</a>
        <a href="/login">Login</a>
    </nav>
</header>

<main class="container">

    <section class="page-heading">
        <h2>Live Bus Tracking</h2>
        <p>
            Search for a bus, view its available details,
            and explore its location on the map.
        </p>
    </section>

    <section class="search-box">
        <label for="busNumber">Enter Bus Number</label>

        <div class="search-controls">
            <input
                type="text"
                id="busNumber"
                placeholder="Example: 120"
                autocomplete="off"
            >

            <button
                type="button"
                class="search-button"
                id="searchButton"
            >
                Search Bus
            </button>

            <button
                type="button"
                class="location-button"
                id="locationButton"
            >
                My Location
            </button>
        </div>

        <p id="message" class="message" role="status" aria-live="polite"></p>
    </section>

    <section class="info-grid">

        <div class="info-card">
            <h3>Bus Number</h3>
            <p id="displayBusNumber">Not selected</p>
        </div>

        <div class="info-card">
            <h3>Route</h3>
            <p id="displayRoute">Not available</p>
        </div>

        <div class="info-card">
            <h3>Bus Status</h3>
            <p>
                <span id="displayStatus" class="status-badge status-unknown">
                    Unknown
                </span>
            </p>
        </div>

        <div class="info-card">
            <h3>Current GPS Location</h3>
            <p id="displayLocation">Not available</p>
        </div>

        <div class="info-card">
            <h3>Estimated Arrival</h3>
            <p id="displayETA">Not available</p>
        </div>

        <div class="info-card">
            <h3>Last GPS Update</h3>
            <p id="displayUpdated" style="font-size: 16px;">
                Not updated
            </p>
        </div>

    </section>

    <section class="map-section">
        <div class="map-heading">
            <h3>Bus Locations Map</h3>
            <span>Map data and demo routes may not represent live BMTC tracking.</span>
        </div>

        <div id="map" aria-label="Map showing available bus locations"></div>

        <div class="legend">
            <div class="legend-item">
                <span class="legend-dot" style="background: #2563eb;"></span>
                Available buses
            </div>

            <div class="legend-item">
                <span class="legend-dot" style="background: #dc2626;"></span>
                Selected bus
            </div>

            <div class="legend-item">
                <span class="legend-dot" style="background: #059669;"></span>
                Route stops
            </div>
        </div>
    </section>

    <section class="bus-list-section">
        <h3>Available Buses</h3>

        <p id="busListMessage" class="message">Loading buses...</p>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Bus Number</th>
                        <th>Route</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody id="busTableBody"></tbody>
            </table>
        </div>
    </section>

</main>

<footer>
    <p>TrackMyBus Public Transit System</p>
    <p style="margin-top: 7px; font-size: 13px;">
        Demonstration project — location accuracy depends on the available data.
    </p>
</footer>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    let map = null;
    let busMarker = null;
    let userMarker = null;
    let currentBusNumber = null;

    let allBusMarkers = {};
    let routeLine = null;
    let routeStopMarkers = [];

    let allBuses = [];
    let refreshTimer = null;

    /*
    |--------------------------------------------------------------------------
    | BUS 114 DEMONSTRATION STOPS
    |--------------------------------------------------------------------------
    */

    const bus114Stops = [
        { name: "K.R. Market", lat: 12.9637, lng: 77.5763 },
        { name: "Town Hall", lat: 12.9658, lng: 77.5860 },
        { name: "Cubbon Park", lat: 12.9763, lng: 77.5929 },
        { name: "Vidhana Soudha", lat: 12.9797, lng: 77.5909 },
        { name: "Palace Road", lat: 12.9890, lng: 77.5880 },
        { name: "Sadashivanagar", lat: 13.0060, lng: 77.5800 },
        { name: "Sultanpalya", lat: 13.0110, lng: 77.6020 }
    ];

    /*
    |--------------------------------------------------------------------------
    | MAP INITIALIZATION
    |--------------------------------------------------------------------------
    */

    function initializeMap() {
        if (typeof L === "undefined") {
            showMessage(
                "The map library could not load. Check your internet connection.",
                true
            );
            return;
        }

        map = L.map("map").setView([12.9716, 77.5946], 12);

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: "&copy; OpenStreetMap contributors",
            maxZoom: 19
        }).addTo(map);
    }

    /*
    |--------------------------------------------------------------------------
    | MESSAGE HELPERS
    |--------------------------------------------------------------------------
    */

    function showMessage(message, isError = false) {
        const element = document.getElementById("message");

        element.textContent = message;
        element.className = isError
            ? "message error-message"
            : "message success-message";
    }

    function showBusListMessage(message) {
        document.getElementById("busListMessage").textContent = message;
    }

    /*
    |--------------------------------------------------------------------------
    | BUS DATA HELPERS
    |--------------------------------------------------------------------------
    */

    function getBusNumber(bus) {
        return String(
            bus.bus_number ??
            bus.busNumber ??
            bus.number ??
            bus.vehicle_number ??
            ""
        );
    }

    function getBusRoute(bus) {
        return (
            bus.route ??
            bus.route_name ??
            bus.name ??
            bus.destination ??
            "Route not available"
        );
    }

    function getBusStatus(bus) {
        return (
            bus.status ??
            bus.bus_status ??
            bus.current_status ??
            "Unknown"
        );
    }

    function getBusLatitude(bus) {
        const value =
            bus.latitude ??
            bus.lat ??
            bus.current_latitude;

        if (value === null || value === undefined || value === "") {
            return null;
        }

        const number = Number(value);

        return Number.isFinite(number) ? number : null;
    }

    function getBusLongitude(bus) {
        const value =
            bus.longitude ??
            bus.lng ??
            bus.lon ??
            bus.current_longitude;

        if (value === null || value === undefined || value === "") {
            return null;
        }

        const number = Number(value);

        return Number.isFinite(number) ? number : null;
    }

    function hasValidCoordinates(bus) {
        const lat = getBusLatitude(bus);
        const lng = getBusLongitude(bus);

        return (
            lat !== null &&
            lng !== null &&
            lat >= -90 &&
            lat <= 90 &&
            lng >= -180 &&
            lng <= 180 &&
            !(lat === 0 && lng === 0)
        );
    }

    function normalizeBusResponse(response) {
        if (Array.isArray(response)) {
            return response;
        }

        if (response && Array.isArray(response.data)) {
            return response.data;
        }

        if (response && Array.isArray(response.buses)) {
            return response.buses;
        }

        if (response && response.bus) {
            return [response.bus];
        }

        if (
            response &&
            typeof response === "object" &&
            (
                response.bus_number !== undefined ||
                response.busNumber !== undefined
            )
        ) {
            return [response];
        }

        return [];
    }

    /*
    |--------------------------------------------------------------------------
    | LOAD ALL BUSES
    |--------------------------------------------------------------------------
    */

    async function loadAllBuses() {
        try {
            const response = await fetch("/api/buses", {
                headers: {
                    "Accept": "application/json"
                },
                cache: "no-store"
            });

            if (!response.ok) {
                throw new Error("Could not load buses. HTTP " + response.status);
            }

            const result = await response.json();

            allBuses = normalizeBusResponse(result);

            updateAllBusMarkers();
            updateBusTable();

            showBusListMessage(
                allBuses.length
                    ? "Showing " + allBuses.length + " bus record(s)."
                    : "No buses were returned by the API."
            );

        } catch (error) {
            console.error("Error loading all buses:", error);

            showBusListMessage(
                "Unable to load buses. Check that the Laravel server and API are running."
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE ALL BUS MARKERS
    |--------------------------------------------------------------------------
    */

    function updateAllBusMarkers() {
        if (!map) return;

        const busesWithCoordinates = allBuses.filter(hasValidCoordinates);

        const activeNumbers = new Set(
            busesWithCoordinates.map(getBusNumber)
        );

        Object.keys(allBusMarkers).forEach(function(number) {
            if (!activeNumbers.has(number)) {
                map.removeLayer(allBusMarkers[number]);
                delete allBusMarkers[number];
            }
        });

        busesWithCoordinates.forEach(function(bus) {
            const number = getBusNumber(bus);

            if (!number) return;

            const lat = getBusLatitude(bus);
            const lng = getBusLongitude(bus);

            const popup =
                "<strong>Bus " + escapeHTML(number) + "</strong><br>" +
                escapeHTML(getBusRoute(bus)) + "<br>" +
                "Status: " + escapeHTML(getBusStatus(bus));

            if (allBusMarkers[number]) {
                allBusMarkers[number].setLatLng([lat, lng]);
                allBusMarkers[number].setPopupContent(popup);
            } else {
                allBusMarkers[number] = L.marker([lat, lng])
                    .addTo(map)
                    .bindPopup(popup);
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | BUS TABLE
    |--------------------------------------------------------------------------
    */

    function updateBusTable() {
        const tbody = document.getElementById("busTableBody");

        tbody.innerHTML = "";

        if (!allBuses.length) {
            tbody.innerHTML =
                '<tr><td colspan="4">No bus records available.</td></tr>';
            return;
        }

        allBuses.forEach(function(bus) {
            const number = getBusNumber(bus);
            const row = document.createElement("tr");

            const numberCell = document.createElement("td");
            numberCell.textContent = number || "Unknown";

            const routeCell = document.createElement("td");
            routeCell.textContent = getBusRoute(bus);

            const statusCell = document.createElement("td");
            statusCell.textContent = getBusStatus(bus);

            const actionCell = document.createElement("td");
            const button = document.createElement("button");

            button.type = "button";
            button.className = "select-bus";
            button.textContent = "Track";

            button.addEventListener("click", function() {
                document.getElementById("busNumber").value = number;
                trackBus(number);
            });

            actionCell.appendChild(button);

            row.appendChild(numberCell);
            row.appendChild(routeCell);
            row.appendChild(statusCell);
            row.appendChild(actionCell);

            tbody.appendChild(row);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | SEARCH BUS
    |--------------------------------------------------------------------------
    */

    document.getElementById("searchButton").addEventListener("click", function() {
        const number = document.getElementById("busNumber").value.trim();

        if (!number) {
            showMessage("Please enter a bus number.", true);
            return;
        }

        trackBus(number);
    });

    document.getElementById("busNumber").addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();

            const number = this.value.trim();

            if (!number) {
                showMessage("Please enter a bus number.", true);
                return;
            }

            trackBus(number);
        }
    });

    /*
    |--------------------------------------------------------------------------
    | LOAD SELECTED BUS
    |--------------------------------------------------------------------------
    */

    async function trackBus(busNumber) {
        if (!busNumber) return;

        currentBusNumber = String(busNumber).trim();

        showMessage("Searching for bus " + currentBusNumber + "...");

        try {
            const response = await fetch(
                "/api/buses/" + encodeURIComponent(currentBusNumber),
                {
                    headers: {
                        "Accept": "application/json"
                    },
                    cache: "no-store"
                }
            );

            if (!response.ok) {
                if (response.status === 404) {
                    throw new Error("Bus " + currentBusNumber + " was not found.");
                }

                throw new Error(
                    "Unable to fetch bus details. HTTP " + response.status
                );
            }

            const result = await response.json();

            let bus = result.bus ?? result.data ?? result;

            if (Array.isArray(bus)) {
                bus = bus[0];
            }

            if (bus && bus.data && !Array.isArray(bus.data)) {
                bus = bus.data;
            }

            if (!bus || typeof bus !== "object") {
                throw new Error("The API returned invalid bus data.");
            }

            displayBusDetails(bus);
            updateBusMarker(bus);

            // Refresh the selected bus in the shared bus list too.
            const index = allBuses.findIndex(function(item) {
                return getBusNumber(item) === currentBusNumber;
            });

            if (index !== -1) {
                allBuses[index] = {
                    ...allBuses[index],
                    ...bus
                };
            } else {
                allBuses.push(bus);
            }

            updateAllBusMarkers();
            updateBusTable();

            await drawRouteForBus(currentBusNumber);

            showMessage("Bus " + currentBusNumber + " details loaded.");

        } catch (error) {
            console.error("Bus loading error:", error);

            showMessage(
                error.message || "Unable to load bus details.",
                true
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | DISPLAY BUS DETAILS
    |--------------------------------------------------------------------------
    */

    function displayBusDetails(bus) {
        document.getElementById("displayBusNumber").textContent =
            getBusNumber(bus) || currentBusNumber || "Unknown";

        document.getElementById("displayRoute").textContent =
            getBusRoute(bus);

        // Status
        const status = getBusStatus(bus);
        const statusElement = document.getElementById("displayStatus");

        statusElement.textContent = status;
        statusElement.className = "status-badge";

        const lowerStatus = String(status).toLowerCase();

        if (
            lowerStatus.includes("on time") ||
            lowerStatus.includes("ontime") ||
            lowerStatus === "on-time"
        ) {
            statusElement.classList.add("status-ontime");
        } else if (
            lowerStatus.includes("delay") ||
            lowerStatus.includes("late")
        ) {
            statusElement.classList.add("status-delayed");
        } else {
            statusElement.classList.add("status-unknown");
        }

        // GPS coordinates from the database
        const latitude = getBusLatitude(bus);
        const longitude = getBusLongitude(bus);

        const location =
            bus.current_location ??
            bus.current_stop ??
            (
                hasValidCoordinates(bus)
                    ? `${latitude.toFixed(6)}, ${longitude.toFixed(6)}`
                    : "Location not available"
            );

        document.getElementById("displayLocation").textContent =
            typeof location === "string"
                ? location
                : "Location not available";

        // ETA: your API uses eta_minutes
        let eta = "Not available";

        if (
            bus.eta_minutes !== null &&
            bus.eta_minutes !== undefined &&
            bus.eta_minutes !== ""
        ) {
            eta = `${bus.eta_minutes} minutes`;
        } else {
            const alternativeETA =
                bus.eta ??
                bus.estimated_arrival ??
                bus.estimated_time ??
                bus.arrival_time;

            if (alternativeETA !== undefined && alternativeETA !== null) {
                eta = alternativeETA;
            }
        }

        document.getElementById("displayETA").textContent = String(eta);

        // Actual GPS update time from the API
        const updatedAt =
            bus.location_updated_at ??
            bus.updated_at ??
            bus.updatedAt;

        if (updatedAt) {
            const parsedDate = new Date(
                String(updatedAt).replace(" ", "T")
            );

            document.getElementById("displayUpdated").textContent =
                Number.isNaN(parsedDate.getTime())
                    ? String(updatedAt)
                    : parsedDate.toLocaleString();
        } else {
            document.getElementById("displayUpdated").textContent =
                "Not updated";
        }
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE SELECTED BUS MARKER
    |--------------------------------------------------------------------------
    */

    function updateBusMarker(bus) {
        if (!map) return;

        if (!hasValidCoordinates(bus)) {
            console.warn("The selected bus has no valid coordinates:", bus);

            document.getElementById("displayLocation").textContent =
                "Coordinates not available";

            return;
        }

        const lat = getBusLatitude(bus);
        const lng = getBusLongitude(bus);
        const position = [lat, lng];

        if (busMarker) {
            map.removeLayer(busMarker);
            busMarker = null;
        }

        busMarker = L.marker(position, {
            zIndexOffset: 1000
        })
        .addTo(map)
        .bindPopup(
            "<strong>Selected Bus " +
            escapeHTML(getBusNumber(bus) || currentBusNumber) +
            "</strong><br>" +
            escapeHTML(getBusRoute(bus))
        );

        busMarker.openPopup();

        // Show the bus's current coordinates on the map.
        map.setView(position, 15);
    }

    /*
    |--------------------------------------------------------------------------
    | DRAW ROUTE FOR ANY BUS
    |--------------------------------------------------------------------------
    */

    async function drawRouteForBus(busNumber) {
        if (!map) return;

        clearRoute();

        const selectedNumber = String(busNumber);

        const bus = allBuses.find(function(item) {
            return getBusNumber(item) === selectedNumber;
        });

        if (!bus) {
            console.warn("Bus not found:", selectedNumber);
            return;
        }

        const startLat = getBusLatitude(bus);
        const startLng = getBusLongitude(bus);

        const destinationLat = Number(bus.destination_latitude);
        const destinationLng = Number(bus.destination_longitude);

        if (
            startLat === null ||
            startLng === null ||
            !Number.isFinite(destinationLat) ||
            !Number.isFinite(destinationLng) ||
            Math.abs(destinationLat) > 90 ||
            Math.abs(destinationLng) > 180 ||
            (destinationLat === 0 && destinationLng === 0)
        ) {
            console.warn(
                "Starting or destination coordinates are unavailable for bus " +
                selectedNumber
            );
            return;
        }

        // Demonstration stops for bus 114 only.
        if (selectedNumber === "114") {
            bus114Stops.forEach(function(stop, index) {
                const marker = L.circleMarker(
                    [stop.lat, stop.lng],
                    {
                        radius: 7,
                        color: "#047857",
                        fillColor: "#10b981",
                        fillOpacity: 1,
                        weight: 2
                    }
                )
                .addTo(map)
                .bindPopup(
                    "<strong>Demo Stop " + (index + 1) + "</strong><br>" +
                    escapeHTML(stop.name)
                );

                routeStopMarkers.push(marker);
            });
        }

        try {
            const coordinates =
                startLng + "," + startLat + ";" +
                destinationLng + "," + destinationLat;

            const url =
                "https://router.project-osrm.org/route/v1/driving/" +
                coordinates +
                "?overview=full&geometries=geojson";

            const response = await fetch(url);

            if (!response.ok) {
                throw new Error("Road-routing service unavailable.");
            }

            const result = await response.json();

            if (
                result.code !== "Ok" ||
                !result.routes ||
                result.routes.length === 0
            ) {
                throw new Error("No road route was returned.");
            }

            const roadCoordinates =
                result.routes[0].geometry.coordinates.map(function(point) {
                    return [point[1], point[0]];
                });

            routeLine = L.polyline(roadCoordinates, {
                color: "#2563eb",
                weight: 5,
                opacity: 0.85
            }).addTo(map);

            const destinationName = getBusRoute(bus).split(" - ").pop();

            const destinationMarker = L.marker([
                destinationLat,
                destinationLng
            ])
            .addTo(map)
            .bindPopup(
                "<strong>Bus " +
                escapeHTML(selectedNumber) +
                " Destination</strong><br>" +
                escapeHTML(destinationName)
            );

            routeStopMarkers.push(destinationMarker);

            map.fitBounds(routeLine.getBounds(), {
                padding: [35, 35]
            });

        } catch (error) {
            console.warn("Road route unavailable:", error);

            // Fallback: straight line, not a road-following route.
            routeLine = L.polyline(
                [
                    [startLat, startLng],
                    [destinationLat, destinationLng]
                ],
                {
                    color: "#2563eb",
                    weight: 4,
                    dashArray: "8, 8"
                }
            ).addTo(map);

            const destinationMarker = L.marker([
                destinationLat,
                destinationLng
            ])
            .addTo(map)
            .bindPopup(
                "<strong>Bus " +
                escapeHTML(selectedNumber) +
                " Destination</strong>"
            );

            routeStopMarkers.push(destinationMarker);

            map.fitBounds(routeLine.getBounds(), {
                padding: [35, 35]
            });
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CLEAR PREVIOUS ROUTE
    |--------------------------------------------------------------------------
    */

    function clearRoute() {
        if (routeLine && map) {
            map.removeLayer(routeLine);
            routeLine = null;
        }

        routeStopMarkers.forEach(function(marker) {
            if (map) {
                map.removeLayer(marker);
            }
        });

        routeStopMarkers = [];
    }

    /*
    |--------------------------------------------------------------------------
    | PASSENGER CURRENT LOCATION
    |--------------------------------------------------------------------------
    */

    document.getElementById("locationButton").addEventListener(
        "click",
        showUserLocation
    );

    function showUserLocation() {
        if (!navigator.geolocation) {
            showMessage(
                "Your browser does not support location services.",
                true
            );
            return;
        }

        showMessage("Requesting your current location...");

        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                const userPosition = [lat, lng];

                if (userMarker && map) {
                    map.removeLayer(userMarker);
                }

                userMarker = L.marker(userPosition)
                    .addTo(map)
                    .bindPopup("Your current location");

                userMarker.openPopup();
                map.setView(userPosition, 15);

                showMessage(
                    "Your current location is displayed on the map."
                );
            },
            function(error) {
                let message = "Unable to access your location.";

                if (error.code === error.PERMISSION_DENIED) {
                    message = "Location permission was denied.";
                } else if (error.code === error.POSITION_UNAVAILABLE) {
                    message = "Your current location is unavailable.";
                } else if (error.code === error.TIMEOUT) {
                    message = "Location request timed out.";
                }

                showMessage(message, true);
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 30000
            }
        );
    }

    /*
    |--------------------------------------------------------------------------
    | HTML ESCAPE HELPER
    |--------------------------------------------------------------------------
    */

    function escapeHTML(value) {
        return String(value ?? "")
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    /*
    |--------------------------------------------------------------------------
    | AUTOMATIC REFRESH
    |--------------------------------------------------------------------------
    */

    async function refreshData() {
        await loadAllBuses();

        if (currentBusNumber) {
            await trackBus(currentBusNumber);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | START APPLICATION
    |--------------------------------------------------------------------------
    */

    async function startTrackingApp() {
        initializeMap();

        if (!map) return;

        await loadAllBuses();

        const urlParams = new URLSearchParams(window.location.search);
        const busFromURL = urlParams.get("bus");

        if (busFromURL) {
            document.getElementById("busNumber").value = busFromURL;
            await trackBus(busFromURL);
        }

        if (refreshTimer) {
            clearInterval(refreshTimer);
        }

        refreshTimer = setInterval(function() {
            refreshData();
        }, 30000);
    }

    document.addEventListener("DOMContentLoaded", function() {
        startTrackingApp();
    });
</script>

</body>
</html>