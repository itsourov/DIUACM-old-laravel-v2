<x-app-layout title="Edit Profile">
    <!-- Cropper.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
    
  
    <div class="container mx-auto px-4 py-8 lg:py-16">
        {{-- Header section --}}
        <div class="mb-8 lg:mb-12 text-center">
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-4 text-slate-900 dark:text-white">
                Edit 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-blue-400 dark:to-cyan-300">
                    Profile
                </span>
            </h1>
            <div class="mx-auto w-16 lg:w-20 h-1 lg:h-1.5 bg-gradient-to-r from-blue-600 to-cyan-500 rounded-full mb-4 lg:mb-6"></div>
            <p class="text-base lg:text-lg text-slate-600 dark:text-slate-300 max-w-xl mx-auto px-4">
                Update your personal information and profile settings
            </p>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="bg-white dark:bg-slate-800 rounded-xl lg:rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="p-4 md:p-6 lg:p-8">
                    
                    <form action="{{ route('my-account.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Avatar Section -->
                        <div class="mb-6 lg:mb-8">
                            <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-6">
                                <div class="flex justify-center sm:justify-start">
                                    <div class="relative w-24 h-24 sm:w-28 sm:h-28 lg:w-32 lg:h-32 rounded-full overflow-hidden border-4 border-white dark:border-slate-700 shadow-lg bg-white dark:bg-slate-700">
                                        @if($user->getMedia('avatar')->isNotEmpty())
                                            <img src="{{ $user->getFirstMediaUrl('avatar', 'preview') }}" 
                                                alt="{{ $user->name }}" 
                                                class="w-full h-full object-cover" id="avatar-preview">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-500 dark:text-slate-400 font-medium text-xl lg:text-3xl" id="avatar-placeholder">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <img src="" alt="" class="w-full h-full object-cover hidden" id="avatar-preview">
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex-1 text-center sm:text-left">
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                        Profile Photo
                                    </label>
                                    <div class="flex flex-col sm:flex-row gap-2">
                                        <input 
                                            type="file" 
                                            name="avatar_input" 
                                            id="avatar-input" 
                                            accept="image/*"
                                            class="hidden"
                                        >
                                        <input type="hidden" name="avatar" id="avatar-cropped">
                                        <input type="hidden" name="remove_avatar" id="remove-avatar" value="0">
                                        
                                        <button 
                                            type="button" 
                                            id="select-avatar-btn"
                                            class="inline-flex items-center justify-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                                        >
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            Choose Photo
                                        </button>
                                        
                                        <button 
                                            type="button" 
                                            id="remove-avatar-btn"
                                            class="inline-flex items-center justify-center px-3 py-2 border border-slate-300 dark:border-slate-600 text-sm font-medium rounded-md text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700 hover:bg-slate-50 dark:hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                                        >
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Remove
                                        </button>
                                    </div>
                                    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                                        Upload any size image in JPEG, PNG, GIF, WebP, BMP, TIFF or SVG format. We'll automatically crop and optimize it to under 2MB.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Basic Information -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6 mb-6 lg:mb-8">
                            <div class="lg:col-span-1">
                                <x-form.input
                                    name="name"
                                    label="Full Name"
                                    :value="old('name', $user->name)"
                                    required
                                />
                            </div>
                            
                            <div class="lg:col-span-1">
                                <x-form.input
                                    name="username"
                                    label="Username"
                                    :value="old('username', $user->username)"
                                    required
                                />
                            </div>
                            
                            <div class="lg:col-span-1">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                    Email
                                </label>
                                <input 
                                    type="email" 
                                    value="{{ $user->email }}"
                                    class="w-full px-3 lg:px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:text-white bg-slate-100 dark:bg-slate-800 text-sm" 
                                    disabled
                                >
                                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                    Email cannot be changed directly
                                </p>
                            </div>
                            
                            <div class="lg:col-span-1">
                                <x-form.input
                                    name="phone"
                                    label="Phone Number"
                                    :value="old('phone', $user->phone)"
                                />
                            </div>
                            
                            <div class="lg:col-span-2 lg:col-span-1">
                                <label for="gender" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                    Gender
                                </label>
                                <select 
                                    id="gender" 
                                    name="gender" 
                                    class="w-full px-3 lg:px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:text-white text-sm"
                                >
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender', $user->gender?->value) === 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $user->gender?->value) === 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender', $user->gender?->value) === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Academic Information -->
                        <div class="border-t border-slate-200 dark:border-slate-700 pt-6 mb-6 lg:mb-8">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Academic Information</h3>
                            
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                                <div class="lg:col-span-1">
                                    <x-form.input
                                        name="department"
                                        label="Department"
                                        :value="old('department', $user->department)"
                                        placeholder="e.g., CSE, SWE"
                                    />
                                </div>
                                
                                <div class="lg:col-span-1">
                                    <x-form.input
                                        name="student_id"
                                        label="Student ID"
                                        :value="old('student_id', $user->student_id)"
                                        placeholder="e.g., XX-XXXXX-X"
                                    />
                                </div>
                                
                                <div class="lg:col-span-2 lg:col-span-1">
                                    <x-form.input
                                        name="starting_semester"
                                        label="Starting Semester"
                                        :value="old('starting_semester', $user->starting_semester)"
                                        placeholder="e.g., Spring 2022"
                                    />
                                </div>
                            </div>
                        </div>
                        
                        <!-- Competitive Programming Profiles -->
                        <div class="border-t border-slate-200 dark:border-slate-700 pt-6 mb-6 lg:mb-8">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Competitive Programming Profiles</h3>
                            
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                                <div class="lg:col-span-1">
                                    <x-form.input
                                        name="codeforces_handle"
                                        label="Codeforces Handle"
                                        :value="old('codeforces_handle', $user->codeforces_handle)"
                                    />
                                </div>
                                
                                <div class="lg:col-span-1">
                                    <x-form.input
                                        name="atcoder_handle"
                                        label="AtCoder Handle"
                                        :value="old('atcoder_handle', $user->atcoder_handle)"
                                    />
                                </div>
                                
                                <div class="lg:col-span-2 lg:col-span-1">
                                    <x-form.input
                                        name="vjudge_handle"
                                        label="Vjudge Handle"
                                        :value="old('vjudge_handle', $user->vjudge_handle)"
                                    />
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                            <x-button href="{{ route('programmer.show', $user->username) }}" variant="secondary" class="w-full sm:w-auto order-2 sm:order-1">
                                Cancel
                            </x-button>
                            
                            <x-button type="submit" class="w-full sm:w-auto order-1 sm:order-2">
                                <span class="flex items-center justify-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white hidden" id="loading-spinner" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span id="submit-text">Update Profile</span>
                                </span>
                            </x-button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Image Cropper Modal -->
    <div id="cropperModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-hidden">
                <div class="p-4 border-b border-slate-200 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Crop Your Photo</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Adjust the crop area and we'll automatically optimize the image size</p>
                </div>
                
                <div class="p-4">
                    <div class="max-h-96 overflow-hidden">
                        <img id="cropperImage" src="" style="max-width: 100%;">
                    </div>
                    
                    <!-- Processing indicator -->
                    <div id="processingIndicator" class="hidden mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-sm text-blue-800 dark:text-blue-200" id="processingText">Processing image...</span>
                        </div>
                    </div>
                </div>
                
                <div class="p-4 border-t border-slate-200 dark:border-slate-700">
                    <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                        <button 
                            id="cancelCrop" 
                            type="button" 
                            class="w-full sm:w-auto px-4 py-2 border border-slate-300 dark:border-slate-600 text-sm font-medium rounded-md text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700 hover:bg-slate-50 dark:hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                        >
                            Cancel
                        </button>
                        <button 
                            id="applyCrop" 
                            type="button" 
                            class="w-full sm:w-auto px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                        >
                            Apply & Optimize
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Cropper.js JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    
    <script>
        let cropper = null;
        let originalFile = null;
        
        // Elements
        const avatarInput = document.getElementById('avatar-input');
        const selectAvatarBtn = document.getElementById('select-avatar-btn');
        const removeAvatarBtn = document.getElementById('remove-avatar-btn');
        const avatarPreview = document.getElementById('avatar-preview');
        const avatarPlaceholder = document.getElementById('avatar-placeholder');
        const cropperModal = document.getElementById('cropperModal');
        const cropperImage = document.getElementById('cropperImage');
        const cancelCrop = document.getElementById('cancelCrop');
        const applyCrop = document.getElementById('applyCrop');
        const avatarCropped = document.getElementById('avatar-cropped');
        const profileForm = document.getElementById('profileForm');
        const submitBtn = profileForm.querySelector('button[type="submit"]');
        const loadingSpinner = document.getElementById('loading-spinner');
        const submitText = document.getElementById('submit-text');
        const processingIndicator = document.getElementById('processingIndicator');
        const processingText = document.getElementById('processingText');
        
        // Helper function to show Filament notifications
        function showNotification(title, message, type = 'error') {
            // Create a Filament notification
            const notification = new FilamentNotification()
                .title(title);
                
            // Add body if provided
            if (message) {
                notification.body(message);
            }
            
            // Set notification type
            if (type === 'success') {
                notification.success();
            } else if (type === 'error') {
                notification.danger();
            } else if (type === 'info') {
                notification.info();
            } else if (type === 'warning') {
                notification.warning();
            }
            
            // Send the notification
            notification.send();
        }
        
        // Open file dialog
        selectAvatarBtn.addEventListener('click', () => {
            avatarInput.click();
        });
        
        // Handle file selection
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file type - be more permissive
                const allowedTypes = [
                    'image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp',
                    'image/bmp', 'image/tiff', 'image/svg+xml', 'image/avif', 'image/heic'
                ];
                
                if (!file.type.startsWith('image/')) {
                    showNotification('Invalid File', 'Please select an image file.', 'error');
                    return;
                }
                
                // Very generous size limit for initial upload (100MB)
                if (file.size > 100 * 1024 * 1024) {
                    showNotification('File Too Large', 'Please select an image smaller than 100MB for processing.', 'error');
                    return;
                }
                
                originalFile = file;
                const reader = new FileReader();
                reader.onload = function(e) {
                    cropperImage.src = e.target.result;
                    showCropperModal();
                };
                reader.onerror = function() {
                    showNotification('File Error', 'Could not read the image file. Please try a different image.', 'error');
                };
                reader.readAsDataURL(file);
            }
        });
        
        // Show cropper modal
        function showCropperModal() {
            cropperModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            if (cropper) {
                cropper.destroy();
            }
            
            cropper = new Cropper(cropperImage, {
                aspectRatio: 1,
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: 0.8,
                restore: false,
                guides: true,
                center: true,
                highlight: false,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
                responsive: true,
                checkOrientation: false,
                modal: true,
                background: true
            });
        }
        
        // Hide cropper modal
        function hideCropperModal() {
            cropperModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            processingIndicator.classList.add('hidden');
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        }
        
        // Cancel crop
        cancelCrop.addEventListener('click', hideCropperModal);
        
        // Apply crop
        applyCrop.addEventListener('click', function() {
            if (!cropper) return;
            
            // Show processing indicator
            processingIndicator.classList.remove('hidden');
            processingText.textContent = 'Processing and optimizing image...';
            applyCrop.disabled = true;
            
            // Get original image dimensions
            const imageData = cropper.getImageData();
            const cropBoxData = cropper.getCropBoxData();
            
            // Calculate optimal output size for quality vs file size
            let outputWidth = 800;  // Default output width
            let outputHeight = 800; // Default output height
            
            // Adjust based on original image size for better quality
            if (imageData.naturalWidth > 2000 || imageData.naturalHeight > 2000) {
                outputWidth = 1200;
                outputHeight = 1200;
            } else if (imageData.naturalWidth < 400 || imageData.naturalHeight < 400) {
                outputWidth = 400;
                outputHeight = 400;
            }
            
            cropper.getCroppedCanvas({
                width: outputWidth,
                height: outputHeight,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high'
            }).toBlob(function(blob) {
                processingText.textContent = 'Optimizing file size...';
                
                // Target size: 2MB
                const targetSize = 2 * 1024 * 1024;
                
                compressImage(blob, targetSize, function(compressedBlob) {
                    const finalSize = (compressedBlob.size / 1024 / 1024).toFixed(2);
                    processingText.textContent = `Final size: ${finalSize}MB - Converting...`;
                    
                    // Convert to base64 for form submission
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        avatarCropped.value = e.target.result;
                        
                        // Update preview
                        avatarPreview.src = e.target.result;
                        avatarPreview.classList.remove('hidden');
                        if (avatarPlaceholder) {
                            avatarPlaceholder.classList.add('hidden');
                        }
                        
                        showNotification('Image Processed', `Image processed successfully! Final size: ${finalSize}MB`, 'success');
                        
                        // Re-enable button and hide modal
                        applyCrop.disabled = false;
                        hideCropperModal();
                    };
                    reader.readAsDataURL(compressedBlob);
                }, function(progress) {
                    processingText.textContent = `Optimizing... (${Math.round(progress * 100)}%)`;
                });
            }, 'image/jpeg', 0.92);
        });
        
        // Enhanced compression function with progress callback
        function compressImage(blob, targetSize, callback, progressCallback = null) {
            if (blob.size <= targetSize) {
                callback(blob);
                return;
            }
            
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            const img = new Image();
            
            img.onload = function() {
                let { width, height } = img;
                
                // Progressive size reduction if needed
                let scaleFactor = 1;
                if (blob.size > targetSize * 3) {
                    scaleFactor = Math.sqrt(targetSize / blob.size);
                    width *= scaleFactor;
                    height *= scaleFactor;
                }
                
                canvas.width = width;
                canvas.height = height;
                
                // High quality drawing
                ctx.imageSmoothingEnabled = true;
                ctx.imageSmoothingQuality = 'high';
                ctx.drawImage(img, 0, 0, width, height);
                
                // Progressive quality reduction
                let quality = 0.9;
                let attempts = 0;
                const maxAttempts = 10;
                
                const tryCompress = () => {
                    attempts++;
                    if (progressCallback) {
                        progressCallback(attempts / maxAttempts);
                    }
                    
                    canvas.toBlob((compressedBlob) => {
                        if (compressedBlob.size <= targetSize || quality <= 0.1 || attempts >= maxAttempts) {
                            // If still too large, try smaller dimensions
                            if (compressedBlob.size > targetSize && attempts >= maxAttempts && scaleFactor === 1) {
                                canvas.width = width * 0.8;
                                canvas.height = height * 0.8;
                                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                                quality = 0.8;
                                attempts = 0;
                                tryCompress();
                            } else {
                                callback(compressedBlob);
                            }
                        } else {
                            quality -= 0.08;
                            tryCompress();
                        }
                    }, 'image/jpeg', quality);
                };
                
                tryCompress();
            };
            
            img.onerror = function() {
                showNotification('Processing Error', 'Could not process the image. Please try a different image.', 'error');
                applyCrop.disabled = false;
                processingIndicator.classList.add('hidden');
            };
            
            img.src = URL.createObjectURL(blob);
        }
        
        // Remove avatar
        removeAvatarBtn.addEventListener('click', function() {
            avatarCropped.value = '';
            avatarPreview.src = '';
            avatarPreview.classList.add('hidden');
            if (avatarPlaceholder) {
                avatarPlaceholder.classList.remove('hidden');
            }
            avatarInput.value = '';
            // Set the remove_avatar flag to 1
            document.getElementById('remove-avatar').value = '1';
            showNotification('Avatar Removed', 'Profile photo has been removed.', 'success');
        });
        
        // Handle form submission
        profileForm.addEventListener('submit', function(e) {
            // Always prevent default form submission and handle via AJAX for consistency
            e.preventDefault();
            
            // Show loading state
            loadingSpinner.classList.remove('hidden');
            submitText.textContent = 'Updating...';
            submitBtn.disabled = true;
            
            // Always handle via AJAX for consistency, whether we're updating avatar or not
                try {
                    // Create form data
                    const formData = new FormData(profileForm);
                    formData.delete('avatar_input');
                    
                    // If we have an image to upload
                    if (avatarCropped.value && document.getElementById('remove-avatar').value !== '1') {
                        const dataURL = avatarCropped.value;
                        const byteString = atob(dataURL.split(',')[1]);
                        const mimeString = dataURL.split(',')[0].split(':')[1].split(';')[0];
                        const ab = new ArrayBuffer(byteString.length);
                        const ia = new Uint8Array(ab);
                        for (let i = 0; i < byteString.length; i++) {
                            ia[i] = byteString.charCodeAt(i);
                        }
                        const blob = new Blob([ab], { type: mimeString });
                        formData.set('avatar', blob, 'avatar.jpg');
                    }
                    
                    // Always ensure the remove_avatar flag is included with the correct value
                    const removeAvatarValue = document.getElementById('remove-avatar').value;
                    console.log('Remove avatar value:', removeAvatarValue);
                    formData.set('remove_avatar', removeAvatarValue);
                    
                    // Debug what's being submitted
                    console.log('Submitting form with remove_avatar:', formData.get('remove_avatar'));
                    
                    // Submit via fetch
                    fetch(profileForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        }
                    }).then(response => {
                        if (response.ok) {
                            showNotification('Profile Updated', 'Your profile has been updated successfully!', 'success');
                            setTimeout(() => window.location.reload(), 1000);
                        } else {
                            return response.text().then(text => {
                                console.error('Server response:', text);
                                throw new Error('Update failed');
                            });
                        }
                    }).catch(error => {
                        console.error('Error:', error);
                        showNotification('Update Failed', 'Failed to update your profile. Please try again.', 'error');
                        // Reset form state
                        loadingSpinner.classList.add('hidden');
                        submitText.textContent = 'Update Profile';
                        submitBtn.disabled = false;
                    });
                } catch (error) {
                    console.error('Form submission error:', error);
                    showNotification('Processing Error', 'Error processing the form. Please try again.', 'error');
                    loadingSpinner.classList.add('hidden');
                    submitText.textContent = 'Update Profile';
                    submitBtn.disabled = false;
                }
        });
        
        // Close modal on outside click
        cropperModal.addEventListener('click', function(e) {
            if (e.target === cropperModal) {
                hideCropperModal();
            }
        });
        
        // Handle escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !cropperModal.classList.contains('hidden')) {
                hideCropperModal();
            }
        });
    </script>
    
   
</x-app-layout>
