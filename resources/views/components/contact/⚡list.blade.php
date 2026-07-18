<?php

use App\Models\Contact;
use App\Query\ContactWithBand;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    public $chosenEditContact = null;

    #[On('updated-band-selection')]
    public function updateList()
    {
        unset($this->contacts);
    }

    #[On('contact-show-edit-overlay')]
    public function edit($id)
    {
        $this->chosenEditContact = Contact::find($id);
    }

    #[On('contact-show-add-overlay')]
    public function handleAddOverlayShow()
    {
        $this->addNewContact = true;
    }

    #[On('contact-overlay-close')]
    public function handleEditClose()
    {
        $this->chosenEditContact = null;
        $this->addNewContact = false;
        $this->updateList();
    }

    #[On('contact-show-delete-overlay')]
    public function handleDeleteOverlayShow()
    {
        $this->addNewContact = true;
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
        :columns="['id', 'venue.name', 'name', 'language']"
        :actions="['add' => 'contact-show-add-overlay', 'edit' => 'contact-show-edit-overlay', 'delete' => 'onDeleteEvent']"
        paginateBy="10"
    />

    <!-- Edit modal -->
    @if ($chosenEditContact)
    <livewire:contact.edit :contact="$chosenEditContact" closeAction="contact-overlay-close"/>
    @endif
</div>