<header class="bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 shadow-sm sticky top-0 z-40">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="/" class="flex items-center">
                    <span class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-blue-400 dark:to-cyan-300">DIU ACM</span>
                </a>
            </div>

            <!-- Navigation Links - Desktop -->
            <nav class="hidden md:ml-6 md:flex md:space-x-6">
                <a href="/" class="{{ request()->is('/') ? 'text-blue-600 dark:text-blue-400' : 'text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400' }} font-medium">Home</a>
                <a href="{{ route('about') }}" class="{{ request()->is('about') ? 'text-blue-600 dark:text-blue-400' : 'text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400' }} font-medium">About</a>
                <a href="{{ route('blog.index') }}" class="{{ request()->is('blog') || request()->is('blog/*') ? 'text-blue-600 dark:text-blue-400' : 'text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400' }} font-medium">Blog</a>
                <a href="{{ route('contest.index') }}" class="{{ request()->is('contests') || request()->is('contests/*') ? 'text-blue-600 dark:text-blue-400' : 'text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400' }} font-medium">Contests</a>
                <a href="{{ route('programmer.index') }}" class="{{ request()->is('programmers') || request()->is('programmers/*') ? 'text-blue-600 dark:text-blue-400' : 'text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400' }} font-medium">Programmers</a>
                <a href="{{ route('gallery.index') }}" class="{{ request()->is('gallery') || request()->is('gallery/*') ? 'text-blue-600 dark:text-blue-400' : 'text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400' }} font-medium">Gallery</a>
                <a href="{{ route('contact') }}" class="{{ request()->is('contact') ? 'text-blue-600 dark:text-blue-400' : 'text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400' }} font-medium">Contact</a>
            </nav>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button type="button" id="mobile-menu-button" class="text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div class="md:hidden hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700">
            <a href="/" class="{{ request()->is('/') ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700' }} block px-3 py-2 rounded-md font-medium">Home</a>
            <a href="{{ route('about') }}" class="{{ request()->is('about') ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700' }} block px-3 py-2 rounded-md font-medium">About</a>
            <a href="{{ route('blog.index') }}" class="{{ request()->is('blog') || request()->is('blog/*') ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700' }} block px-3 py-2 rounded-md font-medium">Blog</a>
            <a href="{{ route('contest.index') }}" class="{{ request()->is('contests') || request()->is('contests/*') ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700' }} block px-3 py-2 rounded-md font-medium">Contests</a>
            <a href="{{ route('programmer.index') }}" class="{{ request()->is('programmers') || request()->is('programmers/*') ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700' }} block px-3 py-2 rounded-md font-medium">Programmers</a>
            <a href="{{ route('gallery.index') }}" class="{{ request()->is('gallery') || request()->is('gallery/*') ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700' }} block px-3 py-2 rounded-md font-medium">Gallery</a>
            <a href="{{ route('contact') }}" class="{{ request()->is('contact') ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700' }} block px-3 py-2 rounded-md font-medium">Contact</a>
        </div>
    </div>

    <!-- Mobile menu toggle script -->
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        });
    </script>
    @endpush
</header>
