<x-app-layout title="Programmers">
    <div class="py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header section --}}
            <div class="mb-12 text-center">
                <h1 class="text-4xl font-bold mb-4 text-slate-900 dark:text-white">
                    Our
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-blue-400 dark:to-cyan-300">
                        Programmers
                    </span>
                </h1>
                <div class="mx-auto w-20 h-1.5 bg-gradient-to-r from-blue-600 to-cyan-500 rounded-full mb-6"></div>
                <p class="text-lg text-slate-600 dark:text-slate-300 max-w-xl mx-auto">
                    Meet our competitive programming community members and explore their profiles
                </p>
            </div>

            {{-- Search Bar --}}
            <div class="mb-10">
                <form action="{{ route('programmer.index') }}" method="GET" class="max-w-2xl mx-auto">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-500 dark:text-slate-400">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </svg>
                        </div>
                        <input 
                            type="search"
                            name="search"
                            value="{{ $search ?? '' }}"
                            placeholder="Search by name, username, or Codeforces handle..."
                            class="block w-full p-4 pl-12 text-slate-800 dark:text-slate-200 border border-slate-200 dark:border-slate-700 rounded-2xl bg-white dark:bg-slate-800 focus:ring-2 focus:outline-none focus:ring-blue-500 dark:focus:ring-blue-600"
                        >
                        <button type="submit" class="absolute right-2.5 bottom-2.5 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-medium rounded-lg text-sm px-4 py-2 transition-colors">
                            Search
                        </button>
                    </div>
                </form>
            </div>

            {{-- Programmers Grid --}}
            <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($programmers as $programmer)
                    <a href="{{ route('programmer.show', $programmer->username) }}" class="group">
                        <div class="bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-md border border-slate-200 dark:border-slate-700 transition-all hover:shadow-lg h-full flex flex-col">
                            <div class="bg-gradient-to-br from-blue-50 to-slate-100 dark:from-slate-800 dark:to-slate-900 p-6 pb-8 relative">
                                <div class="mx-auto w-24 h-24 rounded-full overflow-hidden border-4 border-white dark:border-slate-700 shadow-md bg-white dark:bg-slate-700 relative">
                                    @if($programmer->getMedia('profile-images')->isNotEmpty())
                                        <img src="{{ $programmer->getFirstMediaUrl('profile-images', 'preview') }}" 
                                            alt="{{ $programmer->name }}" 
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-blue-50 dark:bg-slate-800 text-2xl font-bold text-blue-600 dark:text-blue-400">
                                            {{ substr($programmer->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                
                                @if($programmer->max_cf_rating)
                                    <div class="absolute top-3 right-3">
                                        <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
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
                                            {{ $programmer->max_cf_rating }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="p-5 flex-grow flex flex-col">
                                <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors text-center">
                                    {{ $programmer->name }}
                                </h3>
                                
                                <div class="mt-2 space-y-3">
                                    @if($programmer->department)
                                        <div class="flex items-center text-sm text-slate-600 dark:text-slate-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 text-blue-500 dark:text-blue-400">
                                                <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                                                <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                                            </svg>
                                            {{ $programmer->department }}
                                        </div>
                                    @endif
                                    
                                    @if($programmer->codeforces_handle)
                                        <div class="flex items-center text-sm text-slate-600 dark:text-slate-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 text-blue-500 dark:text-blue-400">
                                                <rect width="8" height="14" x="8" y="6" rx="4"></rect>
                                                <path d="m19 7-3 2"></path>
                                                <path d="m5 7 3 2"></path>
                                                <path d="m19 19-3-2"></path>
                                                <path d="m5 19 3-2"></path>
                                                <path d="M20 12h1"></path>
                                                <path d="M3 12h1"></path>
                                            </svg>
                                            {{ $programmer->codeforces_handle }}
                                        </div>
                                    @endif
                                    
                                    @if($programmer->teams_count > 0)
                                        <div class="flex items-center text-sm text-slate-600 dark:text-slate-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 text-blue-500 dark:text-blue-400">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="9" cy="7" r="4"></circle>
                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            </svg>
                                            {{ $programmer->teams_count }} Teams
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-auto pt-4 flex justify-center">
                                    <span class="text-blue-600 dark:text-blue-400 text-sm font-medium inline-flex items-center group-hover:translate-x-1 transition-transform">
                                        View Profile
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-1">
                                            <path d="m9 18 6-6-6-6"></path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-16 text-center bg-white dark:bg-slate-800 rounded-2xl shadow-md border border-slate-200 dark:border-slate-700">
                        <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mx-auto mb-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600 dark:text-blue-400">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-2">No programmers found</h3>
                        <p class="text-slate-600 dark:text-slate-300 max-w-md mx-auto">We couldn't find any programmers matching your search criteria. Please try another search term.</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-12">
                {{ $programmers->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
