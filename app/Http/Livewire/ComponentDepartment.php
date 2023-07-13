<?php

namespace App\Http\Livewire;

use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentDepartment extends Component
{
    use WithPagination;
    use WireToast;

    public $activity;
    public $search;

    public $name;
    public $acronym;

    public $department_id;

    public $deleteModal;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'name' => 'required|max:200',
        'acronym' => 'required|max:100',
    ];

    public function mount()
    {
        $this->activity = 'create';
        $this->search = "";
        $this->deleteModal = false;
    }

    public function render()
    {
        $Query = Department::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        $departments = $Query->orderBy('id', 'DESC')->paginate(7);
        return view('livewire.component-department', compact('departments'));
    }

    public function store()
    {
        $this->validate();

        $department = new Department();
        $department->name = $this->name;
        $department->acronym = $this->acronym;
        $department->save();

        $this->clear();

        toast()
            ->success('Se guardo correctamente')
            ->push();
    }

    public function edit($id)
    {
        $this->clear();

        $this->department_id = $id;

        $department = Department::find($id);

        $this->name = $department->name;
        $this->acronym = $department->acronym;

        $this->activity = "edit";
    }

    public function update()
    {
        $department = Department::find($this->department_id);

        $this->validate();

        $department->name = $this->name;
        $department->acronym = $this->acronym;
        $department->save();

        $this->activity = "create";
        $this->clear();

        toast()
            ->success('Se actualizo correctamente')
            ->push();
    }

    public function modalDelete($id)
    {
        $this->department_id = $id;
        $this->deleteModal = true;
    }

    public function delete()
    {
        $department = Department::find($this->department_id);
        $department->delete();

        $this->clear();
        $this->deleteModal = false;

        toast()
            ->success('Se elimino correctamente')
            ->push();
    }

    public function clear()
    {
        $this->reset(['name', 'acronym', 'department_id']);
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
