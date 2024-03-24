<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Procedure;
use Livewire\WithPagination;
use App\Models\Type;
use App\Models\State;

class Procedures extends Component
{
    use WithPagination;

    public $active;
    public $q;
    public $sortBy = 'id';
    public $sortAsc = true;
    public $message;

    public $confirmingItemAdd = false;
    public $confirmingItemDeletion = false;

    public $types;
    public $states;

    public $showType;
    public $showState;

    public $item = [];

    protected function rules()
    {
        return [
            'item.title' => 'required|string|unique:procedures,title',
            'item.type_id' => 'required|exists:types,id',
            'item.state_id' => 'required|exists:states,id',
        ];
    }

    protected $queryString = [
        'active' => ['except' => false],
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortAsc' => ['except' => true],
    ];

    public function mount()
    {
        $this->types = Type::all();
        $this->states = State::all();
        $this->showType = 0;
        $this->showState = 0;
    }

    public function render()
    {
        $items = Procedure::when($this->q, function ($query) {
            return $query->where(function ($query) {
                $query->where('title', 'like', '%' . $this->q . '%');
            });
        })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');

        if ($this->showType)
            $items->where('type_id', $this->showType);
        if ($this->showState)
            $items->where('state_id', $this->showState);

        $items = $items->paginate(10);

        return view('livewire.procedures', [
            'items' => $items,
        ]);
    }

    public function updatingActive()
    {
        $this->resetPage();
    }

    public function updatingQ()
    {
        $this->resetPage();
    }

    public function confirmItemAdd()
    {
        $this->reset(['item']);
        $this->confirmingItemAdd = true;
    }

    public function confirmItemEdit(Procedure $item)
    {
        $this->resetErrorBag();
        $this->item = $item->toArray();
        $this->confirmingItemAdd = true;
    }

    public function saveItem()
    {
        $this->validate();

        $save = Procedure::updateOrCreate(['id' => $this->item['id'] ?? null], $this->item);

        if (!$save->wasChanged() && !$save->wasRecentlyCreated)
            $this->dispatch('message', $this->message = 'El elemento no ha cambiado');
        elseif ($save->wasRecentlyCreated)
            $this->dispatch('message', $this->message = 'Elemento creado con exito');
        else
            $this->dispatch('message', $this->message = 'Elemento actualizado con exito');

        $this->confirmingItemAdd = false;
    }

    public function confirmItemDeletion($id)
    {
        $this->confirmingItemDeletion = $id;
    }

    public function deleteItem(Procedure $item)
    {
        $item->delete();
        $this->confirmingItemDeletion = false;
        $this->dispatch('message', $this->message = 'Elemento eliminado con exito');
    }

    public function sortByField($field)
    {
        $this->sortAsc = ($field === $this->sortBy) ? !$this->sortAsc : $this->sortAsc;
        $this->sortBy = $field;
    }
}

