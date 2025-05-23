<x-app-layout>
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-md mx-auto bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-xl border border-slate-200 dark:border-slate-700">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Create an Account</h1>
                <p class="text-sm text-slate-600 dark:text-slate-300">
                    Already have an account?
                    <a class="font-medium text-blue-600 hover:text-blue-700 underline-offset-2 hover:underline dark:text-blue-400 dark:hover:text-blue-300"
                       href="{{ route('login') }}">
                        Sign in here
                    </a>
                </p>
                <div class="mx-auto w-16 h-1 bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-blue-400 dark:to-cyan-300 rounded-full my-4"></div>
            </div>

            <div class="bg-blue-50 dark:bg-slate-700/50 border border-blue-100 dark:border-slate-600 rounded-lg p-4 mb-6">
                <h3 class="font-medium text-blue-800 dark:text-blue-300 mb-2">Important Registration Instructions:</h3>
                <ul class="text-sm text-slate-700 dark:text-slate-300 space-y-1 list-disc list-inside">
                    <li>Use your DIU email address (@diu.edu.bd or @s.diu.edu.bd)</li>
                    <li>Set a password for your account after creating a new account</li>
                    <li>Keep your credentials safe - you'll need them for contest attendance</li>
                </ul>
                <p class="mt-2 text-xs text-slate-600 dark:text-slate-400 italic">Note: Personal Gmail accounts are not accepted. You must use your official DIU email address for registration.</p>
            </div>
            
            <div class="mb-6">
                <a href="{{ route('auth.google.redirect') }}" class="w-full py-3 px-4 flex justify-center items-center gap-3 text-sm font-medium rounded-lg border border-slate-200 bg-white text-slate-800 shadow-sm hover:bg-slate-50 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:hover:bg-slate-600 transition-colors">
                    <svg class="w-5 h-5" viewBox="0 0 46 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M46 24.0287C46 22.09 45.8533 20.68 45.5013 19.2112H23.4694V27.9356H36.4069C36.1429 30.1094 34.7347 33.37 31.5957 35.5731L31.5663 35.8669L38.5191 41.2719L38.9885 41.3306C43.4477 37.2181 46 31.1669 46 24.0287Z" fill="#4285F4"/>
                        <path d="M23.4694 47C29.8061 47 35.1161 44.9144 39.0179 41.3012L31.625 35.5437C29.6301 36.9244 26.9898 37.8937 23.4987 37.8937C17.2793 37.8937 12.0281 33.7812 10.1505 28.1412L9.88649 28.1706L2.61097 33.7812L2.52296 34.0456C6.36608 41.7125 14.287 47 23.4694 47Z" fill="#34A853"/>
                        <path d="M10.1212 28.1413C9.62245 26.6725 9.32908 25.1156 9.32908 23.5C9.32908 21.8844 9.62245 20.3275 10.0918 18.8588V18.5356L2.75765 12.8369L2.52296 12.9544C0.909439 16.1269 0 19.7106 0 23.5C0 27.2894 0.909439 30.8731 2.49362 34.0456L10.1212 28.1413Z" fill="#FBBC05"/>
                        <path d="M23.4694 9.07688C27.8699 9.07688 30.8622 10.9863 32.5344 12.5725L39.1645 6.11C35.0867 2.32063 29.8061 0 23.4694 0C14.287 0 6.36607 5.2875 2.49362 12.9544L10.0918 18.8588C11.9987 13.1894 17.25 9.07688 23.4694 9.07688Z" fill="#EB4335"/>
                    </svg>
                    Register using Google
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
