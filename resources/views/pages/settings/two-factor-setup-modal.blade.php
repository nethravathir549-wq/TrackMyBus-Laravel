
<?php

use Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component {
    #[Locked]
    public bool $requiresConfirmation;

    #[Locked]
    public string $qrCodeSvg = '';

    #[Locked]
    public string $manualSetupKey = '';

    public bool $showVerificationStep = false;

    public bool $setupComplete = false;

    #[Validate('required|string|size:6', onUpdate: false)]
    public string $code = '';

    public function mount(bool $requiresConfirmation): void
    {
        $this->requiresConfirmation = $requiresConfirmation;
    }

    #[On('start-two-factor-setup')]
    public function startTwoFactorSetup(): void
    {
        $enableTwoFactorAuthentication = app(EnableTwoFactorAuthentication::class);
        $enableTwoFactorAuthentication(auth()->user());

        $this->loadSetupData();
    }

    private function loadSetupData(): void
    {
        $user = auth()->user()?->fresh();

        try {
            if (! $user || ! $user->two_factor_secret) {
                throw new Exception('Two-factor setup secret is not available.');
            }

            $this->qrCodeSvg = $user->twoFactorQrCodeSvg();
            $this->manualSetupKey = decrypt($user->two_factor_secret);
        } catch (Exception) {
            $this->addError('setupData', 'Failed to fetch setup data.');

            $this->reset('qrCodeSvg', 'manualSetupKey');
        }
    }

    public function showVerificationIfNecessary(): void
    {
        if ($this->requiresConfirmation) {
            $this->showVerificationStep = true;
            $this->resetErrorBag();

            return;
        }

        $this->closeModal();
        $this->dispatch('two-factor-enabled');
    }

    public function confirmTwoFactor(ConfirmTwoFactorAuthentication $confirmTwoFactorAuthentication): void
    {
        $this->validate();

        $confirmTwoFactorAuthentication(auth()->user(), $this->code);

        $this->setupComplete = true;

        $this->closeModal();

        $this->dispatch('two-factor-enabled');
    }

    public function resetVerification(): void
    {
        $this->reset('code', 'showVerificationStep');

        $this->resetErrorBag();
    }

    public function closeModal(): void
    {
        $this->reset(
            'code',
            'manualSetupKey',
            'qrCodeSvg',
            'showVerificationStep',
            'setupComplete',
        );

        $this->resetErrorBag();
    }

    #[Computed]
    public function modalConfig(): array
    {
        if ($this->setupComplete) {
            return [
                'title' => __('Two-factor authentication enabled'),
                'description' => __('Two-factor authentication is now enabled. Scan the QR code or enter the setup key in your authenticator app.'),
                'buttonText' => __('Close'),
            ];
        }

        if ($this->showVerificationStep) {
            return [
                'title' => __('Verify authentication code'),
                'description' => __('Enter the 6-digit code from your authenticator app.'),
                'buttonText' => __('Continue'),
            ];
        }

        return [
            'title' => __('Enable two-factor authentication'),
            'description' => __('To finish enabling two-factor authentication, scan the QR code or enter the setup key in your authenticator app.'),
            'buttonText' => __('Continue'),
        ];
    }
}; ?>

<style>
    .two-factor-modal-content {
        color: #17283b;
    }

    .two-factor-modal-content .two-factor-panel {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px;
    }

    .two-factor-modal-content .two-factor-primary {
        background: #0f766e;
        color: white;
    }

    .two-factor-modal-content .two-factor-primary:hover {
        background: #115e59;
    }

    .two-factor-modal-content .two-factor-code {
        background: #f1f5f9;
        border: 1px solid #dbe3ec;
        border-radius: 10px;
        color: #17283b;
    }

    .dark .two-factor-modal-content {
        color: #f1f5f9;
    }

    .dark .two-factor-modal-content .two-factor-panel {
        background: #101c2c;
        border-color: #304357;
    }

    .dark .two-factor-modal-content .two-factor-code {
        background: #17283b;
        border-color: #40546a;
        color: #f1f5f9;
    }
</style>

<flux:modal
    name="two-factor-setup-modal"
    class="max-w-md md:min-w-md"
    @close="closeModal"
>
    <div class="two-factor-modal-content space-y-6">

        <!-- Header -->
        <div class="flex flex-col items-center space-y-4">

            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-teal-50 text-teal-700 dark:bg-teal-500/10 dark:text-teal-300">
                <flux:icon.shield-check class="size-9" />
            </div>

            <div class="space-y-2 text-center">
                <flux:heading size="lg">
                    {{ $this->modalConfig['title'] }}
                </flux:heading>

                <flux:text>
                    {{ $this->modalConfig['description'] }}
                </flux:text>
            </div>

        </div>

        @if ($showVerificationStep)

            <!-- OTP Verification -->
            <div class="two-factor-panel space-y-6">

                <div
                    class="flex flex-col items-center justify-center space-y-3"
                    x-data
                    x-init="$nextTick(() => $el.querySelector('input')?.focus())"
                >
                    <div class="text-center">
                        <flux:icon.lock-keyhole class="mx-auto mb-2 size-8 text-teal-600" />

                        <p class="text-sm font-semibold">
                            Authentication code
                        </p>

                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            Enter the six-digit code from your authenticator app.
                        </p>
                    </div>

                    <flux:otp
                        name="code"
                        wire:model="code"
                        length="6"
                        label="OTP Code"
                        label:sr-only
                        class="mx-auto"
                    />
                </div>

                <div class="flex items-center gap-3">

                    <flux:button
                        variant="outline"
                        class="flex-1"
                        wire:click="resetVerification"
                    >
                        {{ __('Back') }}
                    </flux:button>

                    <flux:button
                        variant="primary"
                        class="flex-1"
                        wire:click="confirmTwoFactor"
                        x-bind:disabled="$wire.code.length < 6"
                    >
                        {{ __('Confirm') }}
                    </flux:button>

                </div>

            </div>

        @else

            <!-- QR Code -->
            @error('setupData')
                <flux:callout
                    variant="danger"
                    icon="x-circle"
                    heading="{{ $message }}"
                />
            @enderror

            <div class="two-factor-panel space-y-4">

                <div class="text-center">
                    <p class="text-sm font-semibold">
                        Scan QR code
                    </p>

                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Open your authenticator app and scan this code.
                    </p>
                </div>

                <div class="mx-auto flex aspect-square w-64 items-center justify-center overflow-hidden rounded-xl border border-slate-200 bg-white dark:border-slate-600">

                    @empty($qrCodeSvg)

                        <div class="flex flex-col items-center gap-3 text-slate-400">
                            <flux:icon.loading class="size-8" />

                            <span class="text-xs">
                                Loading QR code...
                            </span>
                        </div>

                    @else

                        <div
                            x-data
                            class="flex h-full w-full items-center justify-center p-4"
                        >
                            <div
                                class="rounded bg-white p-3"
                                :style="($flux.appearance === 'dark' || ($flux.appearance === 'system' && $flux.dark)) ? 'filter: invert(1) brightness(1.5)' : ''"
                            >
                                {!! $qrCodeSvg !!}
                            </div>
                        </div>

                    @endempty

                </div>

                <flux:button
                    :disabled="$errors->has('setupData')"
                    variant="primary"
                    class="two-factor-primary w-full"
                    wire:click="showVerificationIfNecessary"
                >
                    {{ $this->modalConfig['buttonText'] }}
                </flux:button>

            </div>

            <!-- Manual Setup Key -->
            <div class="space-y-3">

                <div class="flex items-center gap-3">
                    <div class="h-px flex-1 bg-slate-200 dark:bg-slate-700"></div>

                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400">
                        {{ __('OR ENTER MANUALLY') }}
                    </span>

                    <div class="h-px flex-1 bg-slate-200 dark:bg-slate-700"></div>
                </div>

                <div
                    class="space-y-2"
                    x-data="{
                        copied: false,
                        async copy() {
                            try {
                                await navigator.clipboard.writeText(@js($manualSetupKey));
                                this.copied = true;
                                setTimeout(() => this.copied = false, 1500);
                            } catch (e) {
                                console.warn('Could not copy to clipboard');
                            }
                        }
                    }"
                >

                    <label class="text-sm font-semibold">
                        Setup key
                    </label>

                    <div class="flex items-center overflow-hidden rounded-xl border border-slate-200 dark:border-slate-700">

                        @empty($manualSetupKey)

                            <div class="flex w-full items-center justify-center bg-slate-50 p-3 dark:bg-slate-800">
                                <flux:icon.loading variant="mini" />
                            </div>

                        @else

                            <input
                                type="text"
                                readonly
                                value="{{ $manualSetupKey }}"
                                class="two-factor-code w-full border-0 p-3 text-sm font-mono outline-none"
                            />

                            <button
                                type="button"
                                @click="copy()"
                                aria-label="Copy setup key"
                                class="flex h-full items-center justify-center border-l border-slate-200 px-4 transition-colors hover:bg-teal-50 dark:border-slate-700 dark:hover:bg-teal-500/10"
                            >
                                <flux:icon.document-duplicate
                                    x-show="!copied"
                                    variant="outline"
                                    class="size-5"
                                />

                                <flux:icon.check
                                    x-show="copied"
                                    variant="solid"
                                    class="size-5 text-teal-600"
                                />
                            </button>

                        @endempty

                    </div>

                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Keep this key private. Anyone with it may be able to generate authentication codes for your account.
                    </p>

                </div>

            </div>

        @endif

    </div>
</flux:modal>
