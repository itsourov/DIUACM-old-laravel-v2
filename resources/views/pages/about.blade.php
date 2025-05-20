<x-app-layout title="About">
    <div class="container mx-auto px-4 py-16">
        {{-- Header section --}}
        <div class="mb-12 text-center">
            <h1 class="text-4xl font-bold mb-4 text-slate-900 dark:text-white">
                About
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-blue-400 dark:to-cyan-300">
                    DIU ACM
                </span>
            </h1>
            <div class="mx-auto w-20 h-1.5 bg-gradient-to-r from-blue-600 to-cyan-500 rounded-full mb-6"></div>
            <p class="text-lg text-slate-600 dark:text-slate-300 max-w-xl mx-auto">
                A dedicated wing under DIU CPC, fostering a thriving competitive
                programming culture
            </p>
        </div>

        {{-- Introduction section --}}
        <div class="mb-10 overflow-hidden bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-md rounded-lg">
            <div class="p-8">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 dark:from-blue-400 dark:to-blue-600 flex items-center justify-center mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-white">
                            <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
                            <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path>
                            <path d="M4 22h16"></path>
                            <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"></path>
                            <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"></path>
                            <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white">
                        Who We Are
                    </h2>
                </div>

                <div class="space-y-4 text-slate-600 dark:text-slate-300">
                    <p>
                        DIU ACM is a dedicated wing under the DIU CPC, focused on
                        fostering a thriving competitive programming culture within the
                        university. Our community comprises passionate problem solvers and
                        coding enthusiasts who regularly participate in programming
                        contests, take classes from expert trainers, and mentor selected
                        juniors in their journey to mastering competitive programming.
                    </p>
                    <p>
                        At DIU ACM, we believe in learning through practice and teamwork.
                        We're committed to building a community where programming skills
                        are nurtured, challenged, and celebrated.
                    </p>
                </div>
            </div>
        </div>

        {{-- Activities and Mission section --}}
        <div class="grid md:grid-cols-2 gap-8 mb-10">
            <div class="overflow-hidden bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-md rounded-lg">
                <div class="p-8 h-full">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 dark:from-blue-400 dark:to-blue-600 flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-white">
                                <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">
                            Our Activities
                        </h2>
                    </div>

                    <div class="space-y-4 text-slate-600 dark:text-slate-300">
                        <p>
                            Our members actively engage in various activities, including:
                        </p>
                        <ul class="list-disc pl-5 space-y-2">
                            <li>
                                <span class="font-medium">Regular Contests:</span> We
                                organize and participate in coding contests to sharpen our
                                skills and compete at national and international levels.
                            </li>
                            <li>
                                <span class="font-medium">Trainer's Classes:</span> Senior
                                competitive programmers and invited trainers conduct classes,
                                covering advanced topics to help members improve their
                                algorithmic and problem-solving abilities.
                            </li>
                            <li>
                                <span class="font-medium">Junior Mentorship:</span> Our
                                experienced members take the responsibility of guiding and
                                teaching promising juniors, ensuring the continuity of
                                excellence in the community.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-md rounded-lg">
                <div class="p-8 h-full">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 dark:from-blue-400 dark:to-blue-600 flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-white">
                                <path d="M14 19a6 6 0 0 0-12 0"></path>
                                <circle cx="8" cy="9" r="4"></circle>
                                <path d="M22 19a6 6 0 0 0-6-6 4 4 0 1 0 0-8"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">
                            Our Mission
                        </h2>
                    </div>

                    <div class="space-y-4 text-slate-600 dark:text-slate-300">
                        <p>
                            This website serves as a central platform to manage and
                            streamline our activities, including tracking attendance for
                            classes, contests, and events. As we grow, we plan to introduce
                            new features such as score calculation, individual progress
                            tracking, and more, to better support the development of our
                            members.
                        </p>
                        <p>
                            Together, we strive to make DIU ACM a hub of excellence in
                            competitive programming at Daffodil International University.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Join Us section --}}
        <div class="overflow-hidden bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-md rounded-lg">
            <div class="p-8">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4 text-center">
                    Join Us
                </h2>

                <div class="space-y-4 text-slate-600 dark:text-slate-300 text-center max-w-2xl mx-auto">
                    <p>
                        Whether you're an experienced competitive programmer or just
                        starting your journey, DIU ACM welcomes you. Join our community to
                        learn, grow, and excel in the world of competitive programming.
                    </p>
                    <p class="font-medium text-blue-600 dark:text-blue-400">
                        The DIU ACM Team
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


