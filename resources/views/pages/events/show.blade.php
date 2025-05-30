<x-app-layout title="{{ $event->title }}">
    <div class="container mx-auto px-4 py-12">
        {{-- Event header section --}}
        <div class="bg-white dark:bg-slate-800 shadow-md rounded-2xl p-6 md:p-8 border border-slate-200 dark:border-slate-700 mb-8">
            <div class="mb-6">
                {{-- Back link --}}
                <a href="{{ route('event.index') }}" class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left h-4 w-4 mr-1" aria-hidden="true">
                        <path d="m12 19-7-7 7-7"></path>
                        <path d="M19 12H5"></path>
                    </svg>
                    Back to Events
                </a>
                
                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white">{{ $event->title }}</h1>
                        
                        <div class="flex flex-wrap items-center gap-4 mt-3 text-slate-600 dark:text-slate-300">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-days h-5 w-5 text-blue-500" aria-hidden="true">
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
                                <span class="text-base">{{ $event->starting_at->format('F j, Y') }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock h-5 w-5 text-blue-500" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                <span class="text-base">{{ $event->starting_at->format('g:i A') }} - {{ $event->ending_at->format('g:i A') }}</span>
                            </div>
                            
                            @if($event->event_link)
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-link h-5 w-5 text-blue-500" aria-hidden="true">
                                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                                </svg>
                                <a href="{{ $event->event_link }}" target="_blank" class="text-base text-blue-600 dark:text-blue-400 hover:underline">Event Link</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex gap-2 self-start">
                        @if($hasEnded)
                            <span class="inline-flex items-center rounded-md bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 px-3 py-1.5 text-sm font-medium text-slate-600 dark:text-slate-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-circle h-4 w-4 mr-1.5 text-slate-500 dark:text-slate-400" aria-hidden="true">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <path d="m9 11 3 3L22 4"></path>
                                </svg>
                                Ended
                            </span>
                        @elseif($event->starting_at->isPast() && !$event->ending_at->isPast())
                            <span class="inline-flex items-center rounded-md bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-900 px-3 py-1.5 text-sm font-medium text-green-700 dark:text-green-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-play h-4 w-4 mr-1.5 text-green-600 dark:text-green-500" aria-hidden="true">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                                Ongoing
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-md bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-900 px-3 py-1.5 text-sm font-medium text-blue-700 dark:text-blue-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar h-4 w-4 mr-1.5 text-blue-600 dark:text-blue-500" aria-hidden="true">
                                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
                                    <line x1="16" x2="16" y1="2" y2="6"></line>
                                    <line x1="8" x2="8" y1="2" y2="6"></line>
                                    <line x1="3" x2="21" y1="10" y2="10"></line>
                                </svg>
                                Upcoming
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="space-y-6">
                {{-- Event tags/badges --}}
                <div class="flex flex-wrap gap-2">
                    @switch($event->type->value)
                        @case('contest')
                            <span data-slot="badge" class="inline-flex items-center justify-center rounded-md border px-3 py-1 text-sm font-medium w-fit whitespace-nowrap shrink-0 [&>svg]:size-4 gap-1 [&>svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden border-transparent [a&]:hover:bg-primary/90 bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-500 dark:to-indigo-500 text-white border-none shadow-sm capitalize">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trophy h-4 w-4" aria-hidden="true">
                                    <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
                                    <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path>
                                    <path d="M4 22h16"></path>
                                    <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"></path>
                                    <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"></path>
                                    <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"></path>
                                </svg>
                                Contest
                            </span>
                        @break
                        @case('class')
                            <span data-slot="badge" class="inline-flex items-center justify-center rounded-md border px-3 py-1 text-sm font-medium w-fit whitespace-nowrap shrink-0 [&>svg]:size-4 gap-1 [&>svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden border-transparent [a&]:hover:bg-primary/90 bg-gradient-to-r from-amber-600 to-orange-600 dark:from-amber-500 dark:to-orange-500 text-white border-none shadow-sm capitalize">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-graduation-cap h-4 w-4" aria-hidden="true">
                                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                                    <path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"></path>
                                </svg>
                                Class
                            </span>
                        @break
                        @default
                            <span data-slot="badge" class="inline-flex items-center justify-center rounded-md border px-3 py-1 text-sm font-medium w-fit whitespace-nowrap shrink-0 [&>svg]:size-4 gap-1 [&>svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden border-transparent [a&]:hover:bg-primary/90 bg-gradient-to-r from-emerald-600 to-teal-600 dark:from-emerald-500 dark:to-teal-500 text-white border-none shadow-sm capitalize">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-check h-4 w-4" aria-hidden="true">
                                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
                                    <line x1="16" x2="16" y1="2" y2="6"></line>
                                    <line x1="8" x2="8" y1="2" y2="6"></line>
                                    <line x1="3" x2="21" y1="10" y2="10"></line>
                                    <path d="m9 16 2 2 4-4"></path>
                                </svg>
                                Event
                            </span>
                    @endswitch
                    
                    @switch($event->participation_scope->value)
                        @case('open_for_all')
                            <span data-slot="badge" class="inline-flex items-center justify-center rounded-md border px-3 py-1 text-sm font-medium w-fit whitespace-nowrap shrink-0 [&>svg]:size-4 gap-1 [&>svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden text-foreground [a&]:hover:bg-accent [a&]:hover:text-accent-foreground backdrop-blur-sm bg-white/30 dark:bg-slate-800/30 border-slate-200 dark:border-slate-700">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users h-4 w-4 text-slate-600 dark:text-slate-400" aria-hidden="true">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                                Open for All
                            </span>
                        @break
                        @case('only_girls')
                            <span data-slot="badge" class="inline-flex items-center justify-center rounded-md border px-3 py-1 text-sm font-medium w-fit whitespace-nowrap shrink-0 [&>svg]:size-4 gap-1 [&>svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden text-foreground [a&]:hover:bg-accent [a&]:hover:text-accent-foreground backdrop-blur-sm bg-white/30 dark:bg-slate-800/30 border-slate-200 dark:border-slate-700">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user h-4 w-4 text-slate-600 dark:text-slate-400" aria-hidden="true">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                Girls Only
                            </span>
                        @break
                        @case('junior_programmers')
                            <span data-slot="badge" class="inline-flex items-center justify-center rounded-md border px-3 py-1 text-sm font-medium w-fit whitespace-nowrap shrink-0 [&>svg]:size-4 gap-1 [&>svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden text-foreground [a&]:hover:bg-accent [a&]:hover:text-accent-foreground backdrop-blur-sm bg-white/30 dark:bg-slate-800/30 border-slate-200 dark:border-slate-700">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sprout h-4 w-4 text-slate-600 dark:text-slate-400" aria-hidden="true">
                                    <path d="M7 20h10"></path>
                                    <path d="M10 20c5.5-2.5.8-6.4 3-10"></path>
                                    <path d="M9.5 9.4c1.1.8 1.8 2.2 2.3 3.7-2 .4-3.6.4-4.8-.3-1.2-.6-2.3-1.9-3-4.2"></path>
                                    <path d="M14.1 6a7 7 0 0 0-1.1 4c1.9-.1 3.3-.6 4.3-1.4 1-1 1.6-2.3 1.7-4.6"></path>
                                </svg>
                                Junior Programmers
                            </span>
                        @break
                        @default
                            <span data-slot="badge" class="inline-flex items-center justify-center rounded-md border px-3 py-1 text-sm font-medium w-fit whitespace-nowrap shrink-0 [&>svg]:size-4 gap-1 [&>svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden text-foreground [a&]:hover:bg-accent [a&]:hover:text-accent-foreground backdrop-blur-sm bg-white/30 dark:bg-slate-800/30 border-slate-200 dark:border-slate-700">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-circle h-4 w-4 text-slate-600 dark:text-slate-400" aria-hidden="true">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <path d="m9 11 3 3L22 4"></path>
                                </svg>
                                Selected Persons
                            </span>
                    @endswitch

                    <span data-slot="badge" class="inline-flex items-center justify-center rounded-md border px-3 py-1 text-sm font-medium w-fit whitespace-nowrap shrink-0 [&>svg]:size-4 gap-1 [&>svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden text-foreground [a&]:hover:bg-accent [a&]:hover:text-accent-foreground backdrop-blur-sm bg-white/30 dark:bg-slate-800/30 border-slate-200 dark:border-slate-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock h-4 w-4 text-slate-600 dark:text-slate-400" aria-hidden="true">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        {{ $durationFormatted }}h
                    </span>
                </div>

                {{-- Description --}}
                <div class="prose dark:prose-invert max-w-none">
                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-3">About This Event</h3>
                    <div class="text-slate-700 dark:text-slate-300 leading-relaxed">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                </div>

                {{-- Event details boxes --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                    @if($event->open_for_attendance)
                    <div class="bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl p-4">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users h-5 w-5 text-blue-600 dark:text-blue-400" aria-hidden="true">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-slate-900 dark:text-white">Attendance</h4>
                                <p class="text-slate-600 dark:text-slate-400">{{ $attendeesCount }} people attending</p>
                            </div>
                        </div>
                        
                        @if(auth()->check())
                            @if($hasAttended)
                                <div class="rounded-md bg-green-50 dark:bg-green-900/20 p-3 mt-3">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-circle h-5 w-5 text-green-400" aria-hidden="true">
                                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                <path d="m9 11 3 3L22 4"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-green-800 dark:text-green-300">Attendance Marked</h3>
                                            <div class="mt-1 text-sm text-green-700 dark:text-green-400">
                                                <p>You have already marked your attendance for this event.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="mt-3">
                                    <div class="text-sm mb-3 text-slate-700 dark:text-slate-300">
                                        <div class="flex items-center mb-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock h-4 w-4 mr-1.5 text-slate-500 dark:text-slate-400" aria-hidden="true">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <polyline points="12 6 12 12 16 14"></polyline>
                                            </svg>
                                            <span>{{ $attendanceMessage }}</span>
                                        </div>
                                    </div>
                                    
                                    @if($attendanceOpen)
                                    <form action="{{ route('event.attendance', $event->id) }}" method="POST" class="space-y-3">
                                        @csrf
                                        @if($event->event_password)
                                            <div class="space-y-1">
                                                <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Event Password</label>
                                                <input type="password" name="password" id="password" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400" placeholder="Enter password to mark attendance" required>
                                            </div>
                                        @endif
                                        <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 dark:focus-visible:ring-blue-400 focus-visible:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600 text-white h-9 px-4 py-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check mr-2 h-4 w-4" aria-hidden="true">
                                                <path d="M20 6 9 17l-5-5"></path>
                                            </svg>
                                            Mark Attendance
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            @endif
                        @else
                            <div class="rounded-md bg-blue-50 dark:bg-blue-900/20 p-3 mt-3">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info h-5 w-5 text-blue-400" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="M12 16v-4"></path>
                                            <path d="M12 8h.01"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-blue-700 dark:text-blue-400">
                                            Please <a href="{{ route('login') }}" class="font-medium underline">login</a> to mark attendance for this event.
                                        </p>
                                        <p class="text-sm text-blue-700 dark:text-blue-400 mt-1">
                                            Note: Attendance is only available from 15 minutes before the event starts until 30 minutes after it ends.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @endif

                    @if($event->event_link)
                    <div class="bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl p-4">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-link h-5 w-5 text-blue-600 dark:text-blue-400" aria-hidden="true">
                                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-slate-900 dark:text-white">Event Link</h4>
                                <a href="{{ $event->event_link }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">Join the event</a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Attendees list section --}}
                @if($event->open_for_attendance && $attendeesCount > 0)
                <div class="mt-6">
                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">Attendees ({{ $attendeesCount }})</h3>
                    
                    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
                            @foreach($attendees as $attendee)
                            <a href="{{ route('programmer.show', $attendee->username) }}" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800/70 transition-colors">
                                <div class="flex-shrink-0">
                                    @if($attendee->hasMedia('avatar'))
                                        <img src="{{ $attendee->getFirstMediaUrl('avatar', 'preview') }}" alt="{{ $attendee->name }}" class="w-10 h-10 rounded-full object-cover border border-slate-200 dark:border-slate-700">
                                       @else
                                        <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-800 dark:text-slate-200 font-medium">
                                            {{ strtoupper(substr($attendee->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $attendee->name }}</p>
                                    <div class="flex items-center gap-1.5">
                                        @if($attendee->student_id)
                                        <span class="text-xs text-slate-500 dark:text-slate-400">{{ $attendee->student_id }}</span>
                                       @else 
                                                                               <span class="text-xs text-slate-500 dark:text-slate-400">null</span>

                                        @endif
                                    
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                        
                        @if($attendees->hasPages())
                        <div class="border-t border-slate-200 dark:border-slate-700 p-4">
                            {{ $attendees->links() }}
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Flash Messages --}}
                @if(session('success') || session('error') || session('info'))
                <div class="mt-6">
                    @if(session('success'))
                    <div class="rounded-md bg-green-50 dark:bg-green-900/20 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-circle h-5 w-5 text-green-400" aria-hidden="true">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <path d="m9 11 3 3L22 4"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800 dark:text-green-300">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="rounded-md bg-red-50 dark:bg-red-900/20 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-circle h-5 w-5 text-red-400" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="m15 9-6 6"></path>
                                    <path d="m9 9 6 6"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800 dark:text-red-300">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(session('info'))
                    <div class="rounded-md bg-blue-50 dark:bg-blue-900/20 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info h-5 w-5 text-blue-400" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M12 16v-4"></path>
                                    <path d="M12 8h.01"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-blue-800 dark:text-blue-300">{{ session('info') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                {{-- Action buttons --}}
                <div class="flex flex-wrap gap-3 pt-4 mt-4 border-t border-slate-200 dark:border-slate-700">
                    <a href="{{ route('event.index') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-200 border-slate-300 dark:border-slate-600 hover:bg-slate-100 dark:hover:bg-slate-700 h-10 px-4 py-2">
                        Back to Events
                    </a>
                    
                    @if($event->event_link)
                    <a href="{{ $event->event_link }}" target="_blank" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-blue-600 dark:bg-blue-500 text-white hover:bg-blue-700 dark:hover:bg-blue-600 h-10 px-4 py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-external-link mr-2 h-4 w-4" aria-hidden="true">
                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                            <polyline points="15 3 21 3 21 9"></polyline>
                            <line x1="10" x2="21" y1="14" y2="3"></line>
                        </svg>
                        Join Event
                    </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Related events section (future enhancement) --}}
        {{-- <div class="mb-16">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-8">You may also be interested in</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Related events cards would go here -->
            </div>
        </div> --}}
    </div>
</x-app-layout>
