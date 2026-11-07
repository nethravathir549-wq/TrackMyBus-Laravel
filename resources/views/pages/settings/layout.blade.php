
<div class="settings-layout flex w-full items-start gap-8 max-md:flex-col">

    <style>
        .settings-layout .settings-sidebar {
            width: 220px;
            flex-shrink: 0;
            padding: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            background: #ffffff;
        }

        .settings-layout .settings-content {
            min-width: 0;
            flex: 1;
            padding: 4px 0;
        }

        .settings-layout .settings-title {
            color: #17283b;
            font-weight: 700;
        }

        .settings-layout .settings-description {
            color: #64748b;
        }

        .dark .settings-layout .settings-sidebar {
            background: #17283b;
            border-color: #304357;
        }

        .dark .settings-layout .settings-title {
            color: #f1f5f9;
        }

        .dark .settings-layout .settings-description {
            color: #94a3b8;
        }

        @media (max-width: 767px) {
            .settings-layout .settings-sidebar {
                width: 100%;
            }

            .settings-layout .settings-content {
                width: 100%;
                padding-top: 12px;
            }
        }
    </style>

    <!-- Settings Navigation -->
    <div class="settings-sidebar">

        <div class="mb-3 px-3 pt-2">
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                Account Settings
            </p>
        </div>

        <flux:navlist aria-label="{{ __('Settings') }}">

            <flux:navlist.item
                :href="route('profile.edit')"
                wire:navigate
                icon="user"
            >
                {{ __('Profile') }}
            </flux:navlist.item>

            <flux:navlist.item
                :href="route('security.edit')"
                wire:navigate
                icon="shield-check"
            >
                {{ __('Security') }}
            </flux:navlist.item>

            <flux:navlist.item
                :href="route('appearance.edit')"
                wire:navigate
                icon="swatch"
            >
                {{ __('Appearance') }}
            </flux:navlist.item>

        </flux:navlist>

    </div>

    <!-- Settings Content -->
    <div class="settings-content">

        <div class="mb-5 border-b border-slate-200 pb-5 dark:border-slate-700">

            <flux:heading class="settings-title">
                {{ $heading ?? '' }}
            </flux:heading>

            <flux:subheading class="settings-description">
                {{ $subheading ?? '' }}
            </flux:subheading>

        </div>

        <div class="w-full max-w-lg">
            {{ $slot }}
        </div>

    </div>

</div>
