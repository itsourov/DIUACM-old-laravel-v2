@props([
    'name',
    'label',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'value' => '',
])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    
    @if($type === 'textarea')
        <textarea 
            id="{{ $name }}" 
            name="{{ $name }}" 
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:text-white']) }}
            placeholder="{{ $placeholder }}"
            rows="5"
        >{{ old($name, $value) }}</textarea>
    @else
        <input 
            type="{{ $type }}" 
            id="{{ $name }}" 
            name="{{ $name }}" 
            value="{{ old($name, $value) }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:text-white']) }}
            placeholder="{{ $placeholder }}"
        >
    @endif
    
    @error($name)
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div> 