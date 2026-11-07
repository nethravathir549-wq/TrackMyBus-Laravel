
<?php

use App\Concerns\ProfileValidationRules;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Profile settings')] class extends Component {
    use ProfileValidationRules;

    public string $name = '';
    public string $email = '';

    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate($this->profileRules($user->id));

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        Flux::toast(variant: 'success', text: __('Profile updated.'));
    }

    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    #[Computed]
    public function hasUnverifiedEmail(): bool
    {
        return Auth::user() instanceof MustVerifyEmail && ! Auth::user()->hasVerifiedEmail();
    }

    #[Computed]
    public function showDeleteUser(): bool
    {
        return ! Auth::user() instanceof MustVerifyEmail
            || (Auth::user() instanceof MustVerifyEmail && Auth::user()->hasVerifiedEmail());
    }
}; ?>

<section class="w-full profile-settings-page">

    <style>
        .profile-settings-page {
            color: #17283b;
        }

        .profile-settings-page .profile-panel {
            padding: 24px;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 5px 20px rgba(15, 35, 55, .04);
        }

        .profile-settings-page .profile-input input {
            background: #f1f5f9 !important;
            border: 1px solid #dbe3ec !important;
            border-radius: 9px !important;
            color: #17283b !important;
        }

        .profile-settings-page .profile-input input:focus {
            border-color: #16b8a6 !important;
            box-shadow: 0 0 0 2px rgba(22,184,166,.12) !important;
        }

        .profile-settings-page .profile-save {
            background: #16b8a6 !important;
            color: #102a35 !important;
            border-radius: 9px !important;
            font-weight: 700 !important;
        }

        .profile-settings-page .profile-save:hover {
            background: #42d6c4 !important;
        }

        .dark .profile-settings-page {
            color: #e2e8f0;
        }

        .dark .profile-settings-page .profile-panel {
            background: #17283b;
            border-color: #304357;
        }

        .dark .profile-settings-page .profile-input input {
            background: #101c2c !important;
            border-color: #304357 !important;
            color: #f8fafc !important;
        }

        @media(max-width: 640px) {
            .profile-settings-page .profile-panel {
                padding: 18px;
            }
        }
    </style>

    @include('partials.settings-heading')

    <flux:heading level="2" class="sr-only">
        {{ __('Profile settings') }}
    </flux:heading>

    <x-pages::settings.layout
        :heading="__('Profile')"
        :subheading="__('Update your name and email address')"
    >

        <div class="profile-panel my-6">

            <div class="mb-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-teal-50 text-xl dark:bg-teal-500/10">
                        👤
                    </div>

                    <div>
                        <h3 class="text-base font-bold text-slate-800 dark:text-white">
                            Personal Information
                        </h3>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            Manage your account details
                        </p>
                    </div>
                </div>
            </div>

            <form wire:submit="updateProfileInformation" class="w-full space-y-6">

                <div class="profile-input">
                    <flux:input
                        wire:model="name"
                        :label="__('Name')"
                        type="text"
                        required
                        autofocus
                        autocomplete="name"
                    />
                </div>

                <div class="profile-input">
                    <flux:input
                        wire:model="email"
                        :label="__('Email')"
                        type="email"
                        required
                        autocomplete="email"
                    />

                    @if ($this->hasUnverifiedEmail)
                        <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-4 dark:border-amber-500/30 dark:bg-amber-500/10">

                            <flux:text class="text-sm text-amber-800 dark:text-amber-200">
                                {{ __('Your email address is unverified.') }}
                            </flux:text>

                            <flux:link
                                class="mt-2 inline-block cursor-pointer text-sm font-semibold text-teal-700 dark:text-teal-300"
                                wire:click.prevent="resendVerificationNotification"
                            >
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>

                            @if (session('status') === 'verification-link-sent')
                                <flux:text class="mt-3 text-sm font-medium !text-green-600 dark:!text-green-400">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </flux:text>
                            @endif

                        </div>
                    @endif
                </div>

                <div class="flex flex-wrap items-center gap-4 border-t border-slate-100 pt-5 dark:border-slate-700">

                    <flux:button
                        variant="primary"
                        type="submit"
                        class="profile-save"
                        data-test="update-profile-button"
                    >
                        {{ __('Save Changes') }}
                    </flux:button>

                </div>

            </form>

        </div>

        @if ($this->showDeleteUser)
            <livewire:pages::settings.delete-user-form />
        @endif

    </x-pages::settings.layout>
</section>
