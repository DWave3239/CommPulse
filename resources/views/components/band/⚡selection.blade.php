<?php

use App\Models\User;
use App\Models\BandUser;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

new class extends Component
{
    public ?int $currentBand = null;

    public function mount()
    {
        if (!$this->currentBand) {
            $band = Auth::user()->bands()->first();

            if ($band) {
                $this->currentBand = $band->id;
                Session::put('currentBand', $this->currentBand);
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
        // reroute to the dashboard after changing the current band
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