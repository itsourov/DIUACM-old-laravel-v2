<x-app-layout title="Contests">
    <div class="py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header section --}}
            <div class="mb-14 text-center">
                <h1 class="text-4xl font-bold mb-4 text-slate-900 dark:text-white">
                    Programming
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-blue-400 dark:to-cyan-300">
                        Contests
                    </span>
                </h1>
                <div class="mx-auto w-20 h-1 bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-blue-400 dark:to-cyan-300 rounded-full mb-6"></div>
                <p class="text-lg text-slate-600 dark:text-slate-300 max-w-2xl mx-auto">
                    Track our participation in competitive programming competitions and achievements
                </p>
            </div>

            {{-- Contests List --}}
            <div class="space-y-6">
                @forelse($contests as $contest)
                    <div class="overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        <a href="{{ route('contest.show', $contest->id) }}" class="block group">
                            <div class="px-6 py-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div>
                                    <div class="flex flex-wrap items-center gap-3 mb-3">
                                        <span class="px-3.5 py-1.5 rounded-full text-xs font-medium inline-flex items-center
                                            @if($contest->contest_type->value === 'icpc_regional')
                                                bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                            @elseif($contest->contest_type->value === 'icpc_asia_west')
                                                bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300
                                            @elseif($contest->contest_type->value === 'iupc')
                                                bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                            @else
                                                bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                                            @endif
                                        ">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                                                <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
                                                <polyline points="14 2 14 8 20 8"></polyline>
                                            </svg>
                                            {{ $contest->contest_type->getLabel() }}
                                        </span>
                                        <span class="text-sm text-slate-500 dark:text-slate-400 inline-flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                                                <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
                                                <line x1="16" x2="16" y1="2" y2="6"></line>
                                                <line x1="8" x2="8" y1="2" y2="6"></line>
                                                <line x1="3" x2="21" y1="10" y2="10"></line>
                                            </svg>
                                            {{ $contest->date?->format('M d, Y') }}
                                        </span>
                                    </div>
                                    <h2 class="text-xl font-semibold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors tracking-tight">
                                        {{ $contest->name }}
                                    </h2>
                                    @if($contest->location)
                                        <div class="mt-2 flex items-center text-slate-600 dark:text-slate-300 text-sm">
                                            <div class="p-1 bg-slate-100 dark:bg-slate-700 rounded-md mr-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                                                    <circle cx="12" cy="10" r="3"></circle>
                                                </svg>
                                            </div>
                                            {{ $contest->location }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="flex items-center gap-1 text-slate-600 dark:text-slate-300 bg-slate-50 dark:bg-slate-700/50 px-3 py-1.5 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1 text-blue-500 dark:text-blue-400">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        </svg>
                                        <span class="font-medium">{{ $contest->teams_count }}</span>
                                        <span class="text-sm">teams</span>
                                    </div>
                                    <div class="bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-full w-9 h-9 flex items-center justify-center shadow-sm group-hover:bg-blue-100 dark:group-hover:bg-blue-900/40 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m9 18 6-6-6-6"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="text-center py-16 bg-white dark:bg-slate-800 rounded-2xl shadow-md border border-slate-200 dark:border-slate-700">
                        <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mx-auto mb-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600 dark:text-blue-400">
                                <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
                                <line x1="16" x2="16" y1="2" y2="6"></line>
                                <line x1="8" x2="8" y1="2" y2="6"></line>
                                <line x1="3" x2="21" y1="10" y2="10"></line>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-2">No contests yet</h3>
                        <p class="text-slate-600 dark:text-slate-300 max-w-md mx-auto">There are no contests available at the moment. Check back later for upcoming competitions.</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-12">

                    {{ $contests->links() }}

            </div>
        </div>
    </div>
</x-app-layout>
