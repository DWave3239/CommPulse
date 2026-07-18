<?php

use Livewire\Component;

new class extends Component
{
    public string $title = '';
};
?>

<div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-gray-700 rounded-lg p-6 w-96">
        @if ($title)
        <h2 class="text-xl font-bold mb-4">
            {{ $title }}
        </h2>
        @endif
        {{ $slot }}
    </div>
</div>