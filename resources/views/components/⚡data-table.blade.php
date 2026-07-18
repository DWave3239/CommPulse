<?php

use App\Query\DataTableQuery;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination, WithoutUrlPagination;

    public array $headers = [];
    public array $columns = [];
    public array $actions = [];
    public string $model;
    public ?array $queries = null;
    public ?int $paginateBy = null;

    #[Computed]
    public function rows()
    {
        $query = ($this->model)::query();

        if ($this->queries) {
            foreach ($this->queries as $q) {
                if (app($q) instanceof DataTableQuery) {
                    $query = app($q)->apply($query);
                }
            }
        }

        return $this->paginateBy
            ? $query->paginate($this->paginateBy)
            : $query->get();
    }

    public function triggerAction($event, $id)
    {
        $this->dispatch($event, id: $id);
    }
};
?>

<div>
    <table class="w-full text-sm text-left rtl:text-right text-body">
        <thead class="dark:bg-gray-75">
            <tr>
                @foreach($headers as $header)
                <th scope="col" class="px-6 py-3 font-medium">{{ $header }}</th>
                @endforeach
                @if ($actions)
                <th scope="col" class="px-6 py-3 font-medium relative">
                    <span>Actions</span>
                    @if($actions['add'])
                    <button 
                        wire:click="dispatch({{ $actions['add'] }})" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full float-right"
                    >
                        Add
                    </button>
                    @endif
                </th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($this->rows as $row)
                <tr class="hover:bg-gray-500">
                @foreach ($columns as $column)
                    <td class="dark:border-gray-300 px-4 py-2">{{ data_get($row, $column) }}</td>
                @endforeach
                @if($actions)
                    <td class="dark:border-gray-300 px-4 py-2">
                        @if($actions['edit'])
                        <button
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full"
                            wire:click="triggerAction('{{ $actions['edit'] }}', {{ data_get($row, 'id') }})"
                        >
                            Edit
                        </button>
                        @endif
                        @if($actions['delete'])
                        <button
                            wire:click="triggerAction('{{ $actions['delete'] }}', {{ data_get($row, 'id') }})" 
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full"
                        >
                            Delete
                        </button>
                        @endif
                    </td>
                @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    @if ($paginateBy)
    {{ $this->rows->links() }}
    @endif
</div>