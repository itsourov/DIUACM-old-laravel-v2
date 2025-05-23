<x-app-layout>
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-md mx-auto bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-xl border border-slate-200 dark:border-slate-700">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Sign in</h1>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    Don't have an account yet?
                    <a class="font-medium text-blue-600 hover:text-blue-700 underline-offset-2 hover:underline dark:text-blue-400 dark:hover:text-blue-300"
                       href="{{ route("register") }}">
                        Sign up here
                    </a>
                </p>
                <div class="mx-auto w-16 h-1 bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-blue-400 dark:to-cyan-300 rounded-full my-4"></div>
            </div>

            <div class="mb-6">
                <x-auth.google-login-button/>

                <div class="flex items-center py-3 text-xs uppercase text-slate-400 before:me-6 before:flex-1 before:border-t before:border-slate-200 after:ms-6 after:flex-1 after:border-t after:border-slate-200 dark:text-slate-500 dark:before:border-slate-700 dark:after:border-slate-700">
                    Or
                </div>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route("login") }}">
                @csrf
                <div class="grid gap-y-5">
                    <x-form.input
                            name="login"
                            label="Username or Email"
                            type="text"
                            :value="old('login')"
                            placeholder="Enter your username or email"
                            required
                            autofocus
                            autocomplete="username"/>

                  

                    <x-form.input
                            name="password"
                            label="Password"
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
                                    class="mt-0.5 shrink-0 rounded border-slate-300 text-blue-600 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:checked:border-blue-500 dark:checked:bg-blue-500 dark:focus:ring-offset-slate-800"/>
                        </div>
                        <div class="ms-3">
                            <label
                                    for="remember-me"
                                    class="text-sm text-slate-700 dark:text-slate-300">
                                Remember me
                            </label>
                        </div>
                    </div>
                    <!-- End Checkbox -->

                    <x-button type="submit" variant="primary" class="py-3 mt-2">
                        Sign in
                    </x-button>
                </div>
            </form>
            <!-- End Form -->
        </div>
    </div>
</x-app-layout>
