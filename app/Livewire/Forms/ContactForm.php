<?php

namespace App\Livewire\Forms;

use App\Models\Contact;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ContactForm extends Form
{
    public ?Contact $contact;

    #[Validate('required|min:4')]
    public string $name;

    #[Validate('required|min:2|max:2')]
    public string $language;

    public function setContact(Contact $contact)
    {
        $this->contact = $contact;
 
        $this->name = $contact->name;
        $this->language = $contact->language;
    }
 
    public function store()
    {
        $this->validate();
 
        Contact::create($this->only(['name', 'language']));
        $this->reset();

        // or use Contact::create($this->pull()); to do both of the functions above 
    }
 
    public function update()
    {
        $this->validate();
 
        $this->contact->update(
            $this->only(['name', 'language'])
        );
    }
}
