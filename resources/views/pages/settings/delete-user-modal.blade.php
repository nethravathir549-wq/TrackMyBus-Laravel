
<?php

use App\Concerns\PasswordValidationRules;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component {
    use PasswordValidationRules;

    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => $this->currentPasswordRules(),
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<flux:modal
    name="confirm-user-deletion"
    :show="$errors->isNotEmpty()"
    focusable
    class="max-w-lg"
>

    <div class="space-y-6">

        <style>
            .delete-confirmation-modal .delete-warning {
                border: 1px solid #fecaca;
                background: #fff1f2;
                border-radius: 14px;
                padding: 16px;
            }

            .delete-confirmation-modal .delete-password input {
                background: #f1f5f9 !important;
                border-color: #dbe3ec !important;
                border-radius: 9px !important;
            }

            .dark .delete-confirmation-modal .delete-warning {
                background: rgba(127, 29, 29, .12);
                border-color: rgba(239, 68, 68, .3);
            }

            .dark .delete-confirmation-modal .delete-password input {
                background: #101c2c !important;
                border-color: #40546a !important;
            }
        </style>

        <form
            method="POST"
            wire:submit="deleteUser"
            class="delete-confirmation-modal space-y-6"
        >

            <!-- Warning Header -->
            <div class="flex items-start gap-4">

                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600 dark:bg-red-500/10 dark:text-red-400">
                    <flux:icon.exclamation-triangle class="size-6" />
                </div>

                <div class="min-w-0 space-y-2">

                    <flux:heading size="lg">
                        {{ __('Are you sure you want to delete your account?') }}
                    </flux:heading>

                    <flux:subheading>
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </flux:subheading>

                </div>

            </div>

            <!-- Warning Message -->
            <div class="delete-warning">

                <div class="flex items-start gap-3">

                    <flux:icon.trash class="mt-0.5 size-5 shrink-0 text-red-600 dark:text-red-400" />

                    <div>
                        <p class="text-sm font-semibold text-red-800 dark:text-red-300">
                            Permanent account deletion
                        </p>

                        <p class="mt-1 text-xs leading-5 text-red-700 dark:text-red-400">
                            This action cannot be undone. Make sure you want to continue.
                        </p>
                    </div>

                </div>

            </div>

            <!-- Password Confirmation -->
            <div class="delete-password space-y-2">

                <flux:input
                    wire:model="password"
                    :label="__('Password')"
                    type="password"
                    viewable
                    autocomplete="current-password"
                />

            </div>

            <!-- Actions -->
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                <flux:modal.close>
                    <flux:button
                        variant="filled"
                        class="w-full sm:w-auto"
                        type="button"
                    >
                        {{ __('Cancel') }}
                    </flux:button>
                </flux:modal.close>

                <flux:button
                    variant="danger"
                    type="submit"
                    class="w-full sm:w-auto"
                    data-test="confirm-delete-user-button"
                >
                    <flux:icon.trash class="size-4" />
                    {{ __('Delete account') }}
                </flux:button>

            </div>

        </form>

    </div>

</flux:modal>
