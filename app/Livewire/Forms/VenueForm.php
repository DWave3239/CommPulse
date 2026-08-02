<?php

namespace App\Livewire\Forms;

use App\Models\Venue;
use Livewire\Attributes\Validate;
use Livewire\Form;

class VenueForm extends Form
{
    #[Validate('required|min:4')]
    public ?string $description;

    public ?string $location = '';

    public function store()
    {
        $this->validate();
        $v = Venue::create($this->only(['description', 'location']));
        $this->reset();
        
        return $v;
    }
}
