<?php

use App\Livewire\Forms\ContactForm;
use App\Livewire\Forms\VenueForm;
use App\Models\Contact;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    public ContactForm $cform;
    public VenueForm $vform;

    public array $actions;

    public bool $isEdit = false;
    public bool $newVenue = false;

    public function mount(?Contact $contact = null)
    {
        if ($contact) {
            $this->cform->setContact($contact);
            $this->isEdit = true;
        }
    }

    #[Computed]
    public function venues()
    {
        $venues = $this->cform->getVenues();
        return array_map(
            static fn($v) => json_decode(json_encode(['id' => $v->id, 'name' => $v->description])),
            $venues
        );
    }
 
    #[On('contact-save')]
    public function save()
    {
        if ($this->newVenue) {
            $v = $this->vform->store();
            $this->cform->venue_id = $v->id;
        }
        if ($this->isEdit) {
            $this->cform->update();
            $text = 'The contact has been updated.';
        } else {
            $this->cform->store();
            $text = 'The contact has been created.';
        }
        Flux::toast([
            'heading' => 'Operation successful',
            'text' => $text,
            'variant' => 'success',
        ]);
        $this->dispatch($this->actions['close']);
    }

    public function toggleNewVenue()
    {
        $this->newVenue = !$this->newVenue;
    }
};
?>

<form>
    @if (!$newVenue)
    <div style="display: inline">
        <x-forms.select name="contactVenue" placeholder="Please select a venue..." wire:model="cform.venue_id" :options="$this->venues"/>
        <flux:button 
            variant="primary" 
            color="ghost" 
            size="xs"
            wire:click="toggleNewVenue(true)"
        >
            +
        </flux:button>
    </div>
    @else
    <div>
        <flux:button 
            variant="primary" 
            color="ghost" 
            size="xs"
            wire:click="toggleNewVenue(true)"
        >
            -
        </flux:button>
        <x-forms.input type="text" name="venueDescription" placeholder="Venue description" wire:model="vform.description" />
        <x-forms.input type="text" name="venueLocation" placeholder="Venue location" wire:model="vform.location" />
    </div>
    @endif
    <flux:separator class=""/>
    <x-forms.input type="text" name="contactName" placeholder="Contact name" wire:model="cform.name" />
    <x-forms.input type="text" name="contactLanguage" placeholder="Contact language" wire:model="cform.language" />
</form>