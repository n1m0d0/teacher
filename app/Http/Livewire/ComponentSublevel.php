<?php

namespace App\Http\Livewire;

use App\Models\Level;
use App\Models\Sublevel;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentSublevel extends Component
{
    use WithPagination;
    use WireToast;

    public $activity;
    public $search;

    public $name;
    public $level_id;

    public $sublevel_id;

    public $levels;

    public $deleteModal;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'name' => 'required|max:200',
        'level_id' => 'required',
    ];

    public function mount()
    {
        $this->activity = 'create';
        $this->search = "";
        $this->levels = Level::all();
        $this->deleteModal = false;
    }

    public function render()
    {
        $Query = Sublevel::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        $sublevels = $Query->orderBy('id', 'DESC')->paginate(7);
        return view('livewire.component-sublevel', compact('sublevels'));
    }
    
    public function store()
    {
        $this->validate();

        $sublevel = new Sublevel();
        $sublevel->name = $this->name;    
        $sublevel->level_id = $this->level_id;
        $sublevel->save();

        $this->clear();

        toast()
            ->success('Se guardo correctamente')
            ->push();
    }

    public function edit($id)
    {
        $this->clear();

        $this->sublevel_id = $id;

        $sublevel = Sublevel::find($id);

        $this->name = $sublevel->name;
        $this->level_id = $sublevel->level_id;

        $this->activity = "edit";
    }

    public function update()
    {
        $sublevel = Sublevel::find($this->sublevel_id);

        $this->validate();

        $sublevel->name = $this->name;
        $sublevel->level_id = $this->level_id;
        $sublevel->save();

        $this->activity = "create";
        $this->clear();

        toast()
            ->success('Se actualizo correctamente')
            ->push();
    }

    public function modalDelete($id)
    {
        $this->sublevel_id = $id;
        $this->deleteModal = true;
    }

    public function delete()
    {
        $sublevel = Sublevel::find($this->sublevel_id);
        $sublevel->delete();

        $this->clear();
        $this->deleteModal = false;

        toast()
            ->success('Se elimino correctamente')
            ->push();
    }

    public function clear()
    {
        $this->reset(['name', 'level_id', 'sublevel_id']);
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
