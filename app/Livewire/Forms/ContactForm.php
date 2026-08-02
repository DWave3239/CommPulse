<?php

namespace App\Livewire\Forms;

use App\Models\Contact;
use App\Query\ContactWithBand;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ContactForm extends Form
{
    public ?Contact $contact;

    #[Validate('required')]
    public ?int $band_id;
   
    public ?int $venue_id = null;

    #[Validate('required|min:4')]
    public ?string $name;

    #[Validate('required|min:2|max:2')]
    public ?string $language;

    public function setContact(Contact $contact)
    {
        $this->contact = $contact;
 
        $this->name = $contact->name;
        $this->language = $contact->language;
        $this->venue_id = $contact->venue->id;
    }

    public function getVenues()
    {
        $contacts = app(ContactWithBand::class)->apply(Contact::query())->get();
        $venues = [];
        foreach ($contacts as $c) {
            $v = $c->venue;
            if ($v) {
                $venues[$v->id] = $v;
            }
        }
        return $venues;
    }

    public function store()
    {
        $this->band_id = Session::get('currentBand');

        $this->validate();
        Contact::create($this->only(['name', 'language', 'venue_id', 'band_id']));
        $this->reset();

        // or use Contact::create($this->pull()); to do both of the functions above 
    }

    public function update()
    {
        $this->band_id = Session::get('currentBand');

        $result = $this->validate();
        $this->contact->update($this->only(['name', 'language', 'venue_id']));
    }
}
