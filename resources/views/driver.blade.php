
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Driver Dashboard | TrackMyBus</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --navy: #10243a;
            --navy-light: #193b52;
            --teal: #0eaa9b;
            --teal-dark: #078779;
            --background: #f3f7fa;
            --white: #ffffff;
            --text: #1b3042;
            --muted: #758697;
            --border: #e3ebef;
            --red: #df5c64;
            --green: #159b75;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: var(--background);
            color: var(--text);
            min-height: 100vh;
        }

        /* Navigation */

        nav {
            background: var(--navy);
            color: white;
            padding: 0 5%;
            min-height: 76px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap;
            box-shadow: 0 4px 20px rgba(16,36,58,.12);
        }

        .logo {
            font-size: 23px;
            font-weight: 800;
            letter-spacing: -.6px;
        }

        .logo span {
            color: #45d6c3;
        }

        .nav-links {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        nav a {
            color: #d4e0e8;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: .2s;
        }

        nav a:hover,
        nav a.active {
            color: #55ddcb;
        }

        /* Main Layout */

        .container {
            width: 92%;
            max-width: 1100px;
            margin: 42px auto;
        }

        .page-heading {
            margin-bottom: 28px;
        }

        .eyebrow {
            color: var(--teal-dark);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 1.7px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        h1 {
            color: var(--navy);
            font-size: 32px;
            letter-spacing: -.9px;
            margin-bottom: 10px;
        }

        .subtitle {
            color: var(--muted);
            font-size: 15px;
            line-height: 1.7;
        }

        /* Dashboard Card */

        .card {
            background: var(--white);
            padding: 32px;
            border-radius: 18px;
            border: 1px solid var(--border);
            box-shadow: 0 8px 30px rgba(16,36,58,.055);
            margin-bottom: 24px;
        }

        .section-heading {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 24px;
        }

        .section-icon {
            width: 46px;
            height: 46px;
            border-radius: 13px;
            display: grid;
            place-items: center;
            background: #e5f7f4;
            color: var(--teal-dark);
            font-size: 22px;
            flex-shrink: 0;
        }

        .section-heading h2 {
            color: var(--navy);
            font-size: 19px;
            margin-bottom: 5px;
        }

        .section-heading p {
            color: var(--muted);
            font-size: 13px;
        }

        /* Bus Information */

        .bus-info {
            padding: 21px;
            background: #f5fafb;
            border: 1px solid #e1eeee;
            border-radius: 13px;
            margin-bottom: 32px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #506579;
            font-size: 13px;
            font-weight: 700;
        }

        input {
            width: 100%;
            min-height: 49px;
            padding: 13px 15px;
            border: 1px solid #d9e3e9;
            border-radius: 9px;
            font-size: 15px;
            color: var(--text);
            background: white;
            outline: none;
        }

        input:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(14,170,155,.12);
        }

        input[readonly] {
            background: #edf3f6;
            color: var(--navy);
            font-weight: 700;
            cursor: not-allowed;
        }

        /* GPS Buttons */

        .buttons {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        button {
            min-height: 49px;
            padding: 13px 23px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-family: inherit;
            font-size: 14px;
            font-weight: 750;
            color: white;
            background: var(--teal);
            transition: .2s ease;
        }

        #startButton {
            background: var(--teal);
        }

        #startButton:hover:not(:disabled) {
            background: var(--teal-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(14,170,155,.2);
        }

        #stopButton {
            background: var(--red);
        }

        #stopButton:hover:not(:disabled) {
            background: #c7434d;
            transform: translateY(-2px);
        }

        button:disabled {
            opacity: .45;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* GPS Status */

        .gps-status {
            padding: 19px 21px;
            border-radius: 12px;
            background: #eaf6f7;
            border: 1px solid #d2ebec;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        .gps-status span {
            color: #526a7a;
            font-size: 14px;
            font-weight: 600;
        }

        #gpsStatus {
            color: var(--navy);
            font-size: 14px;
            font-weight: 800;
        }

        /* Location Details */

        .location-box {
            background: #fbfdfe;
            border: 1px solid var(--border);
            border-radius: 13px;
            padding: 23px;
        }

        .location-box h3 {
            color: var(--navy);
            font-size: 17px;
            margin-bottom: 20px;
        }

        .location-details {
            display: grid;
            grid-template-columns: repeat(3, minmax(0,1fr));
            gap: 15px;
        }

        .location-item {
            padding: 19px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 11px;
            min-width: 0;
            transition: .2s;
        }

        .location-item:hover {
            border-color: #a9dcd5;
            transform: translateY(-2px);
        }

        .location-item p {
            color: var(--muted);
            font-size: 12px;
            margin-bottom: 11px;
            font-weight: 650;
        }

        .location-item strong {
            color: var(--navy);
            font-size: 14px;
            overflow-wrap: anywhere;
        }

        /* Messages */

        .message {
            margin-top: 22px;
            padding: 15px 17px;
            border-radius: 10px;
            color: var(--navy);
            background: #f1f6f8;
            border: 1px solid var(--border);
            font-size: 14px;
            line-height: 1.7;
            overflow-wrap: anywhere;
        }

        .note {
            margin-top: 23px;
            padding-top: 19px;
            border-top: 1px solid var(--border);
            color: var(--muted);
            font-size: 12px;
            line-height: 1.9;
        }

        .note strong {
            color: var(--navy);
        }

        /* Footer */

        .footer {
            text-align: center;
            padding: 27px 15px;
            color: var(--muted);
            font-size: 12px;
        }

        /* Mobile Responsive */

        @media (max-width: 650px) {
            nav {
                padding: 17px 5%;
            }

            .nav-links {
                gap: 17px;
            }

            .container {
                width: 92%;
                margin: 29px auto;
            }

            h1 {
                font-size: 26px;
            }

            .card {
                padding: 22px;
            }

            .location-details {
                grid-template-columns: 1fr;
            }

            .buttons button {
                flex: 1;
            }
        }

        @media (max-width: 380px) {
            .logo {
                font-size: 20px;
            }

            nav {
                gap: 14px;
            }

            .nav-links {
                gap: 13px;
            }

            nav a {
                font-size: 12px;
            }

            .card {
                padding: 17px;
            }

            .buttons {
                flex-direction: column;
            }

            .buttons button {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <!-- Navigation -->
    <nav>
        <div class="logo">Track<span>MyBus</span></div>

        <div class="nav-links">
            <a href="/">Home</a>
            <a href="/tracking" class="active">Live Tracking</a>
        </div>
    </nav>

    <!-- Main Dashboard -->
    <main class="container">

        <div class="page-heading">
            <p class="eyebrow">Driver workspace</p>

            <h1>Driver Dashboard</h1>

            <p class="subtitle">
                Manage your assigned bus and share your current GPS
                location with passengers.
            </p>
        </div>

        <div class="card">

            <!-- Bus Information -->
            <div class="section-heading">
                <div class="section-icon">🚌</div>

                <div>
                    <h2>Bus Information</h2>
                    <p>Your currently assigned bus</p>
                </div>
            </div>

            <div class="bus-info">
                <label for="busNumber">Assigned Bus Number</label>

                <input
                    type="text"
                    id="busNumber"
                    value="{{ auth()->user()->bus_number }}"
                    placeholder="No bus assigned"
                    readonly
                >
            </div>

            <!-- GPS Tracking -->
            <div class="section-heading">
                <div class="section-icon">📍</div>

                <div>
                    <h2>GPS Tracking Control</h2>
                    <p>Manage your live location sharing</p>
                </div>
            </div>

            <div class="buttons">
                <button id="startButton" type="button">
                    ▶ Start GPS Tracking
                </button>

                <button id="stopButton" type="button" disabled>
                    ■ Stop Tracking
                </button>
            </div>

            <!-- GPS Connection Status -->
            <div class="gps-status">
                <span>GPS Connection Status</span>

                <strong id="gpsStatus" role="status" aria-live="polite">
                    Not started
                </strong>
            </div>

            <!-- Current Location -->
            <div class="location-box">

                <h3>📍 Current Location Details</h3>

                <div class="location-details">

                    <div class="location-item">
                        <p>Latitude</p>
                        <strong id="latitude">Waiting...</strong>
                    </div>

                    <div class="location-item">
                        <p>Longitude</p>
                        <strong id="longitude">Waiting...</strong>
                    </div>

                    <div class="location-item">
                        <p>Last Successful Update</p>
                        <strong id="lastUpdate">Waiting...</strong>
                    </div>

                </div>

            </div>

            <!-- Messages -->
            <div id="message" class="message" role="status" aria-live="polite">
                Welcome! Start GPS tracking when you are ready.
            </div>

            <p class="note">
                <strong>Important:</strong>
                Keep this page open while tracking.
                GPS tracking requires location permission and a secure
                browser context (HTTPS or localhost).
                Stop tracking when you finish.
            </p>

        </div>

    </main>

    <!-- Footer -->
    <footer class="footer">
        TrackMyBus &copy; {{ date('Y') }}. All rights reserved.
    </footer>

    <!-- Existing GPS Functionality -->
    <script>

        const busInput = document.getElementById('busNumber');
        const startButton = document.getElementById('startButton');
        const stopButton = document.getElementById('stopButton');
        const gpsStatus = document.getElementById('gpsStatus');
        const message = document.getElementById('message');

        let watchId = null;
        let lastSentAt = 0;
        let sendingLocation = false;
        let trackingActive = false;

        const MIN_UPDATE_INTERVAL = 5000;

        function setMessage(text) {
            message.textContent = text;
        }

        function setStatus(text) {
            gpsStatus.textContent = text;
        }

        async function sendLocation(latitude, longitude) {

            if (!trackingActive || sendingLocation) {
                return;
            }

            const busNumber = busInput.value.trim();

            if (!busNumber) {
                setStatus('No bus assigned');

                setMessage(
                    'Your account does not have an assigned bus. Contact the administrator.'
                );

                stopTracking();
                return;
            }

            sendingLocation = true;

            try {

                const response = await fetch(
                    `/api/buses/${encodeURIComponent(busNumber)}/location`,
                    {
                        method: 'PUT',
                        credentials: 'same-origin',

                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',

                            'X-CSRF-TOKEN':
                                document.querySelector(
                                    'meta[name="csrf-token"]'
                                ).content
                        },

                        body: JSON.stringify({
                            latitude: latitude,
                            longitude: longitude
                        })
                    }
                );

                const data = await response.json().catch(() => ({}));

                if (!response.ok) {

                    if (
                        response.status === 401 ||
                        response.status === 419
                    ) {
                        throw new Error(
                            'Your session may have expired. Please log in again.'
                        );
                    }

                    if (response.status === 403) {
                        throw new Error(
                            'Permission denied. Check your driver account and assigned bus.'
                        );
                    }

                    throw new Error(
                        data.message ||
                        `Location update failed (${response.status}).`
                    );
                }

                lastSentAt = Date.now();

                document.getElementById('latitude').textContent =
                    Number(latitude).toFixed(6);

                document.getElementById('longitude').textContent =
                    Number(longitude).toFixed(6);

                document.getElementById('lastUpdate').textContent =
                    new Date().toLocaleTimeString();

                setStatus(`Connected — Bus ${busNumber}`);

                setMessage(
                    `GPS location sent successfully for Bus ${busNumber}.`
                );

            } catch (error) {

                setStatus('Location update failed');

                setMessage(`Location update error: ${error.message}`);

            } finally {

                sendingLocation = false;

            }
        }

        function handlePosition(position) {

            if (!trackingActive) {
                return;
            }

            const now = Date.now();

            if (now - lastSentAt < MIN_UPDATE_INTERVAL) {
                return;
            }

            sendLocation(
                position.coords.latitude,
                position.coords.longitude
            );
        }

        function handleLocationError(error) {

            if (!trackingActive) {
                return;
            }

            let errorMessage =
                'Unable to get your GPS location.';

            if (error.code === 1) {

                errorMessage =
                    'Location permission denied. Allow location access in your browser.';

            } else if (error.code === 2) {

                errorMessage =
                    'Your device could not determine its current location.';

            } else if (error.code === 3) {

                errorMessage =
                    'GPS request timed out. Move to an area with a better GPS signal.';

            }

            setStatus('GPS error');
            setMessage(errorMessage);
        }

        function stopTracking() {

            trackingActive = false;

            if (watchId !== null) {

                navigator.geolocation.clearWatch(watchId);

                watchId = null;
            }

            startButton.disabled = false;
            stopButton.disabled = true;

            setStatus('Tracking stopped');

            setMessage('GPS tracking stopped.');
        }

        async function startTracking() {

            if (trackingActive) {
                return;
            }

            const busNumber = busInput.value.trim();

            if (!busNumber) {

                setStatus('No bus assigned');

                setMessage(
                    'No bus is assigned to your account. Ask the administrator to assign one.'
                );

                return;
            }

            if (!navigator.geolocation) {

                setStatus('GPS unavailable');

                setMessage(
                    'This browser does not support geolocation.'
                );

                return;
            }

            startButton.disabled = true;

            setStatus('Checking assigned bus...');

            setMessage('');

            try {

                const response = await fetch(
                    `/api/buses/${encodeURIComponent(busNumber)}`,
                    {
                        headers: {
                            'Accept': 'application/json'
                        },

                        credentials: 'same-origin'
                    }
                );

                if (!response.ok) {

                    throw new Error(
                        response.status === 404
                            ? `Bus ${busNumber} was not found.`
                            : `Could not verify bus (${response.status}).`
                    );
                }

                trackingActive = true;

                lastSentAt = 0;

                setStatus('Waiting for GPS location...');

                setMessage(
                    `Starting GPS tracking for Bus ${busNumber}.`
                );

                stopButton.disabled = false;

                watchId = navigator.geolocation.watchPosition(
                    handlePosition,
                    handleLocationError,
                    {
                        enableHighAccuracy: true,
                        timeout: 15000,
                        maximumAge: 0
                    }
                );

            } catch (error) {

                trackingActive = false;

                startButton.disabled = false;
                stopButton.disabled = true;

                setStatus('Unable to start');

                setMessage(error.message);

            }
        }

        // Button Events

        startButton.addEventListener(
            'click',
            startTracking
        );

        stopButton.addEventListener(
            'click',
            stopTracking
        );

        // Stop GPS monitoring when leaving the page

        window.addEventListener('pagehide', () => {

            if (watchId !== null) {

                navigator.geolocation.clearWatch(watchId);

            }

        });

    </script>

</body>
</html>
