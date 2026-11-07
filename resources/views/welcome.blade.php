
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>TrackMyBus | Smart Transit</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --navy: #10243a;
            --navy-light: #193b52;
            --teal: #0eaa9b;
            --teal-dark: #078779;
            --text: #172b3d;
            --muted: #718096;
            --background: #f2f6f8;
            --white: #ffffff;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: var(--background);
            color: var(--text);
        }

        a {
            text-decoration: none;
        }

        button, input {
            font-family: inherit;
        }

        /* NAVIGATION */

        nav {
            min-height: 76px;
            padding: 0 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--navy);
            gap: 20px;
        }

        .logo {
            font-size: 25px;
            font-weight: 800;
            letter-spacing: -1px;
            color: white;
            white-space: nowrap;
        }

        .logo span {
            color: var(--teal);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 27px;
        }

        .nav-links a {
            color: #d2dce5;
            font-size: 14px;
            font-weight: 600;
            transition: .2s;
        }

        .nav-links a:hover {
            color: #55ddcb;
        }

        .login-btn {
            padding: 10px 19px;
            border: 1px solid var(--teal);
            border-radius: 8px;
            color: white !important;
            background: transparent;
            cursor: pointer;
        }

        .register-btn {
            padding: 11px 20px;
            background: var(--teal);
            color: var(--navy) !important;
            border-radius: 8px;
            font-weight: 800 !important;
        }

        /* HERO */

        .hero {
            min-height: 570px;
            padding: 75px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 55px;
            background:
                radial-gradient(circle at 80% 40%, #244a58 0, transparent 35%),
                linear-gradient(120deg, #10243a, #183a4c);
            color: white;
            overflow: hidden;
        }

        .hero-content {
            max-width: 590px;
            flex: 1;
        }

        .eyebrow {
            display: inline-block;
            padding: 9px 15px;
            border: 1px solid #39716f;
            border-radius: 30px;
            color: #62dfd0;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 25px;
        }

        .hero h1 {
            font-size: clamp(38px, 5vw, 61px);
            line-height: 1.12;
            letter-spacing: -2px;
            margin-bottom: 23px;
        }

        .hero h1 span {
            color: var(--teal);
        }

        .hero-content p {
            color: #c1ced8;
            font-size: 17px;
            line-height: 1.8;
            margin-bottom: 32px;
        }

        .search-box {
            display: flex;
            max-width: 510px;
            background: white;
            padding: 7px;
            border-radius: 12px;
            gap: 8px;
        }

        .search-box input {
            flex: 1;
            min-width: 0;
            border: none;
            outline: none;
            padding: 15px;
            font-size: 15px;
            color: var(--text);
            background: white;
        }

        .search-box button {
            border: none;
            padding: 0 22px;
            border-radius: 8px;
            background: var(--teal);
            color: var(--navy);
            font-weight: 800;
            cursor: pointer;
            transition: .2s;
        }

        .search-box button:hover {
            background: #58dfcf;
        }

        .hero-note {
            color: #91a6b5;
            font-size: 12px;
            margin-top: 15px;
        }

        /* JOURNEY OVERVIEW */

        .visual-panel {
            width: 430px;
            min-width: 300px;
            padding: 27px;
            background: rgba(255,255,255,.09);
            border: 1px solid rgba(255,255,255,.16);
            border-radius: 22px;
            backdrop-filter: blur(12px);
            box-shadow: 0 20px 50px rgba(0,0,0,.16);
        }

        .panel-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 25px;
            color: #dbe7ed;
            font-size: 13px;
        }

        .panel-top strong {
            display: block;
            color: #ffffff;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 1px;
            white-space: nowrap;
        }

        .live-label {
            display: inline-flex;
            align-items: center;
            padding: 7px 10px;
            border-radius: 20px;
            background: rgba(14,170,155,.13);
            color: #65e0cb;
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .route-visual {
            padding: 27px 22px;
            background: rgba(8,23,38,.55);
            border: 1px solid rgba(255,255,255,.06);
            border-radius: 16px;
        }

        .route-point {
            display: flex;
            gap: 15px;
            align-items: center;
            margin-bottom: 23px;
        }

        .route-point:last-child {
            margin-bottom: 0;
        }

        .point-icon {
            width: 13px;
            height: 13px;
            border-radius: 50%;
            background: var(--teal);
            box-shadow: 0 0 15px rgba(18,184,166,.5);
            flex-shrink: 0;
        }

        .route-point:last-child .point-icon {
            background: #f4c66b;
            box-shadow: 0 0 15px rgba(244,198,107,.35);
        }

        .point-text strong {
            display: block;
            color: #ffffff;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .point-text small {
            color: #9cb0bd;
            font-size: 11px;
        }

        .route-line {
            height: 23px;
            border-left: 2px dashed #4e9b98;
            margin: -16px 0 -7px 5px;
        }

        .bus-symbol {
            text-align: center;
            font-size: 58px;
            margin: 20px 0;
            filter: drop-shadow(0 5px 8px rgba(0,0,0,.2));
        }

        .panel-bottom {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 18px;
            color: #b7c9d2;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        /* FEATURES */

        .features {
            padding: 85px 8%;
            text-align: center;
        }

        .section-tag {
            color: var(--teal-dark);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 2px;
            margin-bottom: 13px;
        }

        .features h2 {
            font-size: 36px;
            color: var(--navy);
            margin-bottom: 13px;
        }

        .section-subtitle {
            color: var(--muted);
            font-size: 15px;
            margin-bottom: 45px;
            line-height: 1.7;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .feature-card {
            text-align: left;
            padding: 32px;
            background: white;
            border: 1px solid #e3ebed;
            border-radius: 16px;
            transition: .25s;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            border-color: var(--teal);
            box-shadow: 0 15px 35px rgba(16,36,58,.08);
        }

        .feature-icon {
            width: 55px;
            height: 55px;
            display: grid;
            place-items: center;
            background: #e2f8f4;
            color: #078f82;
            border-radius: 13px;
            font-size: 25px;
            margin-bottom: 23px;
        }

        .feature-card h3 {
            color: var(--navy);
            font-size: 19px;
            margin-bottom: 12px;
        }

        .feature-card p {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.8;
        }

        /* CALL TO ACTION */

        .bottom-cta {
            margin: 0 8% 75px;
            padding: 38px;
            border-radius: 18px;
            background: #dff5f1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .bottom-cta h2 {
            color: var(--navy);
            font-size: 23px;
            margin-bottom: 8px;
        }

        .bottom-cta p {
            color: #607b7b;
            font-size: 14px;
            line-height: 1.7;
        }

        .cta-link {
            background: var(--navy);
            color: white;
            padding: 13px 21px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            white-space: nowrap;
            transition: .2s;
        }

        .cta-link:hover {
            background: var(--teal-dark);
        }

        /* FOOTER */

        footer {
            padding: 30px 8%;
            background: var(--navy);
            text-align: center;
        }

        footer p {
            color: #a9bac7;
            font-size: 13px;
            line-height: 1.8;
        }

        /* RESPONSIVE DESIGN */

        @media(max-width: 900px) {
            .hero {
                flex-direction: column;
                text-align: center;
                padding: 65px 7%;
            }

            .hero-content {
                width: 100%;
            }

            .search-box {
                margin: auto;
            }

            .visual-panel {
                width: 100%;
                max-width: 430px;
            }

            .feature-grid {
                grid-template-columns: 1fr;
            }

            .bottom-cta {
                flex-direction: column;
                text-align: center;
            }
        }

        @media(max-width: 600px) {
            nav {
                padding: 18px 5%;
                flex-direction: column;
            }

            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
                gap: 15px;
            }

            .hero {
                padding: 55px 6%;
            }

            .hero h1 {
                font-size: 39px;
                letter-spacing: -1px;
            }

            .hero-content p {
                font-size: 15px;
            }

            .search-box {
                flex-direction: column;
            }

            .search-box button {
                padding: 14px;
            }

            .visual-panel {
                min-width: 0;
                padding: 20px;
            }

            .panel-top {
                align-items: flex-start;
            }

            .features {
                padding: 65px 6%;
            }

            .features h2 {
                font-size: 29px;
            }

            .feature-card {
                padding: 25px;
            }

            .bottom-cta {
                margin: 0 6% 55px;
                padding: 28px 20px;
            }

            .bottom-cta h2 {
                font-size: 21px;
            }
        }

        @media(prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }

            *, *::before, *::after {
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>

<body>

<nav>
    <div class="logo">TrackMy<span>Bus.</span></div>

    <div class="nav-links">
        <a href="/">Home</a>
        <a href="/routes">Routes</a>
        <a href="/tracking">Live Tracking</a>

        @auth
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="login-btn">
                    Logout
                </button>
            </form>
        @else
            <a href="/login" class="login-btn">Login</a>
            <a href="/register" class="register-btn">Register</a>
        @endauth
    </div>
</nav>

<section class="hero">

    <div class="hero-content">

        <div class="eyebrow">SMARTER JOURNEYS START HERE</div>

        <h1>
            Your Journey.<br>
            Your Bus.<br>
            <span>Your Control.</span>
        </h1>

        <p>
            Stay connected to your journey. Explore bus routes,
            discover live locations and make everyday travel
            more convenient with TrackMyBus.
        </p>

        <div class="search-box">
            <input
                type="text"
                id="busNumber"
                placeholder="Enter your bus number..."
                aria-label="Enter bus number"
            >

            <button type="button" onclick="searchBus()">
                Track Bus →
            </button>
        </div>

        <div class="hero-note">
            Enter a bus number to open its live tracking page.
        </div>

    </div>

    <!-- JOURNEY OVERVIEW -->

    <div class="visual-panel">

        <div class="panel-top">
            <strong>JOURNEY OVERVIEW</strong>
            <span class="live-label">● BUS JOURNEY</span>
        </div>

        <div class="route-visual">

            <div class="route-point">
                <div class="point-icon"></div>
                <div class="point-text">
                    <strong>Your Starting Point</strong>
                    <small>Journey begins here</small>
                </div>
            </div>

            <div class="route-line"></div>

            <div class="bus-symbol">🚌</div>

            <div class="route-line"></div>

            <div class="route-point">
                <div class="point-icon"></div>
                <div class="point-text">
                    <strong>Your Destination</strong>
                    <small>Travel with confidence</small>
                </div>
            </div>

        </div>

        <div class="panel-bottom">
            <span>TRACK</span>
            <span>EXPLORE</span>
            <span>TRAVEL</span>
        </div>

    </div>

</section>

<!-- FEATURES -->

<section class="features">

    <div class="section-tag">OUR FEATURES</div>

    <h2>Everything You Need for Your Journey</h2>

    <p class="section-subtitle">
        A simpler way to explore public transportation.
    </p>

    <div class="feature-grid">

        <div class="feature-card">
            <div class="feature-icon">⌖</div>
            <h3>Live Bus Tracking</h3>
            <p>
                View available bus locations on an interactive map
                and follow your selected bus.
            </p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">↗</div>
            <h3>Explore Bus Routes</h3>
            <p>
                Browse available routes and find useful
                information about your bus journey.
            </p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">◷</div>
            <h3>Journey Information</h3>
            <p>
                Access available location and estimated
                arrival information for your selected bus.
            </p>
        </div>

    </div>

</section>

<!-- CALL TO ACTION -->

<section class="bottom-cta">

    <div>
        <h2>Ready to explore your next journey?</h2>
        <p>Discover available buses and routes with TrackMyBus.</p>
    </div>

    <a href="/routes" class="cta-link">
        Explore Bus Routes →
    </a>

</section>

<!-- FOOTER -->

<footer>
    <p>© {{ date('Y') }} TrackMyBus. All rights reserved.</p>
    <p>Public Transit Management System</p>
</footer>

<script>
    function searchBus() {

        const busNumber = document
            .getElementById("busNumber")
            .value
            .trim();

        if (busNumber === "") {
            alert("Please enter a bus number.");
            return;
        }

        window.location.href =
            "/tracking?bus=" + encodeURIComponent(busNumber);
    }

    document.getElementById("busNumber").addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            searchBus();
        }
    });
</script>

</body>
</html>
