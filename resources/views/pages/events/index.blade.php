<x-app-layout title="Events">
    <div class="container mx-auto px-4 py-16">
        {{-- Header section --}}
        <div class="mb-12 text-center">
            <h1 class="text-4xl font-bold mb-4 text-slate-900 dark:text-white">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-blue-400 dark:to-cyan-300">
                    DIU ACM
                </span>
                Events
            </h1>
            <div class="mx-auto w-20 h-1.5 bg-gradient-to-r from-blue-600 to-cyan-500 rounded-full mb-6"></div>
            <p class="text-lg text-slate-600 dark:text-slate-300 max-w-2xl mx-auto">
                Browse our upcoming and past events, contests, classes, and workshops designed to enhance your competitive programming skills
            </p>
        </div>

        {{-- Search and filters --}}
        <div class="mb-8">
            <form action="{{ route('event.index') }}" method="GET" class="max-w-lg mx-auto">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search h-5 w-5 text-slate-500 dark:text-slate-400" aria-hidden="true">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </svg>
                    </div>
                    <input type="search" name="search" id="search" value="{{ request()->search }}" placeholder="Search events by title or description" class="w-full pl-10 pr-4 py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent text-slate-900 dark:text-slate-200" />
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                        Search
                    </button>
                </div>
            </form>
        </div>

        {{-- Events list --}}
        <div class="mx-auto">
            @if($events->isEmpty())
                <div class="text-center py-16">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-x mx-auto h-16 w-16 text-slate-400 dark:text-slate-500 mb-4" aria-hidden="true">
                        <path d="M8 2v4"></path>
                        <path d="M16 2v4"></path>
                        <path d="M3 10h18"></path>
                        <path d="M10 14l4 4m0-4l-4 4"></path>
                        <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                    </svg>
                    <h2 class="text-2xl font-semibold text-slate-700 dark:text-slate-300">No events found</h2>
                    <p class="mt-2 text-slate-600 dark:text-slate-400">Try adjusting your search or check back later for upcoming events.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($events as $event)
                    <div class="group hover:bg-slate-50 dark:hover:bg-slate-800/80 transition-all bg-white dark:bg-slate-800 rounded-2xl shadow-md border border-slate-200 dark:border-slate-700">
                        <a class="block p-5 relative z-10" href="{{ route('event.show', $event->id) }}">
                            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-2 mb-4">
                                <div class="flex-1">
                                    <h3 class="text-base sm:text-lg font-semibold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2 mb-2">
                                        {{ $event->title }}
                                    </h3>
                                    <div class="flex flex-wrap items-center gap-3 text-sm text-slate-500 dark:text-slate-400">
                                        <div class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-days h-4 w-4 text-blue-500" aria-hidden="true">
                                                <path d="M8 2v4"></path>
                                                <path d="M16 2v4"></path>
                                                <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                                                <path d="M3 10h18"></path>
                                                <path d="M8 14h.01"></path>
                                                <path d="M12 14h.01"></path>
                                                <path d="M16 14h.01"></path>
                                                <path d="M8 18h.01"></path>
                                                <path d="M12 18h.01"></path>
                                                <path d="M16 18h.01"></path>
                                            </svg>
                                            <span>{{ $event->starting_at->setTimezone('Asia/Dhaka')->format('M d, Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock h-4 w-4 text-blue-500" aria-hidden="true">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <polyline points="12 6 12 12 16 14"></polyline>
                                            </svg>
                                            <span>{{ $event->starting_at->setTimezone('Asia/Dhaka')->format('g:i A') }} - {{ $event->ending_at->setTimezone('Asia/Dhaka')->format('g:i A') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="sm:self-start">
                                    @if($event->ending_at->isPast())
                                        <span data-slot="badge" class="inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0 [&>svg]:size-3 gap-1 [&>svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden [a&]:hover:bg-secondary/90 bg-slate-100 text-slate-600 border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700">Ended</span>
                                    @elseif($event->starting_at->isPast() && !$event->ending_at->isPast())
                                        <span data-slot="badge" class="inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0 [&>svg]:size-3 gap-1 [&>svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden [a&]:hover:bg-secondary/90 bg-green-100 text-green-700 border-green-200 dark:bg-green-800/30 dark:text-green-400 dark:border-green-800">Ongoing</span>
                                    @else
                                        <span data-slot="badge" class="inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0 [&>svg]:size-3 gap-1 [&>svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden [a&]:hover:bg-secondary/90 bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-800/30 dark:text-blue-400 dark:border-blue-800">Upcoming</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="flex flex-wrap gap-2 mt-4">
                                @switch($event->type->value)
                                    @case('contest')
                                        <span data-slot="badge" class="inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0 [&>svg]:size-3 gap-1 [&>svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden border-transparent [a&]:hover:bg-primary/90 bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-500 dark:to-indigo-500 text-white border-none shadow-sm capitalize">🏆 contest</span>
                                    @break
                                    @case('class')
                                        <span data-slot="badge" class="inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0 [&>svg]:size-3 gap-1 [&>svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden border-transparent [a&]:hover:bg-primary/90 bg-gradient-to-r from-amber-600 to-orange-600 dark:from-amber-500 dark:to-orange-500 text-white border-none shadow-sm capitalize">📚 class</span>
                                    @break
                                    @default
                                        <span data-slot="badge" class="inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0 [&>svg]:size-3 gap-1 [&>svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden border-transparent [a&]:hover:bg-primary/90 bg-gradient-to-r from-emerald-600 to-teal-600 dark:from-emerald-500 dark:to-teal-500 text-white border-none shadow-sm capitalize">📋 event</span>
                                @endswitch
                                
                                @switch($event->participation_scope->value)
                                    @case('open_for_all')
                                        <span data-slot="badge" class="inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0 [&>svg]:size-3 gap-1 [&>svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden text-foreground [a&]:hover:bg-accent [a&]:hover:text-accent-foreground backdrop-blur-sm bg-white/30 dark:bg-slate-800/30 border-slate-200 dark:border-slate-700">👥 Open for All</span>
                                    @break
                                    @case('only_girls')
                                        <span data-slot="badge" class="inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0 [&>svg]:size-3 gap-1 [&>svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden text-foreground [a&]:hover:bg-accent [a&]:hover:text-accent-foreground backdrop-blur-sm bg-white/30 dark:bg-slate-800/30 border-slate-200 dark:border-slate-700">👩‍💻 Girls Only</span>
                                    @break
                                    @case('junior_programmers')
                                        <span data-slot="badge" class="inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0 [&>svg]:size-3 gap-1 [&>svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden text-foreground [a&]:hover:bg-accent [a&]:hover:text-accent-foreground backdrop-blur-sm bg-white/30 dark:bg-slate-800/30 border-slate-200 dark:border-slate-700">🌱 Junior Programmers</span>
                                    @break
                                    @default
                                        <span data-slot="badge" class="inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0 [&>svg]:size-3 gap-1 [&>svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden text-foreground [a&]:hover:bg-accent [a&]:hover:text-accent-foreground backdrop-blur-sm bg-white/30 dark:bg-slate-800/30 border-slate-200 dark:border-slate-700">✓ Selected Persons</span>
                                @endswitch

                                @if($event->starting_at < $event->ending_at)
                                    @php
                                        $durationHours = $event->starting_at->diffInMinutes($event->ending_at) / 60;
                                        $formattedDuration = $durationHours >= 1 
                                            ? floor($durationHours) . 'h' . ($durationHours - floor($durationHours) > 0 ? ' ' . floor(($durationHours - floor($durationHours)) * 60) . 'm' : '') 
                                            : floor($durationHours * 60) . 'm';
                                    @endphp
                                    <span data-slot="badge" class="inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0 [&>svg]:size-3 gap-1 [&>svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden text-foreground [a&]:hover:bg-accent [a&]:hover:text-accent-foreground backdrop-blur-sm bg-white/30 dark:bg-slate-800/30 border-slate-200 dark:border-slate-700">⏱️ {{ $formattedDuration }}</span>
                                @endif
                            </div>

                            <div class="mt-4 flex items-center text-sm text-slate-600 dark:text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users h-4 w-4 mr-1.5 text-blue-500" aria-hidden="true">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                                <span class="flex items-center gap-1">
                                    <span class="font-medium text-slate-800 dark:text-slate-200">{{ $event->attendedUsers()->count() }}</span> attendees
                                </span>
                            </div>

                            <div class="absolute bottom-4 right-4 h-8 w-8 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up-right h-4 w-4 text-blue-700 dark:text-blue-400" aria-hidden="true">
                                    <path d="M7 7h10v10"></path>
                                    <path d="M7 17 17 7"></path>
                                </svg>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $events->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
