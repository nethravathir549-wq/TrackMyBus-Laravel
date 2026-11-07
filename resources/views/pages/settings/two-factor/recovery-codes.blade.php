
<?php

use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;
use Livewire\Attributes\Locked;
use Livewire\Component;

new class extends Component {
    #[Locked]
    public array $recoveryCodes = [];

    public function mount(): void
    {
        $this->loadRecoveryCodes();
    }

    public function regenerateRecoveryCodes(GenerateNewRecoveryCodes $generateNewRecoveryCodes): void
    {
        $generateNewRecoveryCodes(auth()->user());

        $this->loadRecoveryCodes();
    }

    private function loadRecoveryCodes(): void
    {
        $user = auth()->user();

        if ($user->hasEnabledTwoFactorAuthentication() && $user->two_factor_recovery_codes) {
            try {
                $this->recoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes), true);
            } catch (Exception) {
                $this->addError('recoveryCodes', 'Failed to load recovery codes');

                $this->recoveryCodes = [];
            }
        }
    }
}; ?>

<div
    class="recovery-codes-panel space-y-6 rounded-2xl border border-slate-200 bg-white py-6 shadow-sm dark:border-slate-700 dark:bg-[#17283b]"
    wire:cloak
    x-data="{ showRecoveryCodes: false }"
>

    <style>
        .recovery-codes-panel .recovery-code-item {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 12px;
            color: #17283b;
        }

        .dark .recovery-codes-panel .recovery-code-item {
            background: #101c2c;
            border-color: #304357;
            color: #e2e8f0;
        }
    </style>

    <!-- Heading -->
    <div class="space-y-3 px-6">

        <div class="flex items-center gap-3">

            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-teal-50 text-teal-700 dark:bg-teal-500/10 dark:text-teal-300">
                <flux:icon.lock-closed variant="outline" class="size-5" />
            </div>

            <div>
                <flux:heading size="lg" level="3">
                    {{ __('2FA recovery codes') }}
                </flux:heading>

                <p class="mt-1 text-xs font-medium text-teal-700 dark:text-teal-300">
                    Additional account protection
                </p>
            </div>

        </div>

        <flux:text variant="subtle">
            {{ __('Recovery codes let you regain access if you lose your 2FA device. Store them in a secure password manager.') }}
        </flux:text>

    </div>

    <div class="border-t border-slate-100 dark:border-slate-700"></div>

    <div class="space-y-4 px-6">

        <!-- Show / Hide buttons -->
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

            <flux:button
                x-show="!showRecoveryCodes"
                icon="eye"
                icon:variant="outline"
                variant="primary"
                @click="showRecoveryCodes = true;"
                aria-expanded="false"
                aria-controls="recovery-codes-section"
            >
                {{ __('View recovery codes') }}
            </flux:button>

            <flux:button
                x-cloak
                x-show="showRecoveryCodes"
                icon="eye-slash"
                icon:variant="outline"
                variant="primary"
                @click="showRecoveryCodes = false"
                aria-expanded="true"
                aria-controls="recovery-codes-section"
            >
                {{ __('Hide recovery codes') }}
            </flux:button>

            @if (filled($recoveryCodes))
                <flux:button
                    x-cloak
                    x-show="showRecoveryCodes"
                    icon="arrow-path"
                    variant="filled"
                    wire:click="regenerateRecoveryCodes"
                    wire:confirm="Are you sure you want to regenerate your recovery codes? Your old codes will no longer work."
                >
                    {{ __('Regenerate codes') }}
                </flux:button>
            @endif

        </div>

        <!-- Recovery Codes -->
        <div
            x-cloak
            x-show="showRecoveryCodes"
            x-transition
            id="recovery-codes-section"
            class="relative overflow-hidden"
            x-bind:aria-hidden="!showRecoveryCodes"
        >

            <div class="space-y-4">

                @error('recoveryCodes')
                    <flux:callout
                        variant="danger"
                        icon="x-circle"
                        heading="{{ $message }}"
                    />
                @enderror

                @if (filled($recoveryCodes))

                    <div class="rounded-xl border border-teal-100 bg-teal-50/60 p-4 dark:border-teal-500/20 dark:bg-teal-500/5">

                        <div class="mb-3 flex items-center gap-2">
                            <flux:icon.shield-check class="size-5 text-teal-700 dark:text-teal-300" />

                            <p class="text-sm font-semibold text-teal-900 dark:text-teal-200">
                                Your recovery codes
                            </p>
                        </div>

                        <div
                            class="grid grid-cols-1 gap-2 sm:grid-cols-2"
                            role="list"
                            aria-label="{{ __('Recovery codes') }}"
                        >

                            @foreach($recoveryCodes as $code)

                                <div
                                    role="listitem"
                                    class="recovery-code-item select-text text-center font-mono text-sm tracking-wide"
                                    wire:loading.class="opacity-50 animate-pulse"
                                >
                                    {{ $code }}
                                </div>

                            @endforeach

                        </div>

                    </div>

                    <div class="flex items-start gap-3 rounded-xl border border-amber-200 bg-amber-50 p-4 dark:border-amber-500/20 dark:bg-amber-500/5">

                        <flux:icon.exclamation-triangle class="mt-0.5 size-5 shrink-0 text-amber-600 dark:text-amber-400" />

                        <div>
                            <p class="text-sm font-semibold text-amber-900 dark:text-amber-200">
                                Keep these codes safe
                            </p>

                            <flux:text variant="subtle" class="mt-1 text-xs">
                                {{ __('Each recovery code can be used once to access your account and will be removed after use. If you need more, click Regenerate codes above.') }}
                            </flux:text>
                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>
