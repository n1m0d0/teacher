<?php

namespace App\Http\Livewire;

use App\Models\Level;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentLevel extends Component
{
    use WithPagination;
    use WireToast;

    public $activity;
    public $search;

    public $name;

    public $level_id;

    public $deleteModal;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'name' => 'required|max:200',
    ];

    public function mount()
    {
        $this->activity = 'create';
        $this->search = "";
        $this->deleteModal = false;
    }
    
    public function render()
    {
        $Query = Level::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        $levels = $Query->orderBy('id', 'DESC')->paginate(7);
        return view('livewire.component-level', compact('levels'));
    }

    public function store()
    {
        $this->validate();

        $level = new Level();
        $level->name = $this->name;
        $level->save();

        $this->clear();

        toast()
            ->success('Se guardo correctamente')
            ->push();
    }

    public function edit($id)
    {
        $this->clear();

        $this->level_id = $id;

        $level = Level::find($id);

        $this->name = $level->name;

        $this->activity = "edit";
    }

    public function update()
    {
        $level = Level::find($this->level_id);

        $this->validate();

        $level->name = $this->name;
        $level->save();

        $this->activity = "create";
        $this->clear();

        toast()
            ->success('Se actualizo correctamente')
            ->push();
    }

    public function modalDelete($id)
    {
        $this->level_id = $id;
        $this->deleteModal = true;
    }

    public function delete()
    {
        $level = Level::find($this->level_id);
        $level->delete();

        $this->clear();
        $this->deleteModal = false;

        toast()
            ->success('Se elimino correctamente')
            ->push();
    }

    public function clear()
    {
        $this->reset(['name', 'level_id']);
        $this->activity = "create";
    }

    public function resetSearch()
    {
        $this->reset(['search']);
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
