<?php

use Livewire\Attributes\Computed;
use Livewire\Component;
use App\Models\Correspondence;

new class extends Component
{
    #[Computed]
    public function correspondences()
    {
        //return Correspondence::with()->latest->take(25)->get();
        return Correspondence::all();
    }
};
?>

<div>
    {{-- We must ship. - Taylor Otwell --}}
    <h2 class="mb-4 text-4xl font-bold tracking-tight text-heading md:text-2xl lg:text-3xl">
        Correspondences
    </h2>
    
    <table class="w-full text-sm text-left rtl:text-right text-body">
        <thead class="dark:bg-gray-75">
            <tr>
                <th scope="col" class="px-6 py-3 font-medium">ID</th>
                <th scope="col" class="px-6 py-3 font-medium">Description</th>
                <th scope="col" class="px-6 py-3 font-medium">Location</th>
                <th scope="col" class="px-6 py-3 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($this->correspondences as $correspondence)
            <tr class="hover:bg-gray-50">
                <td class="dark:border-gray-300 px-4 py-2">{{ $correspondence }}</td>
                <td class="dark:border-gray-300 px-4 py-2">{{ $correspondence }}</td>
                <td class="dark:border-gray-300 px-4 py-2">{{ $correspondence }}</td>
                <td class="dark:border-gray-300 px-4 py-2">[actions]</td>
            </tr>
        @empty
            <tr>
                <td>No correspondences yet ...</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>