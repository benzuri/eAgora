<?php

namespace App\Livewire;


use Livewire\Component;
use App\Models\Booking;
use App\Models\Procedure;
use Livewire\WithPagination;

class Bookings extends Component
{
    use WithPagination;

    public $active;
    public $q;
    public $sortBy = 'id';
    public $sortAsc = true;
    public $message;

    public $confirmingItemAdd = false;
    public $confirmingItemDeletion = false;

    public $procedures;
    public $showProcedure;

    public $item = [];

    protected function rules()
    {
        return [
            'item.card' => 'required|string',
            'item.procedure_id' => 'required|exists:procedures,id',
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
        $this->procedures = Procedure::all();
        $this->showProcedure = 0;
    }

    public function render()
    {
        $items = Booking::when($this->q, function ($query) {
            return $query->where(function ($query) {
                $query->where('card', 'like', '%' . $this->q . '%');
            });
        })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');

        if ($this->showProcedure)
            $items->where('procedure_id', $this->showProcedure);

        $items = $items->paginate(10);

        return view('livewire.bookings', [
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

    public function confirmItemEdit(Booking $item)
    {
        $this->resetErrorBag();
        $this->item = $item->toArray();
        $this->confirmingItemAdd = true;
    }

    public function saveItem()
    {
        $this->validate();

        $save = Booking::updateOrCreate(['id' => $this->item['id'] ?? null], $this->item);

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

    public function deleteItem(Booking $item)
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
