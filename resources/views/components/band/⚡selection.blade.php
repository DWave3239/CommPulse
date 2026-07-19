<?php

use App\Models\User;
use App\Models\BandUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    public ?int $currentBand = null;

    public function mount()
    {
        $this->currentBand = Session::get('currentBand', null);

        if (!$this->currentBand) {
            $band = Auth::user()->bands()->first();

            if ($band) {
                $this->currentBand = $band->id;
                Session::put('currentBand', $this->currentBand);
                $this->dispatch('updated-band-selection');
            }
        }
    }

    #[Computed]
    public function bands()
    {
        return Auth::user()->bands()->get();
    }

    public function setCurrentBand()
    {
        Session::put('currentBand', $this->currentBand);
        return $this->redirect('/dashboard', navigate: true);
    }
};
?>

<div>
    @if (count($this->bands) > 1)
        <flux:select wire:model="currentBand" wire:change="setCurrentBand">
            @foreach ($this->bands as $band)
                <flux:select.option 
                    wire:key="{{ $band->id }}" 
                    :value="$band->id"
                >
                    {{ $band->name }}
                </flux:select.option>
            @endforeach
        </flux:select>
    @else
        {{ $this->bands[0]->name }}
    @endif
</div>