
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="theme-color" content="#10243a">
    <meta name="description" content="Explore available bus routes and track your journey with TrackMyBus.">

    <title>Bus Routes | TrackMyBus</title>

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
            --background: #f2f6f8;
            --white: #ffffff;
            --text: #1b3042;
            --muted: #758697;
            --border: #e3ebef;
            --green: #159b75;
            --red: #df5c64;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: var(--background);
            color: var(--text);
            min-height: 100vh;
        }

        a {
            text-decoration: none;
        }

        button {
            font-family: inherit;
        }

        /* NAVIGATION */

        .navbar {
            background: var(--navy);
            padding: 19px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 18px;
            box-shadow: 0 4px 18px rgba(16,36,58,.15);
        }

        .logo {
            color: white;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -.7px;
            white-space: nowrap;
        }

        .logo span {
            color: var(--teal);
        }

        .nav-links {
            display: flex;
            gap: 25px;
            align-items: center;
            flex-wrap: wrap;
        }

        .nav-links a {
            color: #d4e0e8;
            font-size: 14px;
            font-weight: 600;
            transition: .2s;
        }

        .nav-links a:hover {
            color: #55ddcb;
        }

        .login-btn {
            display: inline-block;
            background: var(--teal);
            color: white !important;
            padding: 10px 19px;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: .2s;
        }

        .login-btn:hover {
            background: var(--teal-dark);
        }

        /* PAGE HEADER */

        .page-header {
            padding: 65px 20px 45px;
            text-align: center;
            background:
                radial-gradient(circle at 50% 0%, rgba(14,170,155,.09), transparent 55%);
        }

        .eyebrow {
            display: inline-block;
            color: var(--teal-dark);
            background: #e2f6f2;
            padding: 8px 15px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 17px;
        }

        .page-header h1 {
            font-size: clamp(29px, 4vw, 40px);
            color: var(--navy);
            margin-bottom: 13px;
            letter-spacing: -1px;
        }

        .page-header p {
            color: var(--muted);
            font-size: 15px;
            line-height: 1.8;
            max-width: 620px;
            margin: 0 auto;
        }

        .header-decoration {
            width: 55px;
            height: 4px;
            border-radius: 10px;
            background: var(--teal);
            margin: 22px auto 0;
        }

        /* BUS GRID */

        .bus-container {
            width: 90%;
            max-width: 1250px;
            margin: 0 auto 75px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(270px, 1fr));
            gap: 24px;
        }

        .bus-card {
            position: relative;
            background: white;
            border-radius: 17px;
            padding: 26px;
            border: 1px solid var(--border);
            box-shadow: 0 5px 20px rgba(16,36,58,.045);
            transition: .25s ease;
            min-width: 0;
            overflow: hidden;
        }

        .bus-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--teal), #73d7c9);
            opacity: .85;
        }

        .bus-card:hover {
            transform: translateY(-5px);
            border-color: #a4ded7;
            box-shadow: 0 15px 32px rgba(16,36,58,.09);
        }

        .bus-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .bus-icon {
            width: 49px;
            height: 49px;
            background: #e5f7f4;
            color: var(--teal-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            font-size: 24px;
        }

        .bus-type {
            color: var(--muted);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .8px;
            text-transform: uppercase;
        }

        .bus-number {
            font-size: 23px;
            font-weight: 800;
            color: var(--navy);
            margin-bottom: 19px;
            overflow-wrap: anywhere;
        }

        .route-label {
            color: var(--muted);
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        .route {
            color: var(--text);
            font-size: 15px;
            line-height: 1.7;
            margin-bottom: 17px;
            overflow-wrap: anywhere;
            min-height: 50px;
        }

        .route-line {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-top: 10px;
            color: var(--muted);
            font-size: 12px;
        }

        .route-dot {
            width: 9px;
            height: 9px;
            flex-shrink: 0;
            background: var(--teal);
            border-radius: 50%;
        }

        .route-dot.end {
            background: var(--navy-light);
        }

        .status {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 800;
            margin: 3px 0 20px;
        }

        .on-time {
            background: #e0f5eb;
            color: #087b56;
        }

        .delayed {
            background: #ffebeb;
            color: #bd3d48;
        }

        .unknown {
            background: #fff3d9;
            color: #946200;
        }

        .track-btn {
            display: block;
            width: 100%;
            text-align: center;
            padding: 13px;
            background: var(--navy);
            color: white;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 750;
            transition: .2s;
        }

        .track-btn:hover {
            background: var(--teal-dark);
        }

        .track-btn:focus-visible,
        .nav-links a:focus-visible,
        .login-btn:focus-visible {
            outline: 3px solid #55ddcb;
            outline-offset: 3px;
        }

        /* LOADING, ERROR AND EMPTY STATES */

        .loading,
        .error,
        .empty {
            text-align: center;
            grid-column: 1 / -1;
            padding: 55px 20px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            line-height: 1.9;
        }

        .loading,
        .empty {
            color: var(--muted);
        }

        .error {
            color: var(--red);
        }

        .loading-icon {
            font-size: 32px;
            margin-bottom: 12px;
        }

        /* FOOTER */

        footer {
            background: var(--navy);
            color: #d4e0e8;
            text-align: center;
            padding: 30px 15px;
            font-size: 13px;
            line-height: 1.9;
        }

        footer strong {
            color: #55ddcb;
        }

        /* RESPONSIVE */

        @media (max-width: 700px) {
            .navbar {
                flex-direction: column;
                gap: 17px;
                padding: 18px 5%;
            }

            .nav-links {
                justify-content: center;
                gap: 17px;
            }

            .page-header {
                padding: 45px 18px 35px;
            }

            .bus-container {
                width: 92%;
                grid-template-columns: 1fr;
                gap: 18px;
            }

            .bus-card {
                padding: 23px;
            }
        }

        @media (max-width: 380px) {
            .logo {
                font-size: 21px;
            }

            .nav-links {
                gap: 12px;
            }

            .nav-links a {
                font-size: 12px;
            }

            .bus-card {
                padding: 20px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>

<body>

    <!-- NAVIGATION -->

    <nav class="navbar">

        <div class="logo">
            TrackMy<span>Bus.</span>
        </div>

        <div class="nav-links">

            <a href="/">Home</a>
            <a href="/routes">Routes</a>
            <a href="/tracking">Live Tracking</a>

            @auth

                <form method="POST"
                      action="{{ route('logout') }}"
                      style="display:inline;">

                    @csrf

                    <button type="submit" class="login-btn">
                        Logout
                    </button>

                </form>

            @else

                <a href="/login" class="login-btn">
                    Login
                </a>

            @endauth

        </div>

    </nav>

    <!-- PAGE HEADER -->

    <section class="page-header">

        <p class="eyebrow">EXPLORE YOUR JOURNEY</p>

        <h1>Available Bus Routes</h1>

        <p>
            Find available buses, check their routes and current status,
            and track your selected bus in real time.
        </p>

        <div class="header-decoration"></div>

    </section>

    <!-- DYNAMIC BUS CARDS -->

    <section class="bus-container" id="busContainer">

        <div class="loading">
            <div class="loading-icon">🚌</div>
            <h3>Loading bus routes...</h3>
            <p>Please wait while we retrieve available buses.</p>
        </div>

    </section>

    <!-- FOOTER -->

    <footer>
        <p><strong>TrackMyBus</strong> &copy; {{ date('Y') }}. All rights reserved.</p>
        <p>Public Transit Management System</p>
    </footer>

    <script>

        async function loadBuses() {

            const container = document.getElementById('busContainer');

            try {

                const response = await fetch('/api/buses', {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Failed to load buses');
                }

                const result = await response.json();

                const buses = Array.isArray(result)
                    ? result
                    : (result.data || result.buses || []);

                container.innerHTML = '';

                if (!Array.isArray(buses) || buses.length === 0) {

                    container.innerHTML = `
                        <div class="empty">
                            <div class="loading-icon">🚌</div>
                            <h3>No buses available currently.</h3>
                            <p>Please check again later.</p>
                        </div>
                    `;

                    return;
                }

                buses.forEach(bus => {

                    const status = bus.status || 'Unknown';
                    const normalizedStatus = String(status).toLowerCase();

                    let statusClass = 'unknown';

                    if (
                        normalizedStatus.includes('on time') ||
                        normalizedStatus.includes('ontime') ||
                        normalizedStatus.includes('on-time')
                    ) {
                        statusClass = 'on-time';
                    } else if (
                        normalizedStatus.includes('delay') ||
                        normalizedStatus.includes('late')
                    ) {
                        statusClass = 'delayed';
                    }

                    const card = document.createElement('div');
                    card.className = 'bus-card';

                    const busTop = document.createElement('div');
                    busTop.className = 'bus-top';

                    const busIcon = document.createElement('div');
                    busIcon.className = 'bus-icon';
                    busIcon.textContent = '🚌';

                    const busType = document.createElement('span');
                    busType.className = 'bus-type';
                    busType.textContent = 'Public Transit';

                    busTop.appendChild(busIcon);
                    busTop.appendChild(busType);

                    const busNumber = document.createElement('div');
                    busNumber.className = 'bus-number';
                    busNumber.textContent = 'Bus ' + (bus.bus_number ?? 'Unknown');

                    const routeLabel = document.createElement('div');
                    routeLabel.className = 'route-label';
                    routeLabel.textContent = 'Journey Route';

                    const route = document.createElement('div');
                    route.className = 'route';
                    route.textContent = bus.route || 'Route not available';

                    const statusBadge = document.createElement('span');
                    statusBadge.className = 'status ' + statusClass;
                    statusBadge.textContent = status;

                    const trackLink = document.createElement('a');
                    trackLink.className = 'track-btn';
                    trackLink.textContent = 'Track This Bus →';
                    trackLink.href =
                        '/tracking?bus=' + encodeURIComponent(bus.bus_number ?? '');

                    card.appendChild(busTop);
                    card.appendChild(busNumber);
                    card.appendChild(routeLabel);
                    card.appendChild(route);
                    card.appendChild(statusBadge);
                    card.appendChild(trackLink);

                    container.appendChild(card);

                });

            } catch (error) {

                console.error(error);

                container.innerHTML = `
                    <div class="error">
                        <div class="loading-icon">!</div>
                        <h3>Unable to load bus routes.</h3>
                        <p>Please check your connection and try again.</p>
                    </div>
                `;

            }

        }

        // Load buses when the page opens.
        loadBuses();

    </script>

</body>
</html>
