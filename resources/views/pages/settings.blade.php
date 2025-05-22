<x-app-layout title="Settings">
    <div class="container mx-auto px-4 py-16">
        {{-- Header section --}}
        <div class="mb-12 text-center">
            <h1 class="text-4xl font-bold mb-4 text-slate-900 dark:text-white">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-blue-400 dark:to-cyan-300">
                    Settings
                </span>
            </h1>
            <div class="mx-auto w-20 h-1.5 bg-gradient-to-r from-blue-600 to-cyan-500 rounded-full mb-6"></div>
            <p class="text-lg text-slate-600 dark:text-slate-300 max-w-xl mx-auto">
                Personalize your DIU ACM experience
            </p>
        </div>

        {{-- Under construction notification --}}
        <div class="max-w-4xl mx-auto">
            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-md rounded-2xl p-8 text-center">
                <div class="mb-8">
                    <div class="w-24 h-24 mx-auto mb-6 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600 dark:text-blue-400">
                            <path d="M12 2v4"></path>
                            <path d="M12 18v4"></path>
                            <path d="M4.93 4.93l2.83 2.83"></path>
                            <path d="M16.24 16.24l2.83 2.83"></path>
                            <path d="M2 12h4"></path>
                            <path d="M18 12h4"></path>
                            <path d="M4.93 19.07l2.83-2.83"></path>
                            <path d="M16.24 7.76l2.83-2.83"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">This Page is Under Construction</h2>
                    <p class="text-lg text-slate-600 dark:text-slate-300 mb-6">
                        We're currently working on creating a better settings experience for you. Please check back in one day.
                    </p>
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-lg p-6 mb-6">
                        <p class="text-slate-700 dark:text-slate-300">
                            If you need to change your information immediately, please contact someone from the ACM team.
                        </p>
                    </div>
                </div>
                
                <div class="flex justify-center space-x-4">
                    <x-button href="{{ route('home') }}" variant="primary" size="md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        Return to Home
                    </x-button>
                    <x-button href="{{ route('contact') }}" variant="secondary" size="md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 9a2 2 0 0 1-2 2H6l-4 4V4c0-1.1.9-2 2-2h8a2 2 0 0 1 2 2v5Z"></path>
                            <path d="M18 9h2a2 2 0 0 1 2 2v11l-4-4h-6a2 2 0 0 1-2-2v-1"></path>
                        </svg>
                        Contact Us
                    </x-button>
                </div>
            </div>
            
            <div class="mt-12 text-center">
                <p class="text-slate-500 dark:text-slate-400">
                    We appreciate your patience as we work to improve your experience.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
