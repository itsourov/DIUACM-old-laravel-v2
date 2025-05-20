<x-app-layout :title="$gallery->title">
    <div class="py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Back button --}}
            <div class="mb-6">
                <a href="{{ route('gallery.index') }}" class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                        <path d="m15 18-6-6 6-6"></path>
                    </svg>
                    Back to Galleries
                </a>
            </div>

            {{-- Gallery header --}}
            <div class="mb-10">
                <h1 class="text-3xl md:text-4xl font-bold mb-4 text-slate-900 dark:text-white">
                    {{ $gallery->title }}
                </h1>
                @if($gallery->description)
                <p class="text-lg text-slate-600 dark:text-slate-300 max-w-3xl">
                    {{ $gallery->description }}
                </p>
                @endif
            </div>

            {{-- Photo grid --}}
            <div id="gallery-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach($media as $image)
                <div class="group relative overflow-hidden rounded-xl shadow-md border border-slate-200 dark:border-slate-700 hover:shadow-lg transition-all">
                    <a href="{{ $image->getUrl() }}" class="gallery-item" data-title="{{ $gallery->title }}" data-caption="{{ $image->custom_properties['caption'] ?? '' }}">
                        {!! $image->img()->attributes(["class" => "w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300"]) !!}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-4">
                            <div class="w-full">
                                @if(isset($image->custom_properties['caption']) && $image->custom_properties['caption'])
                                <p class="text-white text-sm truncate">{{ $image->custom_properties['caption'] }}</p>
                                @endif
                                <div class="flex justify-end w-full">
                                    <span class="text-white bg-blue-600/80 rounded-full h-8 w-8 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 19a1 1 0 1 0 2 0 1 1 0 0 0-2 0z"></path>
                                            <path d="M15.71 4.29l-10 10a1 1 0 0 0 0 1.42l4 4a1 1 0 0 0 1.42 0l10-10a1 1 0 0 0 0-1.42l-4-4a1 1 0 0 0-1.42 0z"></path>
                                            <path d="M8.5 8.5 15.5 15.5"></path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            @if($media->isEmpty())
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-slate-200 dark:border-slate-700 p-12 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400 mx-auto mb-4">
                    <path d="M21 9v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7"></path>
                    <rect x="16" y="3" width="4" height="4" rx="1"></rect>
                    <circle cx="9" cy="10" r="2"></circle>
                    <path d="m21 16-4-4c-1.2-1.2-3.2-1.2-4.4 0L6 18"></path>
                </svg>
                <h3 class="text-xl font-medium text-slate-900 dark:text-white mb-2">No photos yet</h3>
                <p class="text-slate-600 dark:text-slate-300">This gallery doesn't have any photos at the moment.</p>
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
