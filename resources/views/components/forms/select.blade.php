@props(['title', 'name', 'description', 'options', 'newButtonFunc'])

<flux:field>
    <flux:label>{{ $title ?? $name }}</flux:label>
    @if($description ?? null)
        <flux:description>{{ $description }}</flux:description>
    @endif
    <flux:select {{ $attributes }}>
        @foreach ($options as $o)
            <flux:select.option value="{{ $o->id }}">{{ $o->name }}</flux:select.option>
        @endforeach
    </flux:select>
    <flux:error name="{{ $name }}" />
</flux:field>