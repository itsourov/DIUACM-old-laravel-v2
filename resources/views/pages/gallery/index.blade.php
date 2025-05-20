<x-app-layout title="Gallery">
    <div class="py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header section --}}
            <div class="mb-12 text-center">
                <h1 class="text-4xl font-bold mb-4 text-slate-900 dark:text-white">
                    Our
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-blue-400 dark:to-cyan-300">
                        Gallery
                    </span>
                </h1>
                <div class="mx-auto w-20 h-1.5 bg-gradient-to-r from-blue-600 to-cyan-500 rounded-full mb-6"></div>
                <p class="text-lg text-slate-600 dark:text-slate-300 max-w-xl mx-auto">
                    Moments captured from our events, contests, and community activities
                </p>
            </div>

            {{-- Galleries Grid --}}
            <div class="grid sm:grid-cols-2 lg:grid-cols-3  gap-8">
                @foreach($galleries as $gallery)
                    <div class="bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-md border border-slate-200 dark:border-slate-700 hover:shadow-lg transition-all group">
                        <a href="{{ route('gallery.show', $gallery->slug) }}" class="block">
                            @if($gallery->media_count > 0)
                                {{-- Display the first image if available --}}
                                <div class="aspect-video w-full overflow-hidden bg-slate-100 dark:bg-slate-900/50 relative">
                                    {!! $gallery->getFirstMedia("gallery-images")?->img()->attributes(["class" => "w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"]) !!}
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-60"></div>
                                </div>
                                <div class="p-5">
                                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                        {{ $gallery->title }}
                                    </h3>
                                    <p class="text-slate-600 dark:text-slate-300 line-clamp-2">
                                        {{ $gallery->description }}
                                    </p>
                                    <div class="mt-4 flex items-center justify-between">
                                        <span class="text-sm text-slate-500 dark:text-slate-400 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                                                <path d="M21 8v13H3V8"></path>
                                                <path d="M1 3h22v5H1z"></path>
                                                <path d="M10 12h4"></path>
                                            </svg>
                                            {{ $gallery->media_count }} Photos
                                        </span>
                                        <span class="text-blue-600 dark:text-blue-400 text-sm font-medium flex items-center">
                                            View Gallery
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-1">
                                                <path d="m9 18 6-6-6-6"></path>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            @else
                                <div class="aspect-video w-full bg-gradient-to-br from-blue-50 to-slate-100 dark:from-slate-800 dark:to-slate-900 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400">
                                        <path d="M21 9v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7"></path>
                                        <rect x="16" y="3" width="4" height="4" rx="1"></rect>
                                        <circle cx="9" cy="10" r="2"></circle>
                                        <path d="m21 16-4-4c-1.2-1.2-3.2-1.2-4.4 0L6 18"></path>
                                    </svg>
                                </div>
                                <div class="p-5">
                                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                        {{ $gallery->title }}
                                    </h3>
                                    <p class="text-slate-600 dark:text-slate-300 line-clamp-2">
                                        {{ $gallery->description }}
                                    </p>
                                    <div class="mt-4 flex items-center justify-between">
                                        <span class="text-sm text-slate-500 dark:text-slate-400 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                                                <path d="M21 8v13H3V8"></path>
                                                <path d="M1 3h22v5H1z"></path>
                                                <path d="M10 12h4"></path>
                                            </svg>
                                            0 Photos
                                        </span>
                                        <span class="text-blue-600 dark:text-blue-400 text-sm font-medium flex items-center">
                                            View Gallery
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-1">
                                                <path d="m9 18 6-6-6-6"></path>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-12">
                {{ $galleries->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
