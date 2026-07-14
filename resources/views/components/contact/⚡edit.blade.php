<?php

use App\Livewire\Forms\ContactForm;
use App\Models\Contact;
use Livewire\Component;

new class extends Component
{
    public ContactForm $form;

    public function mount(Contact $contact)
    {
        $this->form->setContact($contact);
    }
 
    public function save()
    {
        $this->form->update();
        $this->dispatch('contact-overlay-close'); 
    }
};
?>

<div>
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="bg-gray-700 rounded-lg p-6 w-96">
            <h2 class="text-xl font-bold mb-4">
                Create Contact
            </h2>

            <form wire:submit="save">
                <input 
                    type="text" 
                    placeholder="Contact name"
                    class="border p-2 w-full"
                    wire:model="form.name"
                />
                <div>
                    @error('form.name') <span class="error">{{ $message }}</span> @enderror
                </div>
            
                <input 
                    type="text" 
                    placeholder="Contact language"
                    class="border p-2 w-full"
                    wire:model="form.language"
                />
                <div>
                    @error('form.language') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="mt-4 flex justify-end gap-2">
                    <button
                        class="px-4 py-2"
                    >
                        Cancel
                    </button>

                    <button
                        class="bg-green-500 text-white px-4 py-2 rounded"
                    >
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>