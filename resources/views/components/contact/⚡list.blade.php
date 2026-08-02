<?php

use App\Models\Contact;
use App\Query\ContactWithBand;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    public ?Contact $chosenContact = null;
    public string $modalName = 'upsertContactModal';
    
    #[On('updated-band-selection')]
    public function reloadList()
    {
        unset($this->contacts);
    }

    #[On('contact-show-upsert-overlay')]
    public function handleEditOverlayShow($id = null)
    {
        if ($id) {
            $this->chosenContact = Contact::find($id);
        } else {
            $this->chosenContact = null;
        }
        Flux::modal($this->modalName)->show();
    }

    #[On('contact-show-delete-overlay')]
    public function handleDeleteOverlayShow($id = null)
    {
        $this->dispatch('open-confirm-delete', id: $id, entityClass: Contact::class);
    }
    
    #[On('contact-upsert-modal-close')]
    public function handleOverlayClose()
    {
        Flux::modal($this->modalName)->close();
        $this->chosenContact = null;
        $this->reloadList();
    }

    #[On('contact-delete')]
    public function deleteContact($id)
    {
        $contact = Contact::find($id);
        if ($contact->band->id !== Session::get('currentBand')){
            return;
        }

        if ($contact->delete()) {
            Flux::toast([
                'heading' => 'Operation successful',
                'text' => 'The contact has been deleted.',
                'variant' => 'success',
            ]);
        } else {
            Flux::toast([
                'heading' => 'Operation unsuccessful',
                'text' => 'The contact could not be deleted.',
                'variant' => 'danger',
            ]);
        }

        $this->reloadList();
    }
};
?>

<div>
    <h2 class="mb-4 text-4xl font-bold tracking-tight text-heading md:text-2xl lg:text-3xl">
        Contacts
    </h2>
    
    <livewire:data-table 
        :model="Contact::class"
        :queries="[ContactWithBand::class]"
        :headers="['ID', 'Venue', 'Name', 'Language']" 
        :columns="['id', 'venue.description', 'name', 'language']"
        :actions="['add' => 'contact-show-upsert-overlay', 'edit' => 'contact-show-upsert-overlay', 'delete' => 'contact-show-delete-overlay']"
        paginateBy="10"
    />

    <!-- modals -->
    <livewire:modal.upsert 
        title="Create Contact"
        name="{{ $modalName }}"
        saveEvent="contact-save"
        cancelEvent="contact-upsert-modal-close"
    >
        <livewire:contact.upsert 
            :contact="$chosenContact"
            :actions="['close' => 'contact-upsert-modal-close']"
        />
    </livewire:modal.upsert>

    <livewire:modal.confirm
        title="Delete contact"
        text="This action cannot be undone."
        confirmEvent="contact-delete"
    />
</div>