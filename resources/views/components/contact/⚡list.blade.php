<?php

use App\Models\Contact;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination, WithoutUrlPagination;
    
    public $query = '';

    public function search()
    {
        $this->resetPage();
    }

    public function clearSearch()
    {
        $this->query = '';
        $this->resetPage();
    }

    #[Computed]
    public function contacts()
    {
        return Contact::whereHas('band', function ($query) {
                $query->where('band_id', Session::get('currentBand'));
            })
            // ->orderBy('created_at', 'desc')
            ->where('name', 'like', '%'.$this->query.'%')
            ->simplePaginate(10);
    }

    public $chosenEditContact = null;

    public function edit(Contact $contact)
    {
        $this->chosenEditContact = $contact;
    }

    #[On('contact-overlay-close')]
    public function handleEditClose()
    {
        $this->chosenEditContact = null;
        $this->resetPage();
    }
};
?>

<div>
    <h2 class="mb-4 text-4xl font-bold tracking-tight text-heading md:text-2xl lg:text-3xl">
        Contacts
    </h2>

    <form class="max-w-md mx-auto" wire:submit="search">   
        <label for="search" class="block mb-2.5 text-sm font-medium text-heading sr-only">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/></svg>
            </div>
            <input 
                type="search" 
                id="search" 
                class="block w-full p-3 ps-9 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body" 
                placeholder="Search" 
                wire:model="query" 
                required 
            />
            <button 
                type="button" 
                class="text-white bg-brand hover:bg-brand-strong box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded text-xs px-3 py-1.5 focus:outline-none float-right"
            >
                Search
            </button>
            @if($query)
            <button
                type="button" 
                class="text-white bg-brand hover:bg-brand-strong box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded text-xs px-3 py-1.5 focus:outline-none float-right"
                wire:click="clearSearch"
            >
                X
            </button>
            @endif
        </div>
    </form>
    
    <table class="w-full text-sm text-left rtl:text-right text-body">
        <thead class="dark:bg-gray-75">
            <tr>
                <th scope="col" class="px-6 py-3 font-medium">ID</th>
                <th scope="col" class="px-6 py-3 font-medium">Venue</th>
                <th scope="col" class="px-6 py-3 font-medium">Name</th>
                <th scope="col" class="px-6 py-3 font-medium">Language</th>
                <th scope="col" class="px-6 py-3 font-medium relative">
                    <span>Actions</span>
                    <button 
                        wire:click="showAddOverlay()" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full float-right"
                    >
                        Add
                    </button>
                </th>
            </tr>
        </thead>
        <tbody>
        @foreach ($this->contacts as $contact)
            <tr class="hover:bg-gray-500">
                <td class="dark:border-gray-300 px-4 py-2">{{ $contact->id }}</td>
                <td class="dark:border-gray-300 px-4 py-2">{{ $contact->venue->description }}</td>
                <td class="dark:border-gray-300 px-4 py-2">{{ $contact->name }}</td>
                <td class="dark:border-gray-300 px-4 py-2">{{ $contact->language }}</td>
                <td class="dark:border-gray-300 px-4 py-2">
                    <button
                        data-modal-target="edit-modal"
                        data-modal-toggle="edit-modal" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full"
                        wire:click="edit({{ $contact }})"
                    >
                        Edit
                    </button>
                    <button
                        wire:click="delete({{ $contact->id }})" 
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full"
                    >
                        Delete
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $this->contacts->links() }}

    <!-- Edit modal -->
    @if ($chosenEditContact)
    <livewire:contact.edit :contact="$chosenEditContact" />
    @endif
</div>