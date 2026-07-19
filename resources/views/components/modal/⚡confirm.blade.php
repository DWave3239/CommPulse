<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    public string $name;

    public string $title = 'Confirm action';
    public string $text = 'Are you sure?';

    public ?int $entityId = null;
    public ?string $entityClass = null;
    public ?Model $entity = null;

    public string $confirmEvent;
    public ?string $cancelEvent = null;

    public string $confirmLabel = 'Confirm';
    public string $cancelLabel = 'Cancel';
    public string $confirmVariant = 'danger';

    public function mount(string $name = null)
    {
        $this->name = $name ?: Str::random(20);
    }

    #[On('open-confirm-delete')]
    public function open($entityClass, $id)
    {
        $this->entityId = $id;
        $this->entityClass = $entityClass;
        $this->entity = app($entityClass)::find($id);
        Flux::modal($this->name)->show();
    }

    public function confirm()
    {
        $this->dispatch(
            $this->confirmEvent, 
            entityClass: $this->entity::class,
            id: $this->entity->id,
        );
    }

    public function cancel()
    {
        if ($this->cancelEvent) {
            $this->dispatch($this->cancelEvent);
        }
    }
};
?>

<flux:modal :name="$name" class="max-w-md">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">
                {{ $title }}
            </flux:heading>

            <flux:text class="mt-2">
                {{ $text }}
            </flux:text>
        </div>

        <div class="flex justify-end gap-2">
            <flux:modal.close>
                <flux:button
                    type="button"
                    variant="ghost"
                    wire:click="cancel"
                >
                    Cancel
                </flux:button>
            </flux:modal.close>

            <flux:button
                :variant="$confirmVariant"
                wire:click="confirm"
            >
                {{ $confirmLabel }}
            </flux:button>
        </div>
    </div>
</flux:modal>