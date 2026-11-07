
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TrackMyBus | Admin Dashboard</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <style>
        * { box-sizing: border-box; }

        :root {
            --navy: #10243a;
            --navy-light: #193b52;
            --teal: #0eaa9b;
            --teal-dark: #078779;
            --background: #f2f6f8;
            --white: #ffffff;
            --text: #1b3042;
            --muted: #758697;
            --border: #e3ebef;
            --red: #df5c64;
            --purple: #7957c8;
            --green: #159b75;
        }

        body {
            margin: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background: var(--background);
            color: var(--text);
        }

        .navbar {
            min-height: 76px;
            background: var(--navy);
            color: white;
            padding: 15px 4%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            box-shadow: 0 4px 18px rgba(16,36,58,.15);
        }

        .navbar h2 {
            margin: 0;
            font-size: 23px;
            font-weight: 750;
        }

        .navbar a {
            color: #d4e0e8;
            text-decoration: none;
            margin-left: 22px;
            font-size: 14px;
            font-weight: 600;
            transition: .2s;
        }

        .navbar a:hover { color: #55ddcb; }

        .navbar form button {
            color: #55ddcb !important;
            font-weight: 700;
        }

        .container {
            width: 92%;
            max-width: 1450px;
            margin: 38px auto;
        }

        .container > h1 {
            font-size: 30px;
            color: var(--navy);
            letter-spacing: -.8px;
            margin-bottom: 28px;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(3,minmax(0,1fr));
            gap: 22px;
            margin-bottom: 30px;
        }

        .summary-card {
            position: relative;
            overflow: hidden;
            background: white;
            padding: 27px;
            border: 1px solid var(--border);
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(16,36,58,.045);
            transition: .25s;
        }

        .summary-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(16,36,58,.09);
        }

        .summary-card::after {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 5px;
            height: 100%;
            background: var(--teal);
        }

        .summary-card:nth-child(2)::after { background: var(--green); }
        .summary-card:nth-child(3)::after { background: var(--red); }

        .summary-card h3 {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
            font-weight: 600;
        }

        .summary-card p {
            margin: 17px 0 0;
            font-size: 37px;
            font-weight: 800;
            color: var(--navy);
        }

        .section {
            background: white;
            padding: 28px;
            border: 1px solid var(--border);
            border-radius: 16px;
            margin-bottom: 27px;
            box-shadow: 0 5px 20px rgba(16,36,58,.045);
        }

        .section h2 {
            margin: 0 0 24px;
            color: var(--navy);
            font-size: 21px;
            font-weight: 750;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2,minmax(0,1fr));
            gap: 17px;
        }

        input, select {
            width: 100%;
            min-height: 46px;
            padding: 12px 14px;
            border: 1px solid #d9e3e9;
            border-radius: 9px;
            background: #fbfdfe;
            color: var(--text);
            font-family: inherit;
            font-size: 14px;
            outline: none;
            transition: .2s;
        }

        input:focus, select:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(14,170,155,.12);
            background: white;
        }

        input::placeholder { color: #9aa9b5; }

        button {
            cursor: pointer;
            font-family: inherit;
            transition: .2s;
        }

        .add-btn {
            margin-top: 20px;
            padding: 13px 22px;
            background: var(--teal);
            color: white;
            border: none;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 700;
        }

        .add-btn:hover {
            background: var(--teal-dark);
            transform: translateY(-1px);
        }

        #addBusMessage {
            margin-top: 15px;
            font-size: 14px;
            font-weight: 600;
        }

        .bus-list {
            display: grid;
            grid-template-columns: repeat(2,minmax(0,1fr));
            gap: 20px;
        }

        .bus-card {
            min-width: 0;
            padding: 23px;
            background: #fbfdfe;
            border: 1px solid var(--border);
            border-radius: 13px;
            transition: .25s;
        }

        .bus-card:hover {
            border-color: #9bded6;
            box-shadow: 0 9px 23px rgba(16,36,58,.07);
            transform: translateY(-3px);
        }

        .bus-card h3 {
            margin: 0 0 18px;
            color: var(--navy);
            font-size: 19px;
            font-weight: 750;
        }

        .bus-card p {
            margin: 11px 0;
            color: #607386;
            font-size: 13px;
            line-height: 1.6;
            overflow-wrap: anywhere;
        }

        .bus-card p strong { color: var(--text); }

        .status { font-weight: 750; }
        .status-on-time { color: var(--green); }
        .status-delayed { color: var(--red); }

        .button-row {
            margin-top: 19px;
            display: flex;
            flex-wrap: wrap;
            gap: 9px;
        }

        .edit-btn, .delete-btn, .assign-btn {
            padding: 9px 13px;
            border: none;
            border-radius: 7px;
            color: white;
            font-size: 12px;
            font-weight: 700;
        }

        .edit-btn { background: #3279c9; }
        .edit-btn:hover { background: #235fa5; }
        .delete-btn { background: var(--red); }
        .delete-btn:hover { background: #c7434d; }
        .assign-btn { background: var(--purple); }
        .assign-btn:hover { background: #6141ad; }

        #map {
            width: 100%;
            height: 500px;
            border-radius: 13px;
            overflow: hidden;
            border: 1px solid var(--border);
            z-index: 1;
        }

        .error {
            color: var(--red);
            font-weight: 700;
            padding: 15px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            inset: 0;
            width: 100%;
            height: 100%;
            background: rgba(8,24,39,.68);
            align-items: center;
            justify-content: center;
            padding: 20px;
            backdrop-filter: blur(4px);
        }

        .modal-content {
            background: white;
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            border-radius: 17px;
            padding: 30px;
            box-shadow: 0 20px 60px rgba(0,0,0,.2);
        }

        .modal-content h2 {
            margin: 0 0 25px;
            color: var(--navy);
            font-size: 22px;
        }

        .modal-field { margin-bottom: 17px; }

        .modal-field label {
            display: block;
            margin-bottom: 8px;
            color: #506579;
            font-size: 13px;
            font-weight: 700;
        }

        .modal-buttons {
            display: flex;
            gap: 12px;
            margin-top: 23px;
        }

        .save-btn, .cancel-btn {
            flex: 1;
            min-height: 44px;
            padding: 11px;
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 700;
        }

        .save-btn { background: var(--teal); }
        .save-btn:hover { background: var(--teal-dark); }
        .cancel-btn { background: #758697; }
        .cancel-btn:hover { background: #596b7b; }

        .modal-message {
            margin-top: 13px;
            font-size: 13px;
            font-weight: 700;
        }

        @media(max-width:850px) {
            .summary { grid-template-columns: 1fr; }
            .bus-list { grid-template-columns: 1fr; }
            .navbar { flex-direction: column; gap: 15px; }
        }

        @media(max-width:600px) {
            .container { width: 94%; margin: 25px auto; }
            .container > h1 { font-size: 25px; }
            .navbar { padding: 20px 12px; }
            .navbar h2 { font-size: 21px; }
            .navbar a { margin: 0 6px; font-size: 12px; }
            .section { padding: 19px; }
            .form-grid { grid-template-columns: 1fr; }
            .summary-card { padding: 22px; }
            #map { height: 360px; }
            .modal-content { padding: 22px; }
            .modal-buttons { flex-direction: column; }
        }
    </style>
</head>

<body>

    <div class="navbar">
        <h2>TrackMyBus | Admin</h2>

        <div>
            <a href="/">Home</a>
            <a href="/routes">Routes</a>
            <a href="/admin">Admin</a>

            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" style="background:none;border:none;color:white;margin-left:20px;cursor:pointer;font-size:15px;">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <div class="container">

        <h1>Admin Dashboard</h1>

        <div class="summary">
            <div class="summary-card">
                <h3>Total Buses</h3>
                <p id="totalBuses">0</p>
            </div>

            <div class="summary-card">
                <h3>On Time</h3>
                <p id="onTimeBuses">0</p>
            </div>

            <div class="summary-card">
                <h3>Delayed</h3>
                <p id="delayedBuses">0</p>
            </div>
        </div>

        <div class="section">
            <h2>Add New Bus</h2>

            <form id="addBusForm">
                <div class="form-grid">
                    <input type="text" id="newBusNumber" placeholder="Bus Number" required>
                    <input type="text" id="newBusRoute" placeholder="Route" required>

                    <select id="newBusStatus">
                        <option value="On Time">On Time</option>
                        <option value="Delayed">Delayed</option>
                    </select>

                    <input type="number" step="any" id="newBusLatitude" placeholder="Current Latitude">
                    <input type="number" step="any" id="newBusLongitude" placeholder="Current Longitude">
                    <input type="number" step="any" id="destinationLatitude" placeholder="Destination Latitude">
                    <input type="number" step="any" id="destinationLongitude" placeholder="Destination Longitude">
                </div>

                <button type="submit" class="add-btn">Add Bus</button>
                <div id="addBusMessage"></div>
            </form>
        </div>

        <div class="section">
            <h2>Bus Management</h2>
            <div id="busList" class="bus-list">Loading buses...</div>
        </div>

        <div class="section">
            <h2>Live Bus Map</h2>
            <div id="map"></div>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <h2>Edit Bus</h2>

            <input type="hidden" id="editBusNumber">

            <div class="modal-field">
                <label>Bus Number</label>
                <input type="text" id="editBusNumberDisplay" readonly>
            </div>

            <div class="modal-field">
                <label>Route</label>
                <input type="text" id="editRoute" required>
            </div>

            <div class="modal-field">
                <label>Status</label>
                <select id="editStatus">
                    <option value="On Time">On Time</option>
                    <option value="Delayed">Delayed</option>
                </select>
            </div>

            <div class="modal-field">
                <label>Destination Latitude</label>
                <input type="number" step="any" id="editDestinationLatitude">
            </div>

            <div class="modal-field">
                <label>Destination Longitude</label>
                <input type="number" step="any" id="editDestinationLongitude">
            </div>

            <div id="editMessage" class="modal-message"></div>

            <div class="modal-buttons">
                <button type="button" class="save-btn" onclick="saveEditedBus()">Save Changes</button>
                <button type="button" class="cancel-btn" onclick="closeEditModal()">Cancel</button>
            </div>
        </div>
    </div>

    <!-- ASSIGN DRIVER MODAL -->
    <div id="assignModal" class="modal">
        <div class="modal-content">
            <h2>Assign Driver</h2>

            <input type="hidden" id="assignBusNumber">

            <div class="modal-field">
                <label>Bus Number</label>
                <input type="text" id="assignBusNumberDisplay" readonly>
            </div>

            <div class="modal-field">
                <label>Driver User ID</label>
                <input type="number" id="driverId" placeholder="Enter driver User ID" required>
            </div>

            <p style="font-size:13px;color:#64748b;">
                Enter the User ID of a user whose role is <strong>driver</strong>.
            </p>

            <div id="assignMessage" class="modal-message"></div>

            <div class="modal-buttons">
                <button type="button" class="save-btn" onclick="saveDriverAssignment()">Assign Driver</button>
                <button type="button" class="cancel-btn" onclick="closeAssignModal()">Cancel</button>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const map = L.map('map').setView([13.0827, 80.2707], 10);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const busMarkers = {};

        function getCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }

        function escapeJs(value) {
            return String(value)
                .replace(/\\/g, '\\\\')
                .replace(/'/g, "\\'")
                .replace(/\r/g, '\\r')
                .replace(/\n/g, '\\n');
        }

        async function loadBuses() {
            const busList = document.getElementById('busList');

            try {
                const response = await fetch('/api/buses', {
                    method: 'GET',
                    headers: { 'Accept': 'application/json' },
                    credentials: 'same-origin'
                });

                const buses = await response.json();

                if (!response.ok) {
                    throw new Error(buses.message || 'Failed to load buses');
                }

                busList.innerHTML = '';

                document.getElementById('totalBuses').textContent = buses.length;

                const onTime = buses.filter(bus => bus.status === 'On Time').length;
                const delayed = buses.filter(bus => bus.status === 'Delayed').length;

                document.getElementById('onTimeBuses').textContent = onTime;
                document.getElementById('delayedBuses').textContent = delayed;

                if (buses.length === 0) {
                    busList.innerHTML = '<p>No buses found.</p>';
                    return;
                }

                buses.forEach(bus => {
                    const card = document.createElement('div');
                    card.className = 'bus-card';

                    const statusClass = bus.status === 'Delayed'
                        ? 'status-delayed'
                        : 'status-on-time';

                    card.innerHTML = `
                        <h3>Bus ${bus.bus_number}</h3>

                        <p><strong>Route:</strong> ${bus.route}</p>
                        <p><strong>Driver:</strong> ${bus.driver_name ?? 'Not assigned'}</p>
                        <p><strong>Driver Email:</strong> ${bus.driver_email ?? 'N/A'}</p>

                        <p class="status ${statusClass}">
                            Status: ${bus.status}
                        </p>

                        <p><strong>Location:</strong>
                            ${bus.latitude ?? 'N/A'}, ${bus.longitude ?? 'N/A'}
                        </p>

                        <p><strong>Destination:</strong>
                            ${bus.destination_latitude ?? 'N/A'},
                            ${bus.destination_longitude ?? 'N/A'}
                        </p>

                        <div class="button-row">
                            <button class="edit-btn" type="button"
                                onclick="openEditModal(
                                    '${escapeJs(bus.bus_number)}',
                                    '${escapeJs(bus.route)}',
                                    '${escapeJs(bus.status)}',
                                    '${escapeJs(bus.destination_latitude ?? '')}',
                                    '${escapeJs(bus.destination_longitude ?? '')}'
                                )">
                                Edit Bus
                            </button>

                            <button class="delete-btn" type="button"
                                onclick="deleteBus('${escapeJs(bus.bus_number)}')">
                                Delete Bus
                            </button>

                            <button class="assign-btn" type="button"
                                onclick="openAssignModal('${escapeJs(bus.bus_number)}')">
                                Assign Driver
                            </button>
                        </div>
                    `;

                    busList.appendChild(card);

                    if (bus.latitude !== null && bus.longitude !== null) {
                        addBusMarker(bus);
                    }
                });

            } catch (error) {
                console.error(error);

                busList.innerHTML = `
                    <div class="error">
                        Unable to load buses.<br><br>${error.message}
                    </div>
                `;
            }
        }

        function addBusMarker(bus) {
            const position = [
                Number(bus.latitude),
                Number(bus.longitude)
            ];

            const popup = `
                <b>Bus ${bus.bus_number}</b><br>
                Route: ${bus.route}<br>
                Driver: ${bus.driver_name ?? 'Not assigned'}<br>
                Status: ${bus.status}
            `;

            if (busMarkers[bus.bus_number]) {
                busMarkers[bus.bus_number]
                    .setLatLng(position)
                    .setPopupContent(popup);
            } else {
                busMarkers[bus.bus_number] = L.marker(position)
                    .addTo(map)
                    .bindPopup(popup);
            }
        }

        document.getElementById('addBusForm').addEventListener('submit', async function(event) {
            event.preventDefault();

            const message = document.getElementById('addBusMessage');

            const busData = {
                bus_number: document.getElementById('newBusNumber').value.trim(),
                route: document.getElementById('newBusRoute').value.trim(),
                status: document.getElementById('newBusStatus').value,
                latitude: document.getElementById('newBusLatitude').value || null,
                longitude: document.getElementById('newBusLongitude').value || null,
                destination_latitude: document.getElementById('destinationLatitude').value || null,
                destination_longitude: document.getElementById('destinationLongitude').value || null
            };

            try {
                const response = await fetch('/api/buses', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken()
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify(busData)
                });

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.message || 'Failed to add bus');
                }

                message.style.color = '#16a34a';
                message.textContent = `Bus ${result.bus_number} added successfully!`;

                document.getElementById('addBusForm').reset();
                await loadBuses();

            } catch (error) {
                console.error(error);
                message.style.color = '#dc2626';
                message.textContent = error.message || 'Unable to add bus.';
            }
        });

        function openEditModal(busNumber, route, status, destinationLatitude, destinationLongitude) {
            document.getElementById('editBusNumber').value = busNumber;
            document.getElementById('editBusNumberDisplay').value = busNumber;
            document.getElementById('editRoute').value = route;
            document.getElementById('editStatus').value = status;
            document.getElementById('editDestinationLatitude').value = destinationLatitude;
            document.getElementById('editDestinationLongitude').value = destinationLongitude;
            document.getElementById('editMessage').textContent = '';
            document.getElementById('editModal').style.display = 'flex';
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        async function saveEditedBus() {
            const busNumber = document.getElementById('editBusNumber').value;
            const route = document.getElementById('editRoute').value.trim();
            const status = document.getElementById('editStatus').value;

            const destinationLatitude =
                document.getElementById('editDestinationLatitude').value.trim();

            const destinationLongitude =
                document.getElementById('editDestinationLongitude').value.trim();

            const message = document.getElementById('editMessage');

            if (!route) {
                message.style.color = '#dc2626';
                message.textContent = 'Route cannot be empty.';
                return;
            }

            try {
                const response = await fetch(
                    `/api/buses/${encodeURIComponent(busNumber)}`,
                    {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': getCsrfToken()
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify({
                            route: route,
                            status: status,
                            destination_latitude: destinationLatitude || null,
                            destination_longitude: destinationLongitude || null
                        })
                    }
                );

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.message || 'Failed to update bus.');
                }

                message.style.color = '#16a34a';
                message.textContent = 'Bus updated successfully!';

                await loadBuses();

                setTimeout(function() {
                    closeEditModal();
                }, 800);

            } catch (error) {
                console.error(error);
                message.style.color = '#dc2626';
                message.textContent = error.message || 'Unable to update bus.';
            }
        }

        function openAssignModal(busNumber) {
            document.getElementById('assignBusNumber').value = busNumber;
            document.getElementById('assignBusNumberDisplay').value = busNumber;
            document.getElementById('driverId').value = '';
            document.getElementById('assignMessage').textContent = '';
            document.getElementById('assignModal').style.display = 'flex';
        }

        function closeAssignModal() {
            document.getElementById('assignModal').style.display = 'none';
        }

        async function saveDriverAssignment() {
            const busNumber = document.getElementById('assignBusNumber').value;
            const driverId = document.getElementById('driverId').value.trim();
            const message = document.getElementById('assignMessage');

            if (!driverId) {
                message.style.color = '#dc2626';
                message.textContent = 'Please enter the driver User ID.';
                return;
            }

            if (!/^\d+$/.test(driverId)) {
                message.style.color = '#dc2626';
                message.textContent = 'Driver User ID must be a number.';
                return;
            }

            try {
                const response = await fetch(
                    `/api/buses/${encodeURIComponent(busNumber)}/assign-driver`,
                    {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': getCsrfToken()
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify({
                            driver_id: Number(driverId)
                        })
                    }
                );

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.message || 'Failed to assign driver.');
                }

                message.style.color = '#16a34a';
                message.textContent =
                    `Driver ${result.driver.name} assigned successfully!`;

                await loadBuses();

                setTimeout(function() {
                    closeAssignModal();
                }, 800);

            } catch (error) {
                console.error(error);
                message.style.color = '#dc2626';
                message.textContent = error.message || 'Unable to assign driver.';
            }
        }

        async function deleteBus(busNumber) {
            const confirmed = window.confirm(
                `Are you sure you want to delete Bus ${busNumber}?`
            );

            if (!confirmed) return;

            try {
                const response = await fetch(
                    `/api/buses/${encodeURIComponent(busNumber)}`,
                    {
                        method: 'DELETE',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': getCsrfToken()
                        },
                        credentials: 'same-origin'
                    }
                );

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.message || 'Failed to delete bus.');
                }

                alert(`Bus ${busNumber} deleted successfully!`);
                await loadBuses();

            } catch (error) {
                console.error(error);
                alert(error.message || 'Unable to delete bus.');
            }
        }

        window.addEventListener('click', function(event) {
            const editModal = document.getElementById('editModal');
            const assignModal = document.getElementById('assignModal');

            if (event.target === editModal) {
                closeEditModal();
            }

            if (event.target === assignModal) {
                closeAssignModal();
            }
        });

        loadBuses();

        setInterval(function() {
            loadBuses();
        }, 30000);
    </script>

</body>
</html>
