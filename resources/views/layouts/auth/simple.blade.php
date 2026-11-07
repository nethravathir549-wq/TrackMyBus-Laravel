
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')

    <style>
        :root {
            --track-navy: #101c2c;
            --track-teal: #16b8a6;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background: #101c2c;
        }

        .auth-page {
            position: relative;
            display: flex;
            min-height: 100svh;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            padding: 32px 16px;
            background:
                radial-gradient(circle at 10% 15%, rgba(22,184,166,.16), transparent 30%),
                radial-gradient(circle at 90% 85%, rgba(22,184,166,.13), transparent 30%),
                linear-gradient(135deg, #101c2c 0%, #142b3d 55%, #075b5a 100%);
        }

        .auth-decoration {
            position: absolute;
            width: 300px;
            height: 300px;
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 50%;
            pointer-events: none;
        }

        .auth-decoration.one {
            top: -150px;
            right: -80px;
        }

        .auth-decoration.two {
            bottom: -190px;
            left: -100px;
            width: 400px;
            height: 400px;
        }

        .auth-content {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 440px;
        }

        .auth-brand {
            display: flex;
            justify-content: center;
            margin-bottom: 24px;
        }

        .auth-brand-icon {
            display: flex;
            width: 62px;
            height: 62px;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 18px;
            background: rgba(255,255,255,.1);
            color: #5eead4;
        }

        .auth-brand-icon svg {
            width: 38px;
            height: 38px;
        }

        .auth-brand-name {
            margin-top: 12px;
            color: white;
            font-size: 23px;
            font-weight: 800;
            letter-spacing: 1px;
            text-align: center;
        }

        .auth-brand-subtitle {
            margin-top: 5px;
            color: #b7cbd5;
            font-size: 12px;
            letter-spacing: 1.5px;
            text-align: center;
            text-transform: uppercase;
        }

        .auth-card {
            padding: 30px;
            border: 1px solid rgba(255,255,255,.15);
            border-radius: 20px;
            background: #ffffff;
            box-shadow: 0 25px 70px rgba(0,0,0,.25);
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 23px 18px;
                border-radius: 16px;
            }
        }
        /* Login and Register input styling */
.auth-card input:not([type="checkbox"]):not([type="radio"]),
.auth-card textarea,
.auth-card select {
    background-color: #f1f5f9 !important;
    border: 1px solid #dbe3ec !important;
    border-radius: 9px !important;
    color: #17283b !important;
}

.auth-card input::placeholder,
.auth-card textarea::placeholder {
    color: #94a3b8 !important;
}

.auth-card input:focus,
.auth-card textarea:focus,
.auth-card select:focus {
    border-color: #16b8a6 !important;
    outline-color: #16b8a6 !important;
    box-shadow: 0 0 0 2px rgba(22,184,166,.12) !important;
}
    </style>
</head>

<body class="antialiased">

    <div class="auth-page">
        <div class="auth-decoration one"></div>
        <div class="auth-decoration two"></div>

        <div class="auth-content">

            <a href="{{ route('home') }}"
               class="auth-brand block"
               wire:navigate>
                <div class="flex flex-col items-center">
                    <span class="auth-brand-icon">
                        <x-app-logo-icon class="size-9 fill-current" />
                    </span>

                    <span class="auth-brand-name">
                        TRACKMYBUS
                    </span>

                    <span class="auth-brand-subtitle">
                        Smart Bus Tracking
                    </span>

                    <span class="sr-only">
                        {{ config('app.name', 'TrackMyBus') }}
                    </span>
                </div>
            </a>

            <div class="auth-card">
                {{ $slot }}
            </div>

            <p class="mt-6 text-center text-xs text-slate-300">
                © {{ date('Y') }} TrackMyBus. All rights reserved.
            </p>

        </div>
    </div>

    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist

    @fluxScripts
</body>
</html>
