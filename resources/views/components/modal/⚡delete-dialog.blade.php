<?php

use Livewire\Component;

new class extends Component
{
    public string $title = '';
    public string $text = '';
    public array $actions;

    public function triggerAction(string $event)
    {
        $this->dispatch($event);
    }
};
?>

<livewire:modal :title="$title">
    <div>{{ $text }}</div>
    <div class="mt-4 flex justify-end gap-2">
        <button class="bg-red-500 hover:bg-red-700 px-4 py-2 text-white rounded" wire:click="triggerAction('{{ $actions['confirm'] }}')">Confirm</button>
        <button class="bg-gray-800 hover:bg-gray-500 px-4 py-2 text-white rounded" wire:click="triggerAction('{{ $actions['deny'] }}')">Deny</button>
    </div>
</livewire:modal>