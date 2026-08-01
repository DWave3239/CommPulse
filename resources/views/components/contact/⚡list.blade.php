<?php

use App\Models\Contact;
use App\Query\ContactWithBand;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    public ?Contact $chosenContact = null;
    public bool $showAddEditDialog = false;

    #[On('updated-band-selection')]
    public function reloadList()
    {
        unset($this->contacts);
    }

    #[On('contact-show-add-overlay')]
    public function handleAddOverlayShow()
    {
        $this->showAddEditDialog = true;
    }

    #[On('contact-show-edit-overlay')]
    public function handleEditOverlayShow($id)
    {
        $this->chosenContact = Contact::find($id);
        $this->showAddEditDialog = true;
    }

    #[On('contact-show-delete-overlay')]
    public function handleDeleteOverlayShow($id = null)
    {
        $this->dispatch('open-confirm-delete', id: $id, entityClass: Contact::class);
    }
    
    #[On('contact-overlay-close')]
    public function handleOverlayClose()
    {
        $this->chosenContact = null;
        $this->showAddEditDialog = false;
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
        :actions="['add' => 'contact-show-add-overlay', 'edit' => 'contact-show-edit-overlay', 'delete' => 'contact-show-delete-overlay']"
        paginateBy="10"
    />

    <!-- modals -->
    @if ($showAddEditDialog)
    <livewire:contact.add-edit 
        :contact="$chosenContact"
        :actions="['close' => 'contact-overlay-close']"
    />
    @endif

    <livewire:modal.confirm
        title="Delete contact"
        text="This action cannot be undone."
        confirmEvent="contact-delete"
    />
</div>