<x-app-layout title="Trackers">
    <div class="container mx-auto px-4 py-16">
        {{-- Header section --}}
        <div class="mb-12 text-center">
            <h1 class="text-4xl font-bold mb-4 text-slate-900 dark:text-white">
                Performance
                <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-blue-400 dark:to-cyan-300">
                    Trackers
                </span>
            </h1>
            <div class="mx-auto w-20 h-1.5 bg-gradient-to-r from-blue-600 to-cyan-500 rounded-full mb-6"></div>
            <p class="text-lg text-slate-600 dark:text-slate-300 max-w-xl mx-auto">
                Trackers are a great way to keep track of your performance in competitive programming.
            </p>
        </div>

        <!-- Trackers grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($trackers as $tracker)
                <a href="{{ route('tracker.show', $tracker->slug) }}" 
                   class="block group relative bg-white dark:bg-slate-800/80 shadow-md hover:shadow-lg transition-all duration-300 rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-700">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-blue-500/0 to-blue-500/5 dark:from-blue-600/0 dark:to-blue-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <div class="p-6 relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $tracker->title }}</h3>
                            <div
                                class="bg-slate-100 dark:bg-slate-700 rounded-full p-2 group-hover:bg-blue-100 dark:group-hover:bg-blue-800/30 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round"
                                     class="text-slate-600 dark:text-slate-300 group-hover:text-blue-600 dark:group-hover:text-blue-400">
                                    <path d="M21.21 15.89A10 10 0 1 1 8 2.83"/>
                                    <path d="M22 12A10 10 0 0 0 12 2v10z"/>
                                </svg>
                            </div>
                        </div>

                        <p class="text-slate-600 dark:text-slate-300 mb-6 line-clamp-2 h-12">{{ $tracker->description }}</p>

                        <div class="flex justify-end">
                            <span
                               class="inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 group-hover:translate-x-1 transition-transform duration-200">
                                View ranklists
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="ml-1">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <div
                    class="col-span-1 md:col-span-3 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-200 dark:border-slate-700 p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="w-12 h-12 mx-auto text-slate-400 dark:text-slate-500 mb-4">
                        <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <path d="M12 18v-6"></path>
                        <path d="M8 18v-1"></path>
                        <path d="M16 18v-3"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-slate-700 dark:text-slate-300">No trackers available</h3>
                    <p class="text-slate-500 dark:text-slate-400 mt-1">Check back soon for upcoming performance
                        trackers</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $trackers->links() }}
        </div>
    </div>

</x-app-layout>
