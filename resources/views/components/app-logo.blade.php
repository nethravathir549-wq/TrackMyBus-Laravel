
@props([
    'sidebar' => false,
])

@if($sidebar)

    <flux:sidebar.brand
        :name="config('app.name', 'TrackMyBus')"
        {{ $attributes }}
    >
        <x-slot name="logo">
            <div class="flex size-9 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-teal-700">
                <x-app-logo-icon class="size-7 text-white" />
            </div>
        </x-slot>
    </flux:sidebar.brand>

@else

    <flux:brand
        :name="config('app.name', 'TrackMyBus')"
        {{ $attributes }}
    >
        <x-slot name="logo">
            <div class="flex size-9 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-teal-700">
                <x-app-logo-icon class="size-7 text-white" />
            </div>
        </x-slot>
    </flux:brand>

@endif
