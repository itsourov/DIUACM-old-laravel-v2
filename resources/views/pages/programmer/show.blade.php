<x-app-layout :title="$programmer->name">
    <div class="py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Back button --}}
            <div class="mb-6">
                <a href="{{ route('programmer.index') }}" class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium transition-colors group">
                    <div class="mr-2 rounded-full bg-blue-50 dark:bg-blue-900/20 w-8 h-8 flex items-center justify-center group-hover:bg-blue-100 dark:group-hover:bg-blue-900/30 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m15 18-6-6 6-6"></path>
                        </svg>
                    </div>
                    Back to Programmers
                </a>
            </div>

            {{-- Programmer Profile --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden mb-10">
                <div class="bg-gradient-to-br from-blue-50 to-slate-100 dark:from-slate-800 dark:to-slate-900 p-10 relative">
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                        <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white dark:border-slate-700 shadow-lg bg-white dark:bg-slate-700">
                            @if($programmer->getMedia('profile-images')->isNotEmpty())
                                <img src="{{ $programmer->getFirstMediaUrl('profile-images', 'preview') }}" 
                                     alt="{{ $programmer->name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-blue-50 dark:bg-slate-800 text-3xl font-bold text-blue-600 dark:text-blue-400">
                                    {{ substr($programmer->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="text-center sm:text-left">
                            <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">{{ $programmer->name }}</h1>
                            <p class="text-lg text-slate-600 dark:text-slate-300 mb-4">{{ '@' . $programmer->username }}</p>
                            
                            <div class="flex flex-wrap gap-3 justify-center sm:justify-start">
                                @if($programmer->codeforces_handle)
                                    <a href="https://codeforces.com/profile/{{ $programmer->codeforces_handle }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-3.5 py-1.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1.5">
                                            <rect width="8" height="14" x="8" y="6" rx="4"></rect>
                                            <path d="m19 7-3 2"></path>
                                            <path d="m5 7 3 2"></path>
                                            <path d="m19 19-3-2"></path>
                                            <path d="m5 19 3-2"></path>
                                        </svg>
                                        Codeforces
                                    </a>
                                @endif
                                
                                @if($programmer->max_cf_rating)
                                    <div class="inline-flex items-center px-3.5 py-1.5 rounded-full text-sm font-medium
                                        @if($programmer->max_cf_rating >= 2400)
                                            bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                        @elseif($programmer->max_cf_rating >= 2100)
                                            bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400
                                        @elseif($programmer->max_cf_rating >= 1900)
                                            bg-violet-100 text-violet-800 dark:bg-violet-900/30 dark:text-violet-400
                                        @elseif($programmer->max_cf_rating >= 1600)
                                            bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                                        @elseif($programmer->max_cf_rating >= 1400)
                                            bg-teal-100 text-teal-800 dark:bg-teal-900/30 dark:text-teal-400
                                        @elseif($programmer->max_cf_rating >= 1200)
                                            bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                        @else
                                            bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400
                                        @endif">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1.5">
                                            <path d="M12 20.94c1.5 0 2.75 1.06 4 1.06 3 0 6-8 6-12.22A4.91 4.91 0 0 0 17 5c-2.22 0-4 1.44-5 2-1-.56-2.78-2-5-2a4.9 4.9 0 0 0-5 4.78C2 14 5 22 8 22c1.25 0 2.5-1.06 4-1.06Z"></path>
                                            <path d="M10 2c1 .5 2 2 2 5"></path>
                                        </svg>
                                        Rating: {{ $programmer->max_cf_rating }}
                                    </div>
                                @endif
                                
                                @if($programmer->atcoder_handle)
                                    <a href="https://atcoder.jp/users/{{ $programmer->atcoder_handle }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-3.5 py-1.5 rounded-full text-sm font-medium bg-teal-100 text-teal-800 dark:bg-teal-900/30 dark:text-teal-400 hover:bg-teal-200 dark:hover:bg-teal-900/50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1.5">
                                            <path d="M21 7.5V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-1.5"></path>
                                            <path d="M16 2v10"></path>
                                            <path d="M8 2v10"></path>
                                            <path d="M12 14v8"></path>
                                        </svg>
                                        AtCoder
                                    </a>
                                @endif

                                @if($programmer->vjudge_handle)
                                    <a href="https://vjudge.net/user/{{ $programmer->vjudge_handle }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-3.5 py-1.5 rounded-full text-sm font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400 hover:bg-purple-200 dark:hover:bg-purple-900/50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1.5">
                                            <path d="M20 7h-9"></path>
                                            <path d="M14 17H5"></path>
                                            <circle cx="17" cy="17" r="3"></circle>
                                            <circle cx="7" cy="7" r="3"></circle>
                                        </svg>
                                        VJudge
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 lg:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                        <div class="p-5 rounded-xl bg-blue-50 dark:bg-slate-700/50 flex items-center gap-4 border border-blue-100 dark:border-slate-700">
                            <div class="h-12 w-12 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center text-blue-600 dark:text-blue-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                                    <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-slate-600 dark:text-slate-400">Department</h3>
                                <p class="text-lg font-semibold text-slate-900 dark:text-white">
                                    {{ $programmer->department ?? 'N/A' }}
                                </p>
                            </div>
                        </div>

                        <div class="p-5 rounded-xl bg-emerald-50 dark:bg-slate-700/50 flex items-center gap-4 border border-emerald-100 dark:border-slate-700">
                            <div class="h-12 w-12 bg-emerald-100 dark:bg-emerald-900/50 rounded-lg flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 7h-9"></path>
                                    <path d="M14 17H5"></path>
                                    <circle cx="17" cy="17" r="3"></circle>
                                    <circle cx="7" cy="7" r="3"></circle>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-slate-600 dark:text-slate-400">Starting Semester</h3>
                                <p class="text-lg font-semibold text-slate-900 dark:text-white">
                                    {{ $programmer->starting_semester ?? 'N/A' }}
                                </p>
                            </div>
                        </div>

                        <div class="p-5 rounded-xl bg-purple-50 dark:bg-slate-700/50 flex items-center gap-4 border border-purple-100 dark:border-slate-700">
                            <div class="h-12 w-12 bg-purple-100 dark:bg-purple-900/50 rounded-lg flex items-center justify-center text-purple-600 dark:text-purple-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-slate-600 dark:text-slate-400">Student ID</h3>
                                <p class="text-lg font-semibold text-slate-900 dark:text-white">
                                    {{ $programmer->student_id ?? 'N/A' }}
                                </p>
                            </div>
                        </div>

                        <div class="p-5 rounded-xl bg-amber-50 dark:bg-slate-700/50 flex items-center gap-4 border border-amber-100 dark:border-slate-700">
                            <div class="h-12 w-12 bg-amber-100 dark:bg-amber-900/50 rounded-lg flex items-center justify-center text-amber-600 dark:text-amber-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 8h1a4 4 0 1 1 0 8h-1"></path>
                                    <path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"></path>
                                    <line x1="6" x2="6" y1="2" y2="4"></line>
                                    <line x1="10" x2="10" y1="2" y2="4"></line>
                                    <line x1="14" x2="14" y1="2" y2="4"></line>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-slate-600 dark:text-slate-400">Gender</h3>
                                <p class="text-lg font-semibold text-slate-900 dark:text-white">
                                    {{ $programmer->gender ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($programmer->teams->count() > 0)
                {{-- Teams Section --}}
                <div class="mb-10">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Contest Teams</h2>
                    </div>

                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($programmer->teams->sortByDesc(function($team) {
                            return $team->contest->date;
                        }) as $team)
                            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-md border border-slate-200 dark:border-slate-700 overflow-hidden hover:shadow-lg transition-all duration-300">
                                <div class="border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50 p-5 flex justify-between items-center">
                                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white">{{ $team->name }}</h3>
                                    
                                    @if($team->rank)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($team->rank == 1)
                                                bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400
                                            @elseif($team->rank == 2)
                                                bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300
                                            @elseif($team->rank == 3)
                                                bg-amber-100 text-amber-700 dark:bg-amber-900/20 dark:text-amber-500
                                            @else
                                                bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                                            @endif
                                        ">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                                                <path d="M8.21 13.89 7 23l5-3 5 3-1.21-9.11"></path>
                                                <path d="M15 7.5V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h1"></path>
                                            </svg>
                                            Rank: {{ $team->rank }}
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="p-5">
                                    <div class="mb-4">
                                        <a href="{{ route('contest.show', $team->contest->id) }}" class="text-blue-600 dark:text-blue-400 font-medium hover:underline">
                                            {{ $team->contest->name }}
                                        </a>
                                        <div class="text-sm text-slate-600 dark:text-slate-300 mt-1">
                                            <span class="inline-flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                                                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
                                                    <line x1="16" x2="16" y1="2" y2="6"></line>
                                                    <line x1="8" x2="8" y1="2" y2="6"></line>
                                                    <line x1="3" x2="21" y1="10" y2="10"></line>
                                                </svg>
                                                {{ $team->contest->date->format('M d, Y') }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-3">
                                        <h4 class="text-sm font-medium text-slate-500 dark:text-slate-400">Team Members:</h4>
                                        @foreach($team->members->where('id', '!=', $programmer->id) as $member)
                                            <div class="flex items-center gap-3">
                                                <div class="relative h-8 w-8 rounded-full overflow-hidden bg-gradient-to-br from-blue-50 to-slate-100 dark:from-slate-800 dark:to-slate-900 shadow-sm ring-1 ring-slate-200/60 dark:ring-slate-700/60">
                                                    @if($member->getMedia('profile-images')->isNotEmpty())
                                                        <img src="{{ $member->getFirstMediaUrl('profile-images', 'preview') }}" 
                                                            alt="{{ $member->name }}" 
                                                            class="h-full w-full object-cover">
                                                    @else
                                                        <div class="h-full w-full flex items-center justify-center text-slate-500 dark:text-slate-400 font-medium text-xs">
                                                            {{ substr($member->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <a href="{{ route('programmer.show', $member->username) }}" class="text-sm font-medium text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                                    {{ $member->name }}
                                                </a>
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
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
