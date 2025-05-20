<x-app-layout :title="$contest->name">
    <div class="py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Back button --}}
            <div class="mb-6">
                <a href="{{ route('contest.index') }}" class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium transition-colors group">
                    <div class="mr-2 rounded-full bg-blue-50 dark:bg-blue-900/20 w-8 h-8 flex items-center justify-center group-hover:bg-blue-100 dark:group-hover:bg-blue-900/30 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m15 18-6-6 6-6"></path>
                        </svg>
                    </div>
                    Back to Contests
                </a>
            </div>

            {{-- Contest details --}}                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden mb-10">
                <div class="p-6 sm:p-8">
                    <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
                        <div>
                            <div class="flex flex-wrap items-center gap-3 mb-3">
                                <span class="px-3.5 py-1.5 rounded-full text-xs font-medium inline-flex items-center shadow-sm
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
                                    {{ $contest->date->format('M d, Y') }}
                                </span>
                            </div>
                            <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-3 tracking-tight">
                                {{ $contest->name }}
                            </h1>
                        </div>

                        @if($contest->standings_url)
                            <x-button href="{{ $contest->standings_url }}" target="_blank" rel="noopener noreferrer" variant="primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                    <polyline points="15 3 21 3 21 9"></polyline>
                                    <line x1="10" y1="14" x2="21" y2="3"></line>
                                </svg>
                                View Official Standings
                            </x-button>
                        @endif
                    </div>

                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        @if($contest->location)
                            <div class="flex items-start p-4 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700/50">
                                <div class="bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 p-2.5 rounded-lg mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-medium text-slate-900 dark:text-white mb-1">Location</h3>
                                    <p class="text-slate-600 dark:text-slate-300">{{ $contest->location }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="flex items-start p-4 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700/50">
                            <div class="bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300 p-2.5 rounded-lg mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-medium text-slate-900 dark:text-white mb-1">Participation</h3>
                                <p class="text-slate-600 dark:text-slate-300">{{ count($contest->teams) }} teams participated</p>
                            </div>
                        </div>
                    </div>

                    @if($contest->description)
                        <div class="border-t border-slate-200 dark:border-slate-700 pt-6 mt-6">
                            <h2 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">About this contest</h2>
                            <div class="prose dark:prose-invert max-w-none text-slate-700 dark:text-slate-300">
                                {{ $contest->description }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Teams Section --}}
            <div class="mb-12">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">
                            Participating Teams
                        </h2>
                    </div>
                    <span class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-blue-100/60 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1.5">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        {{ count($contest->teams) }} Teams
                    </span>
                </div>

                @if(count($contest->teams) > 0)
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($contest->teams->sortBy(function($team) {
                            return $team->rank !== null ? $team->rank : 9999;
                        }) as $team)
                            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-md border border-slate-200 dark:border-slate-700 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                <div class="border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50 p-5 flex justify-between items-center">
                                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white">{{ $team->name }}</h3>
                                    @if($team->rank)
                                        <span class="inline-flex items-center justify-center bg-amber-50 text-amber-700 dark:bg-amber-900/20 dark:text-amber-300 px-3 py-1 rounded-full text-xs font-medium border border-amber-200 shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                                                <path d="M8.21 13.89 7 23l5-3 5 3-1.21-9.11"></path>
                                                <path d="M15 7a3 3 0 1 0-6 0c0 1.3.84 2.4 2 2.83.24.06.5.06.76 0A3.01 3.01 0 0 0 15 7z"></path>
                                            </svg>
                                            Rank: {{ $team->rank }}
                                        </span>
                                    @endif
                                </div>
                                <div class="p-5">
                                    <div class="space-y-4">
                                        @foreach($team->members as $member)
                                            <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800/80 transition-colors">
                                                <div class="relative h-10 w-10 rounded-full overflow-hidden bg-gradient-to-br from-blue-50 to-slate-100 dark:from-slate-800 dark:to-slate-900 shadow-sm ring-1 ring-slate-200/60 dark:ring-slate-700/60">
                                                    @if($member->getMedia('profile-images')->isNotEmpty())
                                                        <img src="{{ $member->getFirstMediaUrl('profile-images', 'preview') }}" 
                                                             alt="{{ $member->name }}" 
                                                             class="h-full w-full object-cover">
                                                    @else
                                                        <div class="h-full w-full flex items-center justify-center text-slate-500 dark:text-slate-400 font-medium">
                                                            {{ substr($member->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                                    {{ $member->name }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>

                                    @if($team->solveCount !== null)
                                        <div class="mt-5 pt-4 border-t border-slate-200 dark:border-slate-700 flex items-center gap-2">
                                            <div class="bg-blue-100 dark:bg-blue-900/30 p-1.5 rounded-md">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600 dark:text-blue-400">
                                                    <path d="m9 12 2 2 4-4"></path>
                                                    <path d="M12 2v1"></path>
                                                    <path d="M12 21v1"></path>
                                                    <path d="M4.22 4.22l.77.77"></path>
                                                    <path d="M18.36 18.36l1.27 1.27"></path>
                                                    <path d="M1 12h1"></path>
                                                    <path d="M21 12h1"></path>
                                                    <path d="M4.22 19.78l.77-.77"></path>
                                                    <path d="M18.36 5.64l1.27-1.27"></path>
                                                </svg>
                                            </div>
                                            <span class="font-medium text-sm text-slate-700 dark:text-slate-300">
                                                {{ $team->solveCount }} problems solved
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-md border border-slate-200 dark:border-slate-700 p-12 text-center">
                        <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mx-auto mb-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600 dark:text-blue-400">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-2">No teams yet</h3>
                        <p class="text-slate-600 dark:text-slate-300 max-w-md mx-auto">No teams have been added to this contest yet. Check back later for updates.</p>
                    </div>
                @endif
            </div>

            {{-- Gallery Section --}}
            @if($contest->gallery && $contest->gallery->getMedia('gallery-images')->isNotEmpty())
                <div class="mb-8 bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
                    <div class="mb-6">
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <div class="bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 p-2 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 9v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9"></path>
                                        <rect width="18" height="8" x="3" y="3" rx="1.5"></rect>
                                        <circle cx="9" cy="7" r="1.5"></circle>
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">
                                    Event Gallery
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach($contest->gallery->getMedia('gallery-images')->take(8) as $image)
                            <a href="{{ $image->getUrl() }}" class="gallery-item" data-fancybox="gallery" data-caption="{{ $image->custom_properties['caption'] ?? '' }}">
                                <div class="aspect-square rounded-2xl overflow-hidden shadow-md border border-slate-200 dark:border-slate-700 group relative hover:shadow-lg transition-all duration-300">
                                    <img 
                                        src="{{ $image->getUrl() }}" 
                                        alt="{{ $image->custom_properties['caption'] ?? $contest->gallery->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                    >
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-3">
                                        <div class="w-full">
                                            @if(isset($image->custom_properties['caption']) && $image->custom_properties['caption'])
                                                <p class="text-white text-xs truncate mb-1">{{ $image->custom_properties['caption'] }}</p>
                                            @endif
                                            <div class="flex justify-end w-full">
                                                <span class="text-white bg-blue-600/90 rounded-full h-8 w-8 flex items-center justify-center shadow-lg transform translate-y-2 group-hover:translate-y-0 transition-all">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="m21 21-6-6m2-5a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    
                    @if($contest->gallery)
                        <div class="mt-6 text-center">
                            <x-button href="{{ route('gallery.show', $contest->gallery->slug) }}" variant="secondary" size="md">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                    <path d="M21 9v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9"></path>
                                    <rect width="18" height="8" x="3" y="3" rx="1.5"></rect>
                                    <circle cx="9" cy="7" r="1.5"></circle>
                                </svg>
                                View Full Gallery
                            </x-button>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- Add Lightbox CSS & JS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Fancybox.bind('[data-fancybox="gallery"]', {
                // Options here
            });
            
            // Initialize Fancybox for gallery items
            Fancybox.bind(".gallery-item", {
                groupAll: true,
            });
        });
    </script>
    @endpush
</x-app-layout>
