<x-app-layout title="Contact Us">
    <div class="container mx-auto px-4 py-16">
        {{-- Header section --}}
        <div class="mb-12 text-center">
            <h1 class="text-4xl font-bold mb-4 text-slate-900 dark:text-white">
                Contact
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-blue-400 dark:to-cyan-300">
                    Us
                </span>
            </h1>
            <div class="mx-auto w-20 h-1.5 bg-gradient-to-r from-blue-600 to-cyan-500 rounded-full mb-6"></div>
            <p class="text-lg text-slate-600 dark:text-slate-300 max-w-xl mx-auto">
                Have questions or feedback? We'd love to hear from you and help
                with anything you need.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Contact Form --}}
            <div class="lg:col-span-2 overflow-hidden bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-md rounded-lg">
                <div class="p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 dark:from-blue-400 dark:to-blue-600 flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-white">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">
                            Send us a message
                        </h2>
                    </div>
                    
                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <x-form.input
                                name="name"
                                label="Name"
                                placeholder="Your name"
                                required
                            />
                            
                            <x-form.input
                                name="email"
                                type="email"
                                label="Email"
                                placeholder="your.email@example.com"
                                required
                            />
                        </div>
                        
                        <x-form.input
                            name="subject"
                            label="Subject"
                            placeholder="What is this about?"
                            required
                        />
                        
                        <x-form.input
                            name="message"
                            type="textarea"
                            label="Message"
                            placeholder="Your message here..."
                            required
                        />
                        
                        <div>
                            <x-button type="submit" class="w-full">
                                Send Message
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Contact Information --}}
            <div class="space-y-6">
                <div class="overflow-hidden bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-md rounded-lg">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4 flex items-center">
                            <span class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 dark:from-blue-400 dark:to-blue-600 flex items-center justify-center mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-white">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </span>
                            Contact Information
                        </h2>
                        <div class="space-y-4 mt-6">
                            <div class="flex items-start space-x-3 p-4 rounded-lg bg-slate-50 dark:bg-slate-700/40 border border-slate-100 dark:border-slate-700">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 mt-0.5 text-blue-500">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                                <div>
                                    <p class="font-medium text-slate-900 dark:text-slate-200">
                                        Contact Email
                                    </p>
                                    <a
                                        href="mailto:info@diuacm.com"
                                        class="text-slate-600 dark:text-slate-300 hover:text-blue-500 dark:hover:text-blue-400 transition-colors"
                                    >
                                        info@diuacm.com
                                    </a>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3 p-4 rounded-lg bg-slate-50 dark:bg-slate-700/40 border border-slate-100 dark:border-slate-700">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 mt-0.5 text-blue-500">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                                <div>
                                    <p class="font-medium text-slate-900 dark:text-slate-200">
                                        Telegram Channel
                                    </p>
                                    <a
                                        href="https://t.me/+AH0gg2-V5xIxYjA9"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="text-slate-600 dark:text-slate-300 hover:text-blue-500 dark:hover:text-blue-400 transition-colors"
                                    >
                                        https://t.me/+AH0gg2-V5xIxYjA9
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-md rounded-lg">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4 flex items-center">
                            <span class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 dark:from-blue-400 dark:to-blue-600 flex items-center justify-center mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-white">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                            </span>
                            Response Time
                        </h2>
                        <p class="text-slate-600 dark:text-slate-300 mt-3">
                            We typically respond to inquiries within 24-48 hours during
                            weekdays.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 