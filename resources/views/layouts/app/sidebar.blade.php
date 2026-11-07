
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
    <style>
        :root {
            --track-navy: #101c2c;
            --track-navy-light: #17283b;
            --track-teal: #16b8a6;
            --track-text: #dbe7f0;
            --track-muted: #91a4b8;
        }

        body {
            background: #f3f7fa;
        }

        .track-sidebar {
            background: var(--track-navy) !important;
            border-color: #26394b !important;
            color: var(--track-text) !important;
        }

        .track-sidebar [data-flux-sidebar-header] {
            border-bottom: 1px solid #26394b;
            padding-bottom: 20px;
        }

        .track-sidebar [data-flux-sidebar-nav] {
            padding-top: 18px;
        }

        .track-sidebar [data-flux-sidebar-group-heading] {
            color: var(--track-muted) !important;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.4px;
            text-transform: uppercase;
        }

        .track-sidebar a,
        .track-sidebar button {
            color: #c5d2df !important;
            border-radius: 9px;
            transition: background .2s ease, color .2s ease;
        }

        .track-sidebar a:hover,
        .track-sidebar button:hover {
            background: var(--track-navy-light) !important;
            color: white !important;
        }

        .track-sidebar a[aria-current="page"] {
            background: rgba(22, 184, 166, .15) !important;
            color: #5eead4 !important;
            font-weight: 600;
        }

        .track-sidebar svg {
            color: inherit;
        }

        .track-mobile-header {
            background: var(--track-navy) !important;
            border-color: #26394b !important;
            color: white !important;
        }

        .track-mobile-header button,
        .track-mobile-header a {
            color: white !important;
        }

        .track-sidebar footer,
        .track-sidebar [data-flux-sidebar-footer] {
            border-top: 1px solid #26394b;
        }

        @media (max-width: 1023px) {
            body {
                background: #f3f7fa;
            }
        }
    </style>
</head>

<body class="min-h-screen bg-[#f3f7fa] dark:bg-[#101c2c]">

    <flux:sidebar
        sticky
        collapsible="mobile"
        class="track-sidebar border-e border-[#26394b]"
    >
        <flux:sidebar.header>
            <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
            <flux:sidebar.collapse class="lg:hidden" />
        </flux:sidebar.header>

        <flux:sidebar.nav>
            <flux:sidebar.group :heading="__('MAIN MENU')" class="grid">
                <flux:sidebar.item
                    icon="layout-dashboard"
                    :href="route('dashboard')"
                    :current="request()->routeIs('dashboard')"
                    wire:navigate
                >
                    {{ __('Dashboard') }}
                </flux:sidebar.item>
            </flux:sidebar.group>
        </flux:sidebar.nav>

        <flux:spacer />

        <flux:sidebar.nav>
            <flux:sidebar.group :heading="__('SUPPORT')" class="grid">
                <flux:sidebar.item
                    icon="folder-git-2"
                    href="https://github.com/laravel/livewire-starter-kit"
                    target="_blank"
                >
                    {{ __('Repository') }}
                </flux:sidebar.item>

                <flux:sidebar.item
                    icon="book-open-text"
                    href="https://laravel.com/docs/starter-kits#livewire"
                    target="_blank"
                >
                    {{ __('Documentation') }}
                </flux:sidebar.item>
            </flux:sidebar.group>
        </flux:sidebar.nav>

        <x-desktop-user-menu
            class="hidden lg:block"
            :name="auth()->user()->name"
        />
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="track-mobile-header lg:hidden">
        <flux:sidebar.toggle
            class="lg:hidden"
            icon="bars-2"
            inset="left"
        />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile
                :initials="auth()->user()->initials()"
                icon-trailing="chevron-down"
            />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <flux:avatar
                                :name="auth()->user()->name"
                                :initials="auth()->user()->initials()"
                            />

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <flux:heading class="truncate">
                                    {{ auth()->user()->name }}
                                </flux:heading>

                                <flux:text class="truncate">
                                    {{ auth()->user()->email }}
                                </flux:text>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item
                        :href="route('profile.edit')"
                        icon="cog"
                        wire:navigate
                    >
                        {{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf

                    <flux:menu.item
                        as="button"
                        type="submit"
                        icon="arrow-right-start-on-rectangle"
                        class="w-full cursor-pointer"
                        data-test="logout-button"
                    >
                        {{ __('Log out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist

    @fluxScripts
</body>
</html>
