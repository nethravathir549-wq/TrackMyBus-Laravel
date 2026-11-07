
<x-layouts::auth :title="__('Log in')">

    <style>
        .login-page {
            width: 100%;
            color: #172b3d;
        }

        .login-brand {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-brand-icon {
            width: 68px;
            height: 68px;
            display: grid;
            place-items: center;
            margin: 0 auto 18px;
            background: linear-gradient(135deg, #d9f5ef, #e5f0ff);
            color: #078779;
            border-radius: 20px;
            font-size: 32px;
        }

        .login-brand h1 {
            color: #10243a;
            font-size: 29px;
            font-weight: 800;
            letter-spacing: -.8px;
            margin-bottom: 9px;
        }

        .login-brand p {
            color: #718096;
            font-size: 14px;
            line-height: 1.7;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            gap: 22px;
            padding: 30px;
            background: #ffffff;
            border: 1px solid #e2ebef;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(16,36,58,.08);
        }

        .login-form label {
            color: #193751;
        }

        .login-remember {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin: 3px 0;
        }

        .remember-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            color: #193751;
            font-size: 14px;
            font-weight: 500;
        }

        .remember-checkbox {
            appearance: auto !important;
            -webkit-appearance: checkbox !important;
            width: 17px !important;
            height: 17px !important;
            accent-color: #078779;
            cursor: pointer;
            flex-shrink: 0;
            margin: 0;
        }

        .login-submit {
            width: 100%;
            min-height: 46px;
            font-weight: 700;
            border-radius: 11px;
            transition: all .2s ease;
        }

        .login-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 7px 18px rgba(7,135,121,.20);
        }

        .login-footer {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: #718096;
        }

        .login-footer a {
            color: #078779;
            font-weight: 700;
            text-decoration: none;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        .login-security {
            text-align: center;
            margin-top: 23px;
            color: #8a9aa8;
            font-size: 12px;
        }

        @media(max-width: 480px) {
            .login-form {
                padding: 22px;
            }

            .login-brand h1 {
                font-size: 25px;
            }
        }
    </style>

    <div class="login-page">

        <div class="login-brand">

            <div class="login-brand-icon">🚌</div>

            <h1>Welcome to TrackMyBus</h1>

            <p>
                Log in to your TrackMyBus account
                and continue your journey.
            </p>

        </div>

        <div class="login-form">

            <!-- Session Status -->
            <x-auth-session-status
                class="text-center"
                :status="session('status')"
            />

            <!-- Passkey Verification -->
            <x-passkey-verify />

            <form
                method="POST"
                action="{{ route('login.store') }}"
                class="flex flex-col gap-5"
            >

                @csrf

                <!-- Email Address -->
                <flux:input
                    name="email"
                    :label="__('Email address')"
                    :value="old('email')"
                    type="email"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="email@example.com"
                />

                <!-- Password -->
                <div class="relative">

                    <flux:input
                        name="password"
                        :label="__('Password')"
                        type="password"
                        required
                        autocomplete="current-password"
                        :placeholder="__('Enter your password')"
                        viewable
                    />

                    @if (Route::has('password.request'))
                        <div class="mt-2 text-right">
                            <flux:link
                                :href="route('password.request')"
                                wire:navigate
                            >
                                {{ __('Forgot your password?') }}
                            </flux:link>
                        </div>
                    @endif

                </div>

                <!-- Remember Me -->
                <div class="login-remember">
                    <label class="remember-label">
                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                            class="remember-checkbox"
                            @checked(old('remember'))
                        >
                        <span>Remember me</span>
                    </label>
                </div>

                <!-- Login Button -->
                <flux:button
                    variant="primary"
                    type="submit"
                    class="login-submit"
                    data-test="login-button"
                >
                    {{ __('Log in') }}
                </flux:button>

            </form>

        </div>

        <!-- Register Link -->
        <div class="login-footer">

            <span>{{ __('Don\'t have an account?') }}</span>

            <flux:link
                :href="route('register')"
                wire:navigate
            >
                {{ __('Sign up') }}
            </flux:link>

        </div>

        <div class="login-security">
            🔒 Secure account access · TrackMyBus
        </div>

    </div>

</x-layouts::auth>
