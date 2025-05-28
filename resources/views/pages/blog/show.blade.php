<x-app-layout :title="$blog->title">
    <div class="py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-5xl mx-auto">
                {{-- Back button --}}
                <div class="mb-6">
                    <a href="{{ route('blog.index') }}"
                       class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="mr-2">
                            <path d="m15 18-6-6 6-6"></path>
                        </svg>
                        Back to Blog
                    </a>
                </div>

                {{-- Blog header --}}
                <div class="mb-8">
                    <h1 class="text-3xl md:text-4xl font-bold mb-4 text-slate-900 dark:text-white">
                        {{ $blog->title }}
                    </h1>
                    <div class="flex flex-wrap items-center text-slate-600 dark:text-slate-400 gap-x-6 gap-y-2">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="mr-2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <span>{{ $blog->published_at?->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="mr-2">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <span>By {{ $blog->author }}</span>
                        </div>
                    </div>
                </div>


                {{-- Content --}}
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl p-6 md:p-8 shadow-md border border-slate-200 dark:border-slate-700 mb-8">
                    <div
                        class="prose prose-slate dark:prose-invert prose-headings:font-semibold prose-a:text-blue-600 dark:prose-a:text-blue-400 prose-img:rounded-xl max-w-none">
                        {!! $blog->content !!}
                    </div>
                </div>

                {{-- Share links --}}
                <div
                    class="bg-slate-100 dark:bg-slate-800/50 rounded-xl p-6 shadow-inner border border-slate-200 dark:border-slate-700">
                    <h3 class="text-lg font-semibold mb-4 text-slate-900 dark:text-white">Share this article</h3>
                    <div class="flex flex-wrap gap-3">
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $blog->slug)) }}&text={{ urlencode($blog->title) }}"
                           target="_blank"
                           class="bg-[#1DA1F2] hover:bg-[#1a94e4] text-white flex items-center px-4 py-2 rounded-md transition duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="mr-2">
                                <path
                                    d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path>
                            </svg>
                            Twitter
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $blog->slug)) }}"
                           target="_blank"
                           class="bg-[#3b5998] hover:bg-[#344e86] text-white flex items-center px-4 py-2 rounded-md transition duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="mr-2">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                            </svg>
                            Facebook
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('blog.show', $blog->slug)) }}&title={{ urlencode($blog->title) }}"
                           target="_blank"
                           class="bg-[#0077b5] hover:bg-[#006ba6] text-white flex items-center px-4 py-2 rounded-md transition duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="mr-2">
                                <path
                                    d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                                <rect x="2" y="9" width="4" height="12"></rect>
                                <circle cx="4" cy="4" r="2"></circle>
                            </svg>
                            LinkedIn
                        </a>
                    </div>
                </div>

                {{-- More blog posts --}}
                @if(isset($relatedPosts) && $relatedPosts->count() > 0)
                    <div class="mt-16">
                        <h2 class="text-2xl font-bold mb-6 text-slate-900 dark:text-white">You might also like</h2>
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($relatedPosts as $post)
                                <div
                                    class="bg-white dark:bg-slate-800 rounded-xl overflow-hidden shadow-md border border-slate-200 dark:border-slate-700 hover:shadow-lg transition-shadow">
                                    @if($post->hasMedia('post-featured-images'))
                                        {!! $post->getFirstMedia("post-featured-images")?->img()->attributes(["class" => "w-full aspect-video object-cover"]) !!}
                                    @endif
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">
                                            <a href="{{ route('blog.show', $post->slug) }}"
                                               class="hover:text-blue-600 dark:hover:text-blue-400">
                                                {{ $post->title }}
                                            </a>
                                        </h3>
                                        <div class="flex items-center justify-between">
                                            <span
                                                class="text-sm text-slate-600 dark:text-slate-400">{{ $post->published_at?->format('M d, Y') }}</span>
                                            <a href="{{ route('blog.show', $post->slug) }}"
                                               class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 text-sm font-medium">Read
                                                more</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
