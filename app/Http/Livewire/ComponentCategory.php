<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentCategory extends Component
{
    use WithPagination;
    use WireToast;

    public $activity;
    public $search;

    public $name;

    public $category_id;

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
        $Query = Category::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        $categories = $Query->orderBy('id', 'DESC')->paginate(7);
        return view('livewire.component-category', compact('categories'));
    }

    public function store()
    {
        $this->validate();

        $category = new Category();
        $category->name = $this->name;
        $category->save();

        $this->clear();

        toast()
            ->success('Se guardo correctamente')
            ->push();
    }

    public function edit($id)
    {
        $this->clear();

        $this->category_id = $id;

        $category = Category::find($id);

        $this->name = $category->name;

        $this->activity = "edit";
    }

    public function update()
    {
        $category = Category::find($this->category_id);

        $this->validate();

        $category->name = $this->name;
        $category->save();

        $this->activity = "create";
        $this->clear();

        toast()
            ->success('Se actualizo correctamente')
            ->push();
    }

    public function modalDelete($id)
    {
        $this->category_id = $id;
        $this->deleteModal = true;
    }

    public function delete()
    {
        $category = Category::find($this->category_id);
        $category->delete();

        $this->clear();
        $this->deleteModal = false;

        toast()
            ->success('Se elimino correctamente')
            ->push();
    }

    public function clear()
    {
        $this->reset(['name', 'category_id']);
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
