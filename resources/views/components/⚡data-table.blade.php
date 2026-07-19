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

    public function triggerAction($event, $id = null)
    {
        if ($id) {
            $this->dispatch($event, id: $id);
        } else {
            $this->dispatch($event);
        }
    }
};
?>

<flux:table :paginate="$this->paginateBy ? $this->rows : null">
    <flux:table.columns>
        @foreach($headers as $header)
            <flux:table.column>{{ $header }}</flux:table.column>
        @endforeach
        @if ($actions)
            <flux:table.column>
                Actions &nbsp;
                @if(!empty($actions['add']))
                    <flux:button 
                        variant="primary" 
                        color="cyan" 
                        size="sm"
                        wire:click="triggerAction('{{ $actions['add'] }}')" 
                    >
                        Add
                    </flux:button>
                @endif
            </flux:table.column>
        @endif
    </flux:table.columns>
    <flux:table.rows>
        @foreach($this->rows as $row)
            <flux:table.row :key="data_get($row, 'id')">
                @foreach($columns as $column)
                    <flux:table.cell>
                        {{ data_get($row, $column) }}
                    </flux:table.cell>
                @endforeach
                @if($actions)
                    <flux:table.cell>
                        @if(!empty($actions['edit']))
                            <flux:button 
                                variant="primary" 
                                color="cyan" 
                                size="sm"
                                wire:click="triggerAction('{{ $actions['edit'] }}', {{ data_get($row, 'id') }})"
                            >
                                Edit
                            </flux:button>
                        @endif
                        @if(!empty($actions['delete']))
                            <flux:button
                                variant="primary" 
                                color="red"
                                size="sm"
                                wire:click="triggerAction('{{ $actions['delete'] }}', {{ data_get($row, 'id') }})" 
                            >
                                Delete
                            </flux:button>
                        @endif
                    </flux:table.cell>
                @endif
            </flux:table.row>
        @endforeach
    </flux:table.rows>
</flux:table>