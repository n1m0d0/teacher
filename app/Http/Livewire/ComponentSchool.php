<?php

namespace App\Http\Livewire;

use App\Models\Department;
use App\Models\School;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentSchool extends Component
{
    use WithPagination;
    use WireToast;

    public $user;

    public $activity;
    public $search;

    public $department_id;
    public $district;
    public $core;
    public $name;

    public $school_id;

    public $departments;

    public $deleteModal;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'department_id' => 'required',
        'district' => 'required|max:200',
        'core' => 'required|max:200',
        'name' => 'required|max:200',
    ];

    public function mount()
    {
        $this->user = auth()->user();
        $this->activity = 'create';
        $this->search = "";
        $this->departments = Department::all();
        $this->deleteModal = false;
    }

    public function render()
    {
        $Query = School::query()
            ->where('user_id', $this->user->id)
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        $schools = $Query->orderBy('id', 'DESC')->paginate(7);
        return view('livewire.component-school', compact('schools'));
    }

    public function store()
    {
        $this->validate();

        $school = new School();
        $school->user_id = $this->user->id;
        $school->department_id = $this->department_id;
        $school->district = $this->district;
        $school->core = $this->core;
        $school->name = $this->name;
        $school->save();

        $this->clear();

        toast()
            ->success('Se guardo correctamente')
            ->push();
    }

    public function edit($id)
    {
        $this->clear();

        $this->school_id = $id;

        $school = School::find($id);

        $this->department_id = $school->department_id;
        $this->district = $school->district;
        $this->core = $school->core;
        $this->name = $school->name;

        $this->activity = "edit";
    }

    public function update()
    {
        $school = School::find($this->school_id);

        $this->validate();

        $school->department_id = $this->department_id;
        $school->district = $this->district;
        $school->core = $this->core;
        $school->name = $this->name;
        $school->save();

        $this->activity = "create";
        $this->clear();

        toast()
            ->success('Se actualizo correctamente')
            ->push();
    }

    public function modalDelete($id)
    {
        $this->school_id = $id;
        $this->deleteModal = true;
    }

    public function delete()
    {
        $school = School::find($this->school_id);
        $school->delete();

        $this->clear();
        $this->deleteModal = false;

        toast()
            ->success('Se elimino correctamente')
            ->push();
    }

    public function clear()
    {
        $this->reset(['department_id', 'district', 'core', 'name', 'school_id']);
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
