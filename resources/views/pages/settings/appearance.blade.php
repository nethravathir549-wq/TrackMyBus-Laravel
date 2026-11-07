
<?php

use Livewire\Component;
use Livewire\Attributes\Title;

new #[Title('Appearance settings')] class extends Component {
    //
}; ?>

<section class="w-full appearance-settings-page">

    <style>
        .appearance-settings-page .appearance-panel {
            padding: 24px;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 5px 20px rgba(15, 35, 55, .04);
        }

        .appearance-settings-page .theme-option {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
            background: #f8fafc;
            transition: border-color .2s ease, background .2s ease;
        }

        .appearance-settings-page .theme-option:hover {
            border-color: #16b8a6;
            background: #f0fdfa;
        }

        .dark .appearance-settings-page .appearance-panel {
            background: #17283b;
            border-color: #304357;
        }

        .dark .appearance-settings-page .theme-option {
            background: #101c2c;
            border-color: #304357;
        }

        .dark .appearance-settings-page .theme-option:hover {
            border-color: #16b8a6;
            background: #193546;
        }

        .appearance-settings-page .theme-preview {
            height: 85px;
            overflow: hidden;
            border-radius: 8px;
            border: 1px solid #dbe3ec;
        }

        .dark .appearance-settings-page .theme-preview {
            border-color: #40546a;
        }

        .appearance-settings-page .theme-preview-light {
            background: #ffffff;
        }

        .appearance-settings-page .theme-preview-dark {
            background: #101c2c;
        }

        .appearance-settings-page .theme-preview-system {
            background: linear-gradient(90deg, #ffffff 50%, #101c2c 50%);
        }
    </style>

    @include('partials.settings-heading')

    <flux:heading level="2" class="sr-only">
        {{ __('Appearance settings') }}
    </flux:heading>

    <x-pages::settings.layout
        :heading="__('Appearance')"
        :subheading="__('Customize how TrackMyBus looks on your device')"
    >

        <div class="appearance-panel my-6">

            <div class="mb-6 flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-teal-50 text-xl dark:bg-teal-500/10">
                    🎨
                </div>

                <div>
                    <h3 class="font-bold text-slate-800 dark:text-white">
                        Display Preferences
                    </h3>

                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Choose your preferred application theme.
                    </p>
                </div>
            </div>

            <flux:radio.group
                x-data
                variant="segmented"
                x-model="$flux.appearance"
            >
                <div class="grid w-full gap-4 sm:grid-cols-3">

                    <!-- Light Theme -->
                    <div class="theme-option">
                        <div class="theme-preview theme-preview-light p-3">
                            <div class="h-3 w-12 rounded bg-slate-200"></div>
                            <div class="mt-3 flex gap-2">
                                <div class="h-8 w-8 rounded bg-teal-100"></div>
                                <div class="flex-1 space-y-2">
                                    <div class="h-2 rounded bg-slate-200"></div>
                                    <div class="h-2 w-3/4 rounded bg-slate-100"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <flux:radio value="light" icon="sun">
                                {{ __('Light') }}
                            </flux:radio>
                        </div>

                        <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                            Bright and clean appearance.
                        </p>
                    </div>

                    <!-- Dark Theme -->
                    <div class="theme-option">
                        <div class="theme-preview theme-preview-dark p-3">
                            <div class="h-3 w-12 rounded bg-slate-600"></div>
                            <div class="mt-3 flex gap-2">
                                <div class="h-8 w-8 rounded bg-teal-700"></div>
                                <div class="flex-1 space-y-2">
                                    <div class="h-2 rounded bg-slate-600"></div>
                                    <div class="h-2 w-3/4 rounded bg-slate-700"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <flux:radio value="dark" icon="moon">
                                {{ __('Dark') }}
                            </flux:radio>
                        </div>

                        <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                            Dark background with comfortable contrast.
                        </p>
                    </div>

                    <!-- System Theme -->
                    <div class="theme-option">
                        <div class="theme-preview theme-preview-system p-3">
                            <div class="flex gap-2">
                                <div class="h-3 w-10 rounded bg-slate-200"></div>
                                <div class="h-3 w-10 rounded bg-slate-600"></div>
                            </div>
                            <div class="mt-3 flex gap-2">
                                <div class="h-8 w-8 rounded bg-teal-200"></div>
                                <div class="h-8 w-8 rounded bg-teal-700"></div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <flux:radio value="system" icon="computer-desktop">
                                {{ __('System') }}
                            </flux:radio>
                        </div>

                        <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                            Follows your device appearance setting.
                        </p>
                    </div>

                </div>
            </flux:radio.group>

            <div class="mt-6 rounded-xl border border-teal-100 bg-teal-50/70 p-4 dark:border-teal-500/20 dark:bg-teal-500/10">
                <div class="flex items-start gap-3">
                    <span class="text-lg">💡</span>

                    <div>
                        <p class="text-sm font-semibold text-teal-900 dark:text-teal-200">
                            Theme preference
                        </p>

                        <p class="mt-1 text-xs leading-5 text-teal-800 dark:text-teal-300">
                            Your selected appearance will be applied throughout the application.
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </x-pages::settings.layout>
</section>
