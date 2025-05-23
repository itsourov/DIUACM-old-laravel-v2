<x-app-layout title="Edit Profile">
    <div class="container mx-auto px-4 py-16">
        {{-- Header section --}}
        <div class="mb-12 text-center">
            <h1 class="text-4xl font-bold mb-4 text-slate-900 dark:text-white">
                Edit 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-blue-400 dark:to-cyan-300">
                    Profile
                </span>
            </h1>
            <div class="mx-auto w-20 h-1.5 bg-gradient-to-r from-blue-600 to-cyan-500 rounded-full mb-6"></div>
            <p class="text-lg text-slate-600 dark:text-slate-300 max-w-xl mx-auto">
                Update your personal information and profile settings
            </p>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="p-8">
                    
                    <form action="{{ route('my-account.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="col-span-2">
                                <div class="flex items-center space-x-6">
                                    <div class="relative w-32 h-32 rounded-full overflow-hidden border-4 border-white dark:border-slate-700 shadow-lg bg-white dark:bg-slate-700">
                                        @if($user->getMedia('avatar')->isNotEmpty())
                                            <img src="{{ $user->getFirstMediaUrl('avatar', 'preview') }}" 
                                                alt="{{ $user->name }}" 
                                                class="w-full h-full object-cover" id="avatar-preview">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-500 dark:text-slate-400 font-medium text-3xl" id="avatar-placeholder">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <img src="" alt="" class="w-full h-full object-cover hidden" id="avatar-preview">
                                        @endif
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                            Profile Photo
                                        </label>
                                        <input 
                                            type="file" 
                                            name="avatar" 
                                            id="avatar" 
                                            accept="image/*"
                                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:text-slate-300 dark:file:bg-slate-700 dark:file:text-blue-300"
                                        >
                                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                            JPG, PNG or GIF up to 5MB
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <x-form.input
                                name="name"
                                label="Full Name"
                                :value="old('name', $user->name)"
                                required
                            />
                            
                            <x-form.input
                                name="username"
                                label="Username"
                                :value="old('username', $user->username)"
                                required
                            />
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                    Email
                                </label>
                                <input 
                                    type="email" 
                                    value="{{ $user->email }}"
                                    class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:text-white bg-slate-100 dark:bg-slate-800" 
                                    disabled
                                >
                                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                    Email cannot be changed directly
                                </p>
                            </div>
                            
                            <x-form.input
                                name="phone"
                                label="Phone Number"
                                :value="old('phone', $user->phone)"
                            />
                            
                            <div>
                                <label for="gender" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                    Gender
                                </label>
                                <select 
                                    id="gender" 
                                    name="gender" 
                                    class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:text-white"
                                >
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender', $user->gender?->value) === 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $user->gender?->value) === 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender', $user->gender?->value) === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="border-t border-slate-200 dark:border-slate-700 pt-6 mb-6">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Academic Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <x-form.input
                                    name="department"
                                    label="Department"
                                    :value="old('department', $user->department)"
                                    placeholder="e.g., CSE, SWE"
                                />
                                
                                <x-form.input
                                    name="student_id"
                                    label="Student ID"
                                    :value="old('student_id', $user->student_id)"
                                    placeholder="e.g., XX-XXXXX-X"
                                />
                                
                                <x-form.input
                                    name="starting_semester"
                                    label="Starting Semester"
                                    :value="old('starting_semester', $user->starting_semester)"
                                    placeholder="e.g., Spring 2022"
                                />
                            </div>
                        </div>
                        
                        <div class="border-t border-slate-200 dark:border-slate-700 pt-6 mb-6">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Competitive Programming Profiles</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <x-form.input
                                    name="codeforces_handle"
                                    label="Codeforces Handle"
                                    :value="old('codeforces_handle', $user->codeforces_handle)"
                                />
                                
                                <x-form.input
                                    name="atcoder_handle"
                                    label="AtCoder Handle"
                                    :value="old('atcoder_handle', $user->atcoder_handle)"
                                />
                                
                                <x-form.input
                                    name="vjudge_handle"
                                    label="Vjudge Handle"
                                    :value="old('vjudge_handle', $user->vjudge_handle)"
                                />
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-4">
                            <x-button href="{{ route('programmer.show', $user->username) }}" variant="secondary">
                                Cancel
                            </x-button>
                            
                            <x-button type="submit">
                                Update Profile
                            </x-button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Preview uploaded image before submission
        document.getElementById('avatar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatar-preview').src = e.target.result;
                    document.getElementById('avatar-preview').classList.remove('hidden');
                    if (document.getElementById('avatar-placeholder')) {
                        document.getElementById('avatar-placeholder').classList.add('hidden');
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>
