<x-app-layout>
    <div class="container mx-auto px-2 py-7">
        <card>
            <div class="text-center">
                <h1
                        class="block text-2xl font-bold text-gray-800 dark:text-white">
                    Sign in
                </h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
                    Don't have an account yet?
                    <a
                            class="font-medium text-blue-600 decoration-2 hover:underline dark:text-blue-500"
                            href="{{ route("register") }}">
                        Sign up here
                    </a>
                </p>
            </div>

            <div class="mt-5">
                <x-auth.google-login-button/>

                <div
                        class="flex items-center py-3 text-xs uppercase text-gray-400 before:me-6 before:flex-1 before:border-t before:border-gray-200 after:ms-6 after:flex-1 after:border-t after:border-gray-200 dark:text-neutral-500 dark:before:border-neutral-600 dark:after:border-neutral-600">
                    Or
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route("login") }}">
                    @csrf
                    <div class="grid gap-y-4">
                        <x-form.input
                                name="login"
                                label="Username or Email"
                                type="text"
                                :value="old('login')"
                                placeholder="Enter your username or email"
                                required
                                autofocus
                                autocomplete="username"/>

                        <div class="flex items-center justify-between mb-1">
                            <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                                Password
                            </label>

                            @if (Route::has("password.request"))
                                <a
                                        class="text-sm font-medium text-blue-600 decoration-2 hover:underline"
                                        href="{{ route("password.request") }}">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        <x-form.input
                                name="password"
                                label=""
                                type="password"
                                placeholder="Enter your password"
                                required
                                autocomplete="current-password"/>

                        <!-- Checkbox -->
                        <div class="flex items-center">
                            <div class="flex">
                                <input
                                        id="remember-me"
                                        name="remember"
                                        type="checkbox"
                                        class="mt-0.5 shrink-0 rounded border-gray-200 text-blue-600 focus:ring-blue-500 dark:border-neutral-700 dark:bg-neutral-800 dark:checked:border-blue-500 dark:checked:bg-blue-500 dark:focus:ring-offset-gray-800"/>
                            </div>
                            <div class="ms-3">
                                <label
                                        for="remember-me"
                                        class="text-sm dark:text-white">
                                    Remember me
                                </label>
                            </div>
                        </div>
                        <!-- End Checkbox -->

                        <x-button type="submit" variant="primary" class="py-3">
                            Sign in
                        </x-button>
                    </div>
                </form>
                <!-- End Form -->
            </div>
        </card>
    </div>
</x-app-layout>
