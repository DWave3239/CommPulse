@props(['title', 'name', 'description'])

<flux:field>
    <flux:label>{{ $title ?? $name }}</flux:label>
    @if($description ?? null)
        <flux:description>{{ $description }}</flux:description>
    @endif
    <flux:input {{ $attributes }}/>
    <flux:error name="{{ $name }}" />
</flux:field>