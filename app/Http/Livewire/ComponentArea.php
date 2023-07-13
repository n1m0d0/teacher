<?php

namespace App\Http\Livewire;

use App\Models\Area;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentArea extends Component
{
    use WithPagination;
    use WireToast;

    public $activity;
    public $search;

    public $name;
    public $acronym;
    public $category_id;

    public $area_id;

    public $categories;

    public $deleteModal;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'name' => 'required|max:200',
        'acronym' => 'required|max:100',
        'category_id' => 'required',
    ];

    public function mount()
    {
        $this->activity = 'create';
        $this->search = "";
        $this->categories = Category::all();
        $this->deleteModal = false;
    }
    
    public function render()
    {
        $Query = Area::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        $areas = $Query->orderBy('id', 'DESC')->paginate(7);
        return view('livewire.component-area', compact('areas'));
    }

    public function store()
    {
        $this->validate();

        $area = new Area();
        $area->name = $this->name;
        $area->acronym = $this->acronym;
        $area->category_id = $this->category_id;
        $area->save();

        $this->clear();

        toast()
            ->success('Se guardo correctamente')
            ->push();
    }

    public function edit($id)
    {
        $this->clear();

        $this->area_id = $id;

        $area = Area::find($id);

        $this->name = $area->name;
        $this->acronym = $area->acronym;
        $this->category_id = $area->category_id;

        $this->activity = "edit";
    }

    public function update()
    {
        $area = Area::find($this->area_id);

        $this->validate();

        $area->name = $this->name;
        $area->acronym = $this->acronym;
        $area->category_id = $this->category_id;
        $area->save();

        $this->activity = "create";
        $this->clear();

        toast()
            ->success('Se actualizo correctamente')
            ->push();
    }

    public function modalDelete($id)
    {
        $this->area_id = $id;
        $this->deleteModal = true;
    }

    public function delete()
    {
        $area = Area::find($this->area_id);
        $area->delete();

        $this->clear();
        $this->deleteModal = false;

        toast()
            ->success('Se elimino correctamente')
            ->push();
    }

    public function clear()
    {
        $this->reset(['name', 'acronym', 'category_id', 'area_id']);
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
