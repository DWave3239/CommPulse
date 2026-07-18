@props(['name'])

<input 
    type="text" 
    name="{{ $name }}"
    {{ $attributes->merge([
        'class' => 'form-input rounded-md border-gray-300 border p-2 w-full'
    ]) }}
>

<div>
    @error($name) <span class="error">{{ $message }}</span> @enderror
</div>