<x-app-layout title="{{ $tracker->title }}">
    <div class="container mx-auto px-4 py-12">
        {{-- Tracker header section --}}
        <div class="bg-white dark:bg-slate-800 shadow-md rounded-2xl p-6 md:p-8 border border-slate-200 dark:border-slate-700 mb-8">
            <div class="mb-6">
                {{-- Back link --}}
                <a href="{{ route('tracker.index') }}" class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left h-4 w-4 mr-1" aria-hidden="true">
                        <path d="m12 19-7-7 7-7"></path>
                        <path d="M19 12H5"></path>
                    </svg>
                    Back to Trackers
                </a>
                
                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white">{{ $tracker->title }}</h1>
                        
                        @if($tracker->description)
                        <p class="mt-3 text-slate-600 dark:text-slate-300">
                            {{ $tracker->description }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            
            {{-- Ranklist navigation tabs --}}
            @if($otherRanklists->count() > 0)
            <div class="mb-6">
                <h2 class="text-lg font-medium text-slate-800 dark:text-slate-200 mb-3">Ranklists</h2>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('tracker.show', $tracker->slug) }}" 
                        class="inline-flex px-4 py-2 rounded-lg text-sm font-medium {{ !request()->query('keyword') ? 'bg-blue-600 text-white' : 'bg-slate-100 dark:bg-slate-700 text-slate-800 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-600' }}">
                        {{ $ranklist->keyword ?? 'Default' }}
                    </a>
                    
                    @foreach($otherRanklists as $otherRanklist)
                    <a href="{{ route('tracker.show', [$tracker->slug, 'keyword' => $otherRanklist->keyword]) }}" 
                        class="inline-flex px-4 py-2 rounded-lg text-sm font-medium {{ request()->query('keyword') == $otherRanklist->keyword ? 'bg-blue-600 text-white' : 'bg-slate-100 dark:bg-slate-700 text-slate-800 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-600' }}">
                        {{ $otherRanklist->keyword }}
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Current ranklist info --}}
            <div class="mb-6">
                <div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-3">
                    <div>
                        <h2 class="text-xl font-bold text-slate-800 dark:text-slate-200">{{ $ranklist->keyword }} Ranklist</h2>
                        @if($ranklist->description)
                        <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">{{ $ranklist->description }}</p>
                        @endif
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="inline-flex items-center gap-x-1.5 rounded-md px-2.5 py-1.5 text-sm font-medium bg-blue-50/80 text-blue-700 ring-1 ring-inset ring-blue-600/20 dark:bg-blue-900/20 dark:text-blue-400 dark:ring-blue-800/60">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            {{ $users->count() }} users
                        </span>
                        
                        <span class="inline-flex items-center gap-x-1.5 rounded-md px-2.5 py-1.5 text-sm font-medium bg-blue-50/80 text-blue-700 ring-1 ring-inset ring-blue-600/20 dark:bg-blue-900/20 dark:text-blue-400 dark:ring-blue-800/60">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                <path d="M2 18h1.4c1.3 0 2.5-.6 3.3-1.7l6.1-8.6c.7-1.1 2-1.7 3.3-1.7H22"></path>
                                <path d="m18 2 4 4-4 4"></path>
                                <path d="M2 6h1.9c1.5 0 2.9.9 3.6 2.2"></path>
                                <path d="M22 18h-5.9c-1.3 0-2.6-.7-3.3-1.8l-.5-.8"></path>
                                <path d="m18 14 4 4-4 4"></path>
                            </svg>
                            {{ $events->count() }} events
                        </span>
                    </div>
                </div>
            </div>

            {{-- Ranklist table --}}
            <div>
                @if($users->isEmpty() || $events->isEmpty())
                <div class="text-center py-8 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-200 dark:border-slate-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-table mx-auto h-12 w-12 text-slate-400 dark:text-slate-500 mb-4" aria-hidden="true">
                        <path d="M12 3v18"></path>
                        <rect width="18" height="18" x="3" y="3" rx="2"></rect>
                        <path d="M3 9h18"></path>
                        <path d="M3 15h18"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-slate-700 dark:text-slate-300">No data available</h3>
                    <p class="text-slate-600 dark:text-slate-400 mt-1">This ranklist doesn't have any data to display yet.</p>
                </div>
                @else
                <div class="relative">
                    <div class="absolute inset-0 pointer-events-none shadow-[inset_-20px_0_12px_-10px_rgba(255,255,255,0.9)] dark:shadow-[inset_-20px_0_12px_-10px_rgba(30,41,59,0.9)] z-20 hidden md:block"></div>
                    <div class="overflow-x-auto overflow-y-visible scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-700 scrollbar-track-transparent pb-1 max-h-[calc(100vh-300px)]">
                        <div class="inline-block min-w-full align-middle rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                        <thead class="bg-slate-50 dark:bg-slate-800/80">
                            <tr>
                                <th scope="col" class="sticky left-0 z-10 bg-slate-50 dark:bg-slate-800/80 px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    #
                                </th>
                                <th scope="col" class="sticky left-16 z-10 bg-slate-50 dark:bg-slate-800/80 px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Points
                                </th>
                                @foreach($events as $event)
                                <th scope="col" class="px-4 py-3 text-start text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider whitespace-nowrap">
                                    <div class="flex flex-col gap-1">
                                        <a href="{{ $event->event_link ?? '#' }}" target="_blank" class="max-w-52 overflow-hidden text-xs font-semibold uppercase tracking-wide text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 truncate">
                                            {{ $event->title }}
                                        </a>
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-normal normal-case text-slate-500 dark:text-slate-400">{{ $event->starting_at->format('M d, Y') }}</span>
                                            <span class="inline-flex items-center gap-x-1 rounded-md text-xs font-medium ring-1 ring-inset px-2 py-0.5 bg-blue-50/80 text-blue-700 ring-blue-600/20 dark:bg-blue-900/20 dark:text-blue-400 dark:ring-blue-800/60">
                                                W: {{ $event->pivot->weight ?? 1 }}
                                            </span>
                                        </div>
                                    </div>
                                </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                            @php
                                $sortedUsers = $users->sortByDesc(function($user) {
                                    return $user->pivot->score ?? 0;
                                });
                                $rank = 1;
                            @endphp
                            
                            @foreach($sortedUsers as $user)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-800">
                                <td class="sticky left-0 z-10 bg-white dark:bg-slate-800 hover:bg-gray-100 dark:hover:bg-gray-800 px-4 py-2 whitespace-nowrap">
                                    <div class="flex items-center gap-x-2 text-gray-800 dark:text-neutral-200">
                                        <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                        </svg>
                                        <span class="text-sm">{{ $rank++ }}</span>
                                    </div>
                                </td>
                                <td class="sticky left-16 z-10 bg-white dark:bg-slate-800 hover:bg-gray-100 dark:hover:bg-gray-800 px-4 py-2 whitespace-nowrap">
                                    <a href="{{ route('programmer.show', $user->username) }}" class="flex items-center gap-x-3">
                                        @if($user->hasMedia('avatar'))
                                            <img src="{{ $user->getFirstMediaUrl('avatar', 'preview') }}" alt="{{ $user->name }}" class="h-8 w-8 flex-shrink-0 rounded-full border border-slate-200 dark:border-slate-700">
                                        @else
                                            <div class="h-8 w-8 flex-shrink-0 rounded-full bg-gray-300 dark:bg-slate-700 flex items-center justify-center">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <span class="text-sm font-semibold text-gray-800 dark:text-white">
                                            {{ $user->name }}
                                        </span>
                                    </a>
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    <span class="text-sm text-gray-800 dark:text-white">
                                        {{ number_format($user->pivot->score ?? 0, 1) }}
                                    </span>
                                </td>
                                
                                @foreach($events as $event)
                                    @php
                                        $solvestat = $event->userSolveStats->where('user_id', $user->id)->first();
                                    @endphp
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <div class="flex gap-2 w-max">
                                            @if(!$solvestat || !$solvestat->participation)
                                                <span class="inline-flex items-center gap-x-1 rounded-md text-xs font-medium ring-1 ring-inset bg-red-50/80 text-red-700 ring-red-600/20 dark:bg-red-900/20 dark:text-red-400 dark:ring-red-800/60 w-fit px-2 py-0.5">
                                                        <span class="truncate">
                                                            Absent
                                                        </span>
                                                    </span>
                                            @else
                                                <span class="inline-flex items-center gap-x-1 rounded-md text-xs font-medium ring-1 ring-inset bg-green-50/80 text-green-700 ring-green-600/20 dark:bg-green-900/20 dark:text-green-400 dark:ring-green-800/60 w-fit px-2 py-0.5">
                                                    <span class="truncate">
                                                        {{ $solvestat->solve_count }}
                                                        Solve
                                                    </span>
                                                </span>
                                                
                                                @if(($solvestat->upsolve_count ?? 0) > 0)
                                                <span class="inline-flex items-center gap-x-1 rounded-md text-xs font-medium ring-1 ring-inset bg-gray-50/80 text-gray-700 ring-gray-600/20 dark:bg-gray-900/20 dark:text-gray-400 dark:ring-gray-800/60 w-fit px-2 py-0.5">
                                                    <span class="truncate">
                                                        {{ $solvestat->upsolve_count ?? 0 }}
                                                        Upsolve
                                                    </span>
                                                </span>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                        </div>
                    </div>
                </div>
                <div class="mt-4 bg-blue-50/50 dark:bg-blue-900/10 p-3 rounded-lg border border-blue-100 dark:border-blue-800/50">
                    <div class="flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-blue-600 dark:text-blue-400 mt-0.5">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M12 16v-4"></path>
                            <path d="M12 8h.01"></path>
                        </svg>
                        <div class="text-sm text-slate-700 dark:text-slate-300">
                            <p class="font-medium">Scoring Information</p>
                            <ul class="mt-1 space-y-1 ml-4 list-disc text-slate-600 dark:text-slate-400">
                                <li>Scores are calculated based on solve performance and upsolve counts</li>
                                @if($ranklist->weight_of_upsolve > 0)
                                    <li>Upsolve weight: <span class="font-medium">{{ $ranklist->weight_of_upsolve }}</span></li>
                                @endif
                                <li>Event weights are displayed under each event title</li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            {{-- Action buttons --}}
            <div class="flex flex-wrap gap-3 pt-6 mt-6 border-t border-slate-200 dark:border-slate-700">
                <a href="{{ route('tracker.index') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-200 border-slate-300 dark:border-slate-600 hover:bg-slate-100 dark:hover:bg-slate-700 h-10 px-4 py-2">
                    Back to Trackers
                </a>
            </div>
        </div>
    </div>
</x-app-layout> 