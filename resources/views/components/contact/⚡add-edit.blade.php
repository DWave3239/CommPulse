<?php

use App\Livewire\Forms\ContactForm;
use App\Models\Contact;
use Livewire\Component;

new class extends Component
{
    public ContactForm $form;
    public bool $isEdit = false;
    public array $actions;

    public function mount(?Contact $contact = null)
    {
        if ($contact) {
            $this->form->setContact($contact);
            $this->isEdit = true;
        }
    }
 
    public function save()
    {
        if ($this->isEdit) {
            $this->form->update();
            $text = 'The contact has been updated.';
        } else {
            $this->form->store();
            $text = 'The contact has been created.';
        }
        Flux::toast([
            'heading' => 'Operation successful',
            'text' => $text,
            'variant' => 'success',
        ]);
        $this->dispatch($this->actions['close']);
    }

    public function triggerAction(string $event)
    {
        $this->dispatch($event);
    }
};
?>

<div>
    <livewire:modal title="Create Contact">
        <form wire:submit="save">
            <x-forms.input type="text" name="contactName" placeholder="Contact name" wire:model="form.name" />
            <x-forms.input type="text" name="contactLanguage" placeholder="Contact language" wire:model="form.language" />

            <div class="mt-4 flex justify-end gap-2">
                <flux:button wire:click="triggerAction('{{ $actions['close'] }}')">
                    Cancel
                </flux:button>

                <flux:button variant="primary" color="cyan" wire:click="save">
                    Save
                </flux:button>
            </div>
        </form>
    </livewire:modal>
</div>