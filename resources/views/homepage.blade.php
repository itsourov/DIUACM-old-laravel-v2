<x-web-layout>
    @include('components.hero-section')

    <section class="py-16 bg-gradient-to-b from-white to-slate-50 dark:from-slate-900 dark:to-slate-950">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">How DIU ACM Works</h2>
                <div
                    class="mx-auto w-20 h-1 bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-blue-400 dark:to-cyan-300 rounded-full mb-4">
                </div>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                @foreach($steps as $step)
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-md border border-slate-200 dark:border-slate-700 relative">
                    <div
                        class="absolute -top-4 -left-4 w-8 h-8 rounded-full bg-blue-600 dark:bg-blue-700 text-white flex items-center justify-center font-semibold text-sm">
                        {{ $step['number'] }}
                    </div>
                    <div class="text-center mb-4">
                        <div
                            class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round"
                                 class="lucide lucide-{{ $step['icon'] }} h-8 w-8 text-blue-600 dark:text-blue-400"
                                 aria-hidden="true">
                                @if($step['icon'] == 'book-open')
                                <path d="M12 7v14"></path>
                                <path
                                    d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z">
                                </path>
                                @elseif($step['icon'] == 'code-xml')
                                <path d="m18 16 4-4-4-4"></path>
                                <path d="m6 8-4 4 4 4"></path>
                                <path d="m14.5 4-5 16"></path>
                                @elseif($step['icon'] == 'users')
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                @endif
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-slate-900 dark:text-white">{{ $step['title'] }}</h3>
                        <p class="text-slate-600 dark:text-slate-300 mt-2">{{ $step['description'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">Learning Programs</h2>
                <div
                    class="mx-auto w-20 h-1 bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-blue-400 dark:to-cyan-300 rounded-full mb-4">
                </div>
                <p class="text-lg text-slate-600 dark:text-slate-300 max-w-xl mx-auto">Structured paths to
                    excellence in competitive programming</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-md hover:shadow-lg transition-shadow">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-r bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round"
                             class="lucide lucide-file-code2 lucide-file-code-2 h-6 w-6 text-blue-600 dark:text-blue-400"
                             aria-hidden="true">
                            <path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4"></path>
                            <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                            <path d="m5 12-3 3 3 3"></path>
                            <path d="m9 18 3-3-3-3"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-3">Green Sheet Program</h3>
                    <p class="text-slate-600 dark:text-slate-300 mb-4">Master programming basics with our curated
                        problem set covering fundamental concepts. Solve 60% to qualify for Blue Sheet.</p><a
                        data-slot="button"
                        class="justify-center whitespace-nowrap rounded-md text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*=&#x27;size-&#x27;])]:size-4 shrink-0 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive underline-offset-4 hover:underline h-9 has-[&gt;svg]:px-3 p-0 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 flex items-center gap-1"
                        href="/blogs/green-sheet">View details
                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                             height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4"
                             aria-hidden="true">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-md hover:shadow-lg transition-shadow">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-r bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round"
                             class="lucide lucide-award h-6 w-6 text-blue-600 dark:text-blue-400" aria-hidden="true">
                            <path
                                d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526">
                            </path>
                            <circle cx="12" cy="8" r="6"></circle>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-3">Blue Sheet Advanced</h3>
                    <p class="text-slate-600 dark:text-slate-300 mb-4">1000+ carefully selected problems for
                        advanced programmers. Regular updates based on top solver performance.</p><a
                        data-slot="button"
                        class="justify-center whitespace-nowrap rounded-md text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*=&#x27;size-&#x27;])]:size-4 shrink-0 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive underline-offset-4 hover:underline h-9 has-[&gt;svg]:px-3 p-0 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 flex items-center gap-1"
                        href="/blogs/blue-sheet">View details
                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                             height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4"
                             aria-hidden="true">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-md hover:shadow-lg transition-shadow">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-r bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round"
                             class="lucide lucide-target h-6 w-6 text-blue-600 dark:text-blue-400"
                             aria-hidden="true">
                            <circle cx="12" cy="12" r="10"></circle>
                            <circle cx="12" cy="12" r="6"></circle>
                            <circle cx="12" cy="12" r="2"></circle>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-3">ACM Advanced Camp</h3>
                    <p class="text-slate-600 dark:text-slate-300 mb-4">Intensive training program for TOPC top
                        performers with mentoring from seniors and alumni.</p><a data-slot="button"
                                                                                 class="justify-center whitespace-nowrap rounded-md text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*=&#x27;size-&#x27;])]:size-4 shrink-0 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive underline-offset-4 hover:underline h-9 has-[&gt;svg]:px-3 p-0 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 flex items-center gap-1"
                                                                                 href="/blogs/advanced-camp">View
                        details
                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                             height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4"
                             aria-hidden="true">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="py-16 bg-slate-50 dark:bg-slate-900/50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
                <div
                    class="relative overflow-hidden bg-white dark:bg-slate-800 shadow-md rounded-2xl p-6 border border-slate-200 dark:border-slate-700">
                    <div
                        class="absolute -bottom-6 -right-6 h-24 w-24 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 dark:from-blue-400 dark:to-blue-600 opacity-20">
                    </div>
                    <div class="flex flex-col items-center text-center z-10 relative">
                        <div
                            class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 dark:from-blue-400 dark:to-blue-600 flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="lucide lucide-code-xml h-6 w-6 text-white"
                                 aria-hidden="true">
                                <path d="m18 16 4-4-4-4"></path>
                                <path d="m6 8-4 4 4 4"></path>
                                <path d="m14.5 4-5 16"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-slate-900 dark:text-white">100+</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Weekly Problems</p>
                    </div>
                </div>
                <div
                    class="relative overflow-hidden bg-white dark:bg-slate-800 shadow-md rounded-2xl p-6 border border-slate-200 dark:border-slate-700">
                    <div
                        class="absolute -bottom-6 -right-6 h-24 w-24 rounded-full bg-gradient-to-br from-cyan-500 to-cyan-700 dark:from-cyan-400 dark:to-cyan-600 opacity-20">
                    </div>
                    <div class="flex flex-col items-center text-center z-10 relative">
                        <div
                            class="w-12 h-12 rounded-full bg-gradient-to-br from-cyan-500 to-cyan-700 dark:from-cyan-400 dark:to-cyan-600 flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="lucide lucide-trophy h-6 w-6 text-white"
                                 aria-hidden="true">
                                <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
                                <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path>
                                <path d="M4 22h16"></path>
                                <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"></path>
                                <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"></path>
                                <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-slate-900 dark:text-white">20+</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Annual Contests</p>
                    </div>
                </div>
                <div
                    class="relative overflow-hidden bg-white dark:bg-slate-800 shadow-md rounded-2xl p-6 border border-slate-200 dark:border-slate-700">
                    <div
                        class="absolute -bottom-6 -right-6 h-24 w-24 rounded-full bg-gradient-to-br from-violet-500 to-violet-700 dark:from-violet-400 dark:to-violet-600 opacity-20">
                    </div>
                    <div class="flex flex-col items-center text-center z-10 relative">
                        <div
                            class="w-12 h-12 rounded-full bg-gradient-to-br from-violet-500 to-violet-700 dark:from-violet-400 dark:to-violet-600 flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="lucide lucide-award h-6 w-6 text-white"
                                 aria-hidden="true">
                                <path
                                    d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526">
                                </path>
                                <circle cx="12" cy="8" r="6"></circle>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-slate-900 dark:text-white">50+</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">ICPC Participants</p>
                    </div>
                </div>
                <div
                    class="relative overflow-hidden bg-white dark:bg-slate-800 shadow-md rounded-2xl p-6 border border-slate-200 dark:border-slate-700">
                    <div
                        class="absolute -bottom-6 -right-6 h-24 w-24 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-700 dark:from-emerald-400 dark:to-emerald-600 opacity-20">
                    </div>
                    <div class="flex flex-col items-center text-center z-10 relative">
                        <div
                            class="w-12 h-12 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-700 dark:from-emerald-400 dark:to-emerald-600 flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="lucide lucide-users h-6 w-6 text-white"
                                 aria-hidden="true">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-slate-900 dark:text-white">200+</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Active Members</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">Our Competitions</h2>
                <div
                    class="mx-auto w-20 h-1 bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-blue-400 dark:to-cyan-300 rounded-full mb-4">
                </div>
                <p class="text-lg text-slate-600 dark:text-slate-300 max-w-xl mx-auto">Regular contests to test and
                    improve your skills</p>
            </div>
            <div class="grid lg:grid-cols-3 gap-8">
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-md hover:shadow-lg transition-shadow">
                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">Take-Off Programming
                        Contest</h3>
                    <p class="text-slate-600 dark:text-slate-300 mb-6">Semester-based contest series for beginners
                        with mock, preliminary, and main rounds.</p>
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Phases</h4>
                            <div class="flex flex-wrap gap-2"><span
                                    class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full text-sm">Mock
                                        Round</span><span
                                    class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full text-sm">Preliminary</span><span
                                    class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full text-sm">Main
                                        Contest</span></div>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Eligibility
                            </h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400">1st semester students enrolled in
                                Programming &amp; Problem Solving</p>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-md hover:shadow-lg transition-shadow">
                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">Unlock The Algorithm</h3>
                    <p class="text-slate-600 dark:text-slate-300 mb-6">Advanced algorithmic contest focusing on data
                        structures and algorithms.</p>
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Phases</h4>
                            <div class="flex flex-wrap gap-2"><span
                                    class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full text-sm">Mock
                                        Round</span><span
                                    class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full text-sm">Preliminary</span><span
                                    class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full text-sm">Final
                                        Round</span></div>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Eligibility
                            </h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Students enrolled in Algorithms
                                course</p>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-md hover:shadow-lg transition-shadow">
                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">DIU ACM Cup</h3>
                    <p class="text-slate-600 dark:text-slate-300 mb-6">Tournament-style competition to crown the
                        best programmer each semester.</p>
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Phases</h4>
                            <div class="flex flex-wrap gap-2"><span
                                    class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full text-sm">Group
                                        Stage</span><span
                                    class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full text-sm">Knockouts</span><span
                                    class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full text-sm">Finals</span>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Eligibility
                            </h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Top 32 regular programmers</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-16 bg-slate-50 dark:bg-slate-900/50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">What You&#x27;ll Get</h2>
                <div
                    class="mx-auto w-20 h-1 bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-blue-400 dark:to-cyan-300 rounded-full mb-4">
                </div>
                <p class="text-lg text-slate-600 dark:text-slate-300 max-w-xl mx-auto">Empowering your competitive
                    programming journey with comprehensive resources</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-md hover:shadow-lg transition-shadow">
                    <div
                        class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round"
                             class="lucide lucide-book-open h-6 w-6 text-blue-600 dark:text-blue-400"
                             aria-hidden="true">
                            <path d="M12 7v14"></path>
                            <path
                                d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-3">Structured Learning</h3>
                    <p class="text-slate-600 dark:text-slate-300">Follow our carefully designed learning tracks to
                        build skills progressively from basics to advanced topics.</p>
                </div>
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-md hover:shadow-lg transition-shadow">
                    <div
                        class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round"
                             class="lucide lucide-trophy h-6 w-6 text-blue-600 dark:text-blue-400"
                             aria-hidden="true">
                            <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
                            <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path>
                            <path d="M4 22h16"></path>
                            <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"></path>
                            <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"></path>
                            <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-3">Regular Contests</h3>
                    <p class="text-slate-600 dark:text-slate-300">Weekly contests help you apply what you&#x27;ve
                        learned and track your improvement over time.</p>
                </div>
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-md hover:shadow-lg transition-shadow">
                    <div
                        class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round"
                             class="lucide lucide-users h-6 w-6 text-blue-600 dark:text-blue-400" aria-hidden="true">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-3">Expert Mentorship</h3>
                    <p class="text-slate-600 dark:text-slate-300">Get guidance from experienced seniors and alumni
                        who have excelled in competitive programming.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">Rules &amp; Guidelines</h2>
                <div
                    class="mx-auto w-20 h-1 bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-blue-400 dark:to-cyan-300 rounded-full mb-4">
                </div>
                <p class="text-lg text-slate-600 dark:text-slate-300 max-w-xl mx-auto">Essential rules to maintain
                    the integrity of our competitive programming community</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-md">
                    <div class="flex items-center gap-3 mb-6">
                        <div
                            class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round"
                                 class="lucide lucide-trophy h-5 w-5 text-blue-600 dark:text-blue-400"
                                 aria-hidden="true">
                                <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
                                <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path>
                                <path d="M4 22h16"></path>
                                <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"></path>
                                <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"></path>
                                <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-slate-900 dark:text-white">Contest Rules</h3>
                    </div>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                 height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round"
                                 class="lucide lucide-circle-check w-5 h-5 mt-0.5 text-green-500 flex-shrink-0"
                                 aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                            <span class="text-slate-600 dark:text-slate-400">No external website usage during
                                    contests except the platform</span></li>
                        <li class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                 height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round"
                                 class="lucide lucide-circle-check w-5 h-5 mt-0.5 text-green-500 flex-shrink-0"
                                 aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                            <span class="text-slate-600 dark:text-slate-400">Hard copy templates are allowed
                                    with specified limits</span></li>
                        <li class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                 height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round"
                                 class="lucide lucide-circle-check w-5 h-5 mt-0.5 text-green-500 flex-shrink-0"
                                 aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                            <span class="text-slate-600 dark:text-slate-400">Code sharing must be enabled on
                                    Vjudge contests</span></li>
                        <li class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                 height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round"
                                 class="lucide lucide-circle-check w-5 h-5 mt-0.5 text-green-500 flex-shrink-0"
                                 aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                            <span class="text-slate-600 dark:text-slate-400">Any form of plagiarism results in
                                    permanent ban</span></li>
                    </ul>
                </div>
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-md">
                    <div class="flex items-center gap-3 mb-6">
                        <div
                            class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round"
                                 class="lucide lucide-laptop h-5 w-5 text-blue-600 dark:text-blue-400"
                                 aria-hidden="true">
                                <path
                                    d="M20 16V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v9m16 0H4m16 0 1.28 2.55a1 1 0 0 1-.9 1.45H3.62a1 1 0 0 1-.9-1.45L4 16">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-slate-900 dark:text-white">Lab Rules</h3>
                    </div>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                 height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round"
                                 class="lucide lucide-circle-check w-5 h-5 mt-0.5 text-green-500 flex-shrink-0"
                                 aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                            <span class="text-slate-600 dark:text-slate-400">Lab access requires regular ACM
                                    programmer status</span></li>
                        <li class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                 height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round"
                                 class="lucide lucide-circle-check w-5 h-5 mt-0.5 text-green-500 flex-shrink-0"
                                 aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                            <span class="text-slate-600 dark:text-slate-400">Maintain respectful behavior
                                    towards seniors and teachers</span></li>
                        <li class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                 height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round"
                                 class="lucide lucide-circle-check w-5 h-5 mt-0.5 text-green-500 flex-shrink-0"
                                 aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                            <span class="text-slate-600 dark:text-slate-400">Avoid disturbing others during
                                    practice sessions</span></li>
                        <li class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                 height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round"
                                 class="lucide lucide-circle-check w-5 h-5 mt-0.5 text-green-500 flex-shrink-0"
                                 aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                            <span class="text-slate-600 dark:text-slate-400">Keep the lab clean and
                                    organized</span></li>
                    </ul>
                </div>
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-md">
                    <div class="flex items-center gap-3 mb-6">
                        <div
                            class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round"
                                 class="lucide lucide-globe h-5 w-5 text-blue-600 dark:text-blue-400"
                                 aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                <path d="M2 12h20"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-slate-900 dark:text-white">Online Contest Rules</h3>
                    </div>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                 height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round"
                                 class="lucide lucide-circle-check w-5 h-5 mt-0.5 text-green-500 flex-shrink-0"
                                 aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                            <span class="text-slate-600 dark:text-slate-400">Forum usage prohibited during
                                    online contests</span></li>
                        <li class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                 height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round"
                                 class="lucide lucide-circle-check w-5 h-5 mt-0.5 text-green-500 flex-shrink-0"
                                 aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                            <span class="text-slate-600 dark:text-slate-400">Basic resource websites (GFG,
                                    CPAlgo) are allowed</span></li>
                        <li class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                 height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round"
                                 class="lucide lucide-circle-check w-5 h-5 mt-0.5 text-green-500 flex-shrink-0"
                                 aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                            <span class="text-slate-600 dark:text-slate-400">Maintain code submission
                                    history</span></li>
                        <li class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                 height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round"
                                 class="lucide lucide-circle-check w-5 h-5 mt-0.5 text-green-500 flex-shrink-0"
                                 aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                            <span class="text-slate-600 dark:text-slate-400">Report technical issues
                                    immediately</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="py-20 relative overflow-hidden">
        <div
            class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-cyan-500/5 dark:from-blue-500/10 dark:to-cyan-500/10">
        </div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div
                class="max-w-4xl mx-auto bg-white dark:bg-slate-800 rounded-2xl p-8 md:p-10 shadow-xl border border-slate-200 dark:border-slate-700">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">Join DIU ACM Community</h2>
                    <p class="text-lg text-slate-600 dark:text-slate-300">We don&#x27;t have a traditional
                        membership system. Your passion for competitive programming and regular participation makes
                        you a part of our community.</p>
                </div>
                <div class="flex flex-col md:flex-row gap-6 justify-center"><a href="https://t.me/+X94KLytY-Kk5NzU9"
                                                                               target="_blank" rel="noopener noreferrer"
                                                                               data-slot="button"
                                                                               class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*=&#x27;size-&#x27;])]:size-4 shrink-0 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive hover:bg-primary/90 h-10 has-[&gt;svg]:px-4 rounded-full px-8 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white shadow-md hover:shadow-xl transition-all dark:from-blue-500 dark:to-cyan-500 dark:hover:from-blue-600 dark:hover:to-cyan-600 font-medium">
                        <svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-message-square mr-2 h-4 w-4"
                            aria-hidden="true">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                        Join Telegram</a><a data-slot="button"
                                            class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*=&#x27;size-&#x27;])]:size-4 shrink-0 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive h-10 has-[&gt;svg]:px-4 rounded-full px-8 bg-white hover:bg-slate-50 text-blue-600 hover:text-blue-700 border border-slate-200 hover:border-blue-200 shadow-md hover:shadow-xl transition-all dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-blue-400 dark:hover:text-blue-300 dark:border-slate-700 dark:hover:border-slate-600 font-medium"
                                            href="/contact">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round"
                             class="lucide lucide-message-square mr-2 h-4 w-4" aria-hidden="true">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                        Contact Us</a></div>
            </div>
        </div>
    </section>
</x-web-layout>
