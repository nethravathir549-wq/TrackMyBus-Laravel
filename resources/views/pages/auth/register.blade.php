
<x-layouts::auth :title="__('Register')">

    <style>
        .register-page {
            width: 100%;
            color: #172b3d;
        }

        .register-brand {
            text-align: center;
            margin-bottom: 25px;
        }

        .register-brand-icon {
            width: 58px;
            height: 58px;
            display: grid;
            place-items: center;
            margin: 0 auto 16px;
            background: #e0f5f1;
            color: #078779;
            border-radius: 17px;
            font-size: 28px;
        }

        .register-brand h1 {
            color: #10243a;
            font-size: 27px;
            font-weight: 800;
            letter-spacing: -.7px;
            margin-bottom: 8px;
        }

        .register-brand p {
            color: #718096;
            font-size: 14px;
            line-height: 1.6;
        }

        .register-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 27px;
            background: white;
            border: 1px solid #e3ebed;
            border-radius: 17px;
            box-shadow: 0 12px 35px rgba(16,36,58,.07);
        }

        .register-submit {
            width: 100%;
        }

        .register-footer {
            text-align: center;
            margin-top: 23px;
            font-size: 14px;
            color: #718096;
        }

        .register-footer a {
            color: #078779;
            font-weight: 700;
            text-decoration: none;
        }

        .register-footer a:hover {
            text-decoration: underline;
        }

        .register-security {
            text-align: center;
            margin-top: 20px;
            color: #8a9aa8;
            font-size: 12px;
        }

        @media(max-width: 480px) {
            .register-form {
                padding: 21px;
            }

            .register-brand h1 {
                font-size: 24px;
            }
        }
    </style>

    <div class="register-page">

        <div class="register-brand">

            <div class="register-brand-icon">🚌</div>

            <h1>Create Your Account</h1>

            <p>
                Join TrackMyBus and make your everyday
                travel experience easier.
            </p>

        </div>

        <div class="register-form">

            <!-- Session Status -->
            <x-auth-session-status
                class="text-center"
                :status="session('status')"
            />

            <form
                method="POST"
                action="{{ route('register.store') }}"
                class="flex flex-col gap-5"
            >

                @csrf

                <!-- Name -->
                <flux:input
                    name="name"
                    :label="__('Full name')"
                    :value="old('name')"
                    type="text"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Enter your full name"
                />

                <!-- Email Address -->
                <flux:input
                    name="email"
                    :label="__('Email address')"
                    :value="old('email')"
                    type="email"
                    required
                    autocomplete="email"
                    placeholder="email@example.com"
                />

                <!-- Password -->
                <flux:input
                    name="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Create a password"
                    passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                    viewable
                />

                <!-- Confirm Password -->
                <flux:input
                    name="password_confirmation"
                    :label="__('Confirm password')"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Enter your password again"
                    passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                    viewable
                />

                <!-- Create Account -->
                <flux:button
                    type="submit"
                    variant="primary"
                    class="register-submit"
                    data-test="register-user-button"
                >
                    {{ __('Create account') }}
                </flux:button>

            </form>

        </div>

        <!-- Login Link -->
        <div class="register-footer">

            <span>{{ __('Already have an account?') }}</span>

            <flux:link
                :href="route('login')"
                wire:navigate
            >
                {{ __('Log in') }}
            </flux:link>

        </div>

        <div class="register-security">
            Secure account registration · TrackMyBus
        </div>

    </div>

</x-layouts::auth>
