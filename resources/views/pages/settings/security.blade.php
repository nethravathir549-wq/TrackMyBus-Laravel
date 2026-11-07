
<?php

use App\Concerns\PasswordValidationRules;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Livewire\Attributes\Title;
use Livewire\Component;
use Laravel\Passkeys\Actions\DeletePasskey;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;

new #[Title('Security settings')] class extends Component {
    use PasswordValidationRules;

    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    public bool $canManageTwoFactor;
    public bool $twoFactorEnabled;
    public bool $requiresConfirmation;

    #[Locked]
    public bool $canManagePasskeys;

    #[Locked]
    public array $passkeys = [];

    public bool $showDeleteModal = false;

    #[Locked]
    public ?int $deletingPasskeyId = null;

    #[Locked]
    public string $deletingPasskeyName = '';

    public function mount(DisableTwoFactorAuthentication $disableTwoFactorAuthentication): void
    {
        $this->canManageTwoFactor = Features::canManageTwoFactorAuthentication();

        if ($this->canManageTwoFactor) {
            if (Fortify::confirmsTwoFactorAuthentication() && is_null(auth()->user()->two_factor_confirmed_at)) {
                $disableTwoFactorAuthentication(auth()->user());
            }

            $this->twoFactorEnabled = auth()->user()->hasEnabledTwoFactorAuthentication();
            $this->requiresConfirmation = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm');
        }

        $this->canManagePasskeys = Features::canManagePasskeys();

        if ($this->canManagePasskeys) {
            $this->loadPasskeys();
        }
    }

    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => $this->currentPasswordRules(),
                'password' => $this->passwordRules(),
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => $validated['password'],
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        Flux::toast(variant: 'success', text: __('Password updated.'));
    }

    public function loadPasskeys(): void
    {
        $this->passkeys = auth()->user()->passkeys()
            ->select(['id', 'name', 'credential', 'created_at', 'last_used_at'])
            ->latest()
            ->get()
            ->map(fn ($passkey) => [
                'id' => $passkey->id,
                'name' => $passkey->name,
                'authenticator' => $passkey->authenticator,
                'created_at_diff' => $passkey->created_at->diffForHumans(),
                'last_used_at_diff' => $passkey->last_used_at?->diffForHumans(),
            ])
            ->toArray();
    }

    public function confirmDelete(int $passkeyId): void
    {
        $passkey = auth()->user()->passkeys()->findOrFail($passkeyId);

        $this->deletingPasskeyId = $passkey->id;
        $this->deletingPasskeyName = $passkey->name;
        $this->showDeleteModal = true;
    }

    public function deletePasskey(DeletePasskey $deletePasskey): void
    {
        if (! $this->deletingPasskeyId) {
            return;
        }

        $passkey = auth()->user()->passkeys()->findOrFail($this->deletingPasskeyId);

        $deletePasskey(auth()->user(), $passkey);

        $this->closeDeleteModal();
        $this->loadPasskeys();
    }

    public function closeDeleteModal(): void
    {
        $this->showDeleteModal = false;
        $this->deletingPasskeyId = null;
        $this->deletingPasskeyName = '';
    }

    #[On('two-factor-enabled')]
    public function onTwoFactorEnabled(): void
    {
        $this->twoFactorEnabled = true;
    }

    public function disable(DisableTwoFactorAuthentication $disableTwoFactorAuthentication): void
    {
        $disableTwoFactorAuthentication(auth()->user());

        $this->twoFactorEnabled = false;
    }
}; ?>

<section class="w-full security-settings-page">

    <style>
        .security-settings-page {
            color: #17283b;
        }

        .security-settings-page .security-panel {
            padding: 24px;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 5px 20px rgba(15, 35, 55, .04);
        }

        .security-settings-page .security-input input {
            background: #f1f5f9 !important;
            border: 1px solid #dbe3ec !important;
            border-radius: 9px !important;
            color: #17283b !important;
        }

        .security-settings-page .security-input input:focus {
            border-color: #16b8a6 !important;
            box-shadow: 0 0 0 2px rgba(22,184,166,.12) !important;
        }

        .security-settings-page .security-primary {
            background: #16b8a6 !important;
            color: #102a35 !important;
            border-radius: 9px !important;
            font-weight: 700 !important;
        }

        .security-settings-page .security-primary:hover {
            background: #42d6c4 !important;
        }

        .security-settings-page .security-divider {
            border-color: #e2e8f0;
        }

        .dark .security-settings-page {
            color: #e2e8f0;
        }

        .dark .security-settings-page .security-panel {
            background: #17283b;
            border-color: #304357;
        }

        .dark .security-settings-page .security-input input {
            background: #101c2c !important;
            border-color: #304357 !important;
            color: #f8fafc !important;
        }

        .dark .security-settings-page .security-divider {
            border-color: #304357;
        }

        @media(max-width: 640px) {
            .security-settings-page .security-panel {
                padding: 18px;
            }
        }
    </style>

    @include('partials.settings-heading')

    <flux:heading level="2" class="sr-only">
        {{ __('Security settings') }}
    </flux:heading>

    <x-pages::settings.layout
        :heading="__('Security')"
        :subheading="__('Manage your password and account security')"
    >

        <!-- Password Section -->
        <div class="security-panel mt-6">

            <div class="mb-6 flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-teal-50 text-xl dark:bg-teal-500/10">
                    🔐
                </div>

                <div>
                    <h3 class="font-bold text-slate-800 dark:text-white">
                        Update Password
                    </h3>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Keep your account protected with a strong password.
                    </p>
                </div>
            </div>

            <form method="POST" wire:submit="updatePassword" class="space-y-6">

                <div class="security-input">
                    <flux:input
                        wire:model="current_password"
                        :label="__('Current password')"
                        type="password"
                        required
                        autocomplete="current-password"
                        viewable
                    />
                </div>

                <div class="security-input">
                    <flux:input
                        wire:model="password"
                        :label="__('New password')"
                        type="password"
                        required
                        autocomplete="new-password"
                        passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                        viewable
                    />
                </div>

                <div class="security-input">
                    <flux:input
                        wire:model="password_confirmation"
                        :label="__('Confirm password')"
                        type="password"
                        required
                        autocomplete="new-password"
                        passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                        viewable
                    />
                </div>

                <div class="border-t security-divider pt-5">
                    <flux:button
                        variant="primary"
                        type="submit"
                        class="security-primary"
                        data-test="update-password-button"
                    >
                        {{ __('Save Changes') }}
                    </flux:button>
                </div>

            </form>
        </div>

        <!-- Two Factor Authentication -->
        @if ($canManageTwoFactor)
            <section class="security-panel mt-6">

                <div class="mb-5 flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-xl dark:bg-blue-500/10">
                        🛡️
                    </div>

                    <div>
                        <flux:heading>
                            {{ __('Two-factor authentication') }}
                        </flux:heading>

                        <flux:subheading>
                            {{ __('Add another layer of protection to your account') }}
                        </flux:subheading>
                    </div>
                </div>

                <div class="flex w-full flex-col space-y-6 text-sm" wire:cloak>

                    @if ($twoFactorEnabled)

                        <div class="space-y-4">
                            <flux:badge color="green">
                                {{ __('Two-factor authentication enabled') }}
                            </flux:badge>

                            <flux:text>
                                {{ __('You will be prompted for a secure, random pin during login, which you can retrieve from the TOTP-supported application on your phone.') }}
                            </flux:text>

                            <div class="flex justify-start">
                                <flux:button variant="danger" wire:click="disable">
                                    {{ __('Disable 2FA') }}
                                </flux:button>
                            </div>

                            <livewire:pages::settings.two-factor.recovery-codes :$requiresConfirmation />
                        </div>

                    @else

                        <div class="space-y-4">
                            <flux:badge color="amber">
                                {{ __('Two-factor authentication not enabled') }}
                            </flux:badge>

                            <flux:text variant="subtle">
                                {{ __('When you enable two-factor authentication, you will be prompted for a secure pin during login. This pin can be retrieved from a TOTP-supported application on your phone.') }}
                            </flux:text>

                            <flux:modal.trigger name="two-factor-setup-modal">
                                <flux:button
                                    variant="primary"
                                    class="security-primary"
                                    wire:click="$dispatch('start-two-factor-setup')"
                                >
                                    {{ __('Enable 2FA') }}
                                </flux:button>
                            </flux:modal.trigger>

                            <livewire:pages::settings.two-factor-setup-modal :requires-confirmation="$requiresConfirmation" />
                        </div>

                    @endif

                </div>
            </section>
        @endif

        <!-- Passkeys -->
        @if ($canManagePasskeys)
            <section class="security-panel mt-6">

                <div class="mb-5 flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-purple-50 text-xl dark:bg-purple-500/10">
                        🔑
                    </div>

                    <div>
                        <flux:heading>
                            {{ __('Passkeys') }}
                        </flux:heading>

                        <flux:subheading>
                            {{ __('Manage your passkeys for passwordless sign-in') }}
                        </flux:subheading>
                    </div>
                </div>

                <div class="mt-6 flex w-full flex-col space-y-6 text-sm" wire:cloak>

                    <div class="overflow-hidden rounded-xl border border-slate-200 dark:border-slate-700">

                        @forelse ($passkeys as $passkey)

                            <div class="flex items-center justify-between gap-3 p-4 {{ ! $loop->last ? 'border-b border-slate-200 dark:border-slate-700' : '' }}">

                                <div class="flex min-w-0 items-center gap-4">
                                    <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 dark:bg-[#101c2c]">
                                        <flux:icon.key class="size-5 text-teal-600 dark:text-teal-300" />
                                    </div>

                                    <div class="min-w-0 space-y-1">
                                        <div class="flex flex-wrap items-center gap-2.5">
                                            <p class="truncate font-semibold tracking-tight text-slate-800 dark:text-white">
                                                {{ $passkey['name'] }}
                                            </p>

                                            @if ($passkey['authenticator'])
                                                <flux:badge size="sm">
                                                    {{ $passkey['authenticator'] }}
                                                </flux:badge>
                                            @endif
                                        </div>

                                        <p class="text-xs text-slate-500 dark:text-slate-400">
                                            {{ __('Added :time', ['time' => $passkey['created_at_diff']]) }}

                                            @if ($passkey['last_used_at_diff'])
                                                <span class="mx-1 opacity-50">/</span>
                                                {{ __('Last used :time', ['time' => $passkey['last_used_at_diff']]) }}
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <flux:button
                                    variant="ghost"
                                    size="sm"
                                    icon="trash"
                                    icon:variant="outline"
                                    wire:click="confirmDelete({{ $passkey['id'] }})"
                                    class="shrink-0 text-red-500 hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-950/50"
                                />

                            </div>

                        @empty

                            <div class="p-8 text-center">
                                <div class="mx-auto mb-4 flex size-14 items-center justify-center rounded-2xl bg-slate-100 dark:bg-[#101c2c]">
                                    <flux:icon.key class="size-7 text-slate-400" />
                                </div>

                                <p class="font-semibold text-slate-800 dark:text-white">
                                    {{ __('No passkeys yet') }}
                                </p>

                                <flux:text class="mt-1">
                                    {{ __('Add a passkey to sign in without a password') }}
                                </flux:text>
                            </div>

                        @endforelse

                    </div>

                    <x-passkey-registration />

                </div>
            </section>
        @endif

    </x-pages::settings.layout>

    <!-- Delete Passkey Modal -->
    <flux:modal
        name="delete-passkey-modal"
        class="max-w-md md:min-w-md"
        @close="closeDeleteModal"
        wire:model="showDeleteModal"
    >
        <div class="space-y-6">

            <div class="space-y-2">
                <flux:heading size="lg">
                    {{ __('Remove passkey') }}
                </flux:heading>

                <flux:text>
                    {{ __('Are you sure you want to remove the passkey ":name"? You will no longer be able to use it to sign in.', ['name' => $deletingPasskeyName]) }}
                </flux:text>
            </div>

            <div class="flex justify-end gap-3">
                <flux:button
                    variant="outline"
                    wire:click="closeDeleteModal"
                >
                    {{ __('Cancel') }}
                </flux:button>

                <flux:button
                    variant="danger"
                    wire:click="deletePasskey"
                >
                    {{ __('Remove passkey') }}
                </flux:button>
            </div>

        </div>
    </flux:modal>

</section>
