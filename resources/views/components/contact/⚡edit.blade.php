<?php

use App\Livewire\Forms\ContactForm;
use App\Models\Contact;
use Livewire\Component;

new class extends Component
{
    public ContactForm $form;

    public string $closeAction;

    public function mount(Contact $contact)
    {
        $this->form->setContact($contact);
    }
 
    public function save()
    {
        $this->form->update();
        $this->dispatch($this->closeAction);
    }
};
?>

<div>
    <livewire:modal title="Create Contact">
        <form wire:submit="save">
            <x-forms.input-text name="contactName" placeholder="Contact name" wire:model="form.name"/>
            <x-forms.input-text name="contactLanguage" placeholder="Contact language" wire:model="form.language"/>

            <div class="mt-4 flex justify-end gap-2">
                <button class="px-4 py-2" wire.click="$dispatch({{ $closeAction }})">
                    Cancel
                </button>

                <button class="bg-green-500 text-white px-4 py-2 rounded" wire:click="save">
                    Save
                </button>
            </div>
        </form>
    </livewire:modal>
</div>