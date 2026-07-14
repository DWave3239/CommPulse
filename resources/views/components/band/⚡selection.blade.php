<?php

use App\Models\User;
use App\Models\BandUser;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Session;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    #[Session]
    public ?int $currentBand = null;

    #[Computed]
    public function bands()
    {
        $bands = User::find(Auth::id())
            ->bands()
            ->get();
        
        if (count($bands) == 1) {
            $this->currentBand = $bands[0]->id;
            session(['currentBand' => $this->currentBand]);
        }
        
        return $bands;
    }

    public function setCurrentBand()
    {
        // reroute to the dashboard after changing the current band
        session(['currentBand' => $this->currentBand]);
        return $this->redirect('/dashboard', navigate: true);
    }
};
?>

<div>
    @if (count($this->bands) > 1)
        <select wire:model="currentBand" wire:change="setCurrentBand">
        @foreach ($this->bands as $band)
            <option wire:key="{{ $band->id }}" value="{{ $band->id }}">{{ $band->name }}</option>
        @endforeach
        </select>
    @else
        <div>{{ $this->bands[0]->name }}</div>
    @endif
</div>