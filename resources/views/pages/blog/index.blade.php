<x-app-layout title="Blog">
    <div class="py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header section --}}
            <div class="mb-12 text-center">
                <h1 class="text-4xl font-bold mb-4 text-slate-900 dark:text-white">
                    Our
                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-blue-400 dark:to-cyan-300">
                        Blog
                    </span>
                </h1>
                <div class="mx-auto w-20 h-1.5 bg-gradient-to-r from-blue-600 to-cyan-500 rounded-full mb-6"></div>
                <p class="text-lg text-slate-600 dark:text-slate-300 max-w-xl mx-auto">
                    Stay updated with the latest news, tutorials, and insights from our competitive programming
                    community
                </p>
            </div>

            {{-- Blog Posts Grid --}}
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                    <div
                        class="bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-md border border-slate-200 dark:border-slate-700 hover:shadow-lg transition-shadow">
                        @if($post->hasMedia('post-featured-images'))
                            {!! $post->getFirstMedia("post-featured-images")?->img()->attributes(["class" => "w-full aspect-video object-cover"]) !!}
                        @endif
                        <div class="p-6">
                            <span
                                class="text-sm text-slate-600 dark:text-slate-400 mb-4 block">{{ $post->published_at?->format('M d, Y') }}</span>
                            <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-3">
                                <a href="{{ route('blog.show', $post->slug) }}"
                                   class="hover:text-blue-600 dark:hover:text-blue-400">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p class="text-slate-600 dark:text-slate-300 mb-4 line-clamp-3">
                                {{ Str::limit(strip_tags($post->content), 150) }}
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-slate-600 dark:text-slate-400">By {{ $post->author }}</span>
                                <a href="{{ route('blog.show', $post->slug) }}"
                                   class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 text-sm font-medium flex items-center gap-1">
                                    Read more
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="lucide lucide-arrow-right">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
