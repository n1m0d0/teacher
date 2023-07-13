<?php

namespace App\Http\Livewire;

use App\Models\Area;
use App\Models\classroom;
use App\Models\Level;
use App\Models\School;
use App\Models\Sublevel;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentClassroom extends Component
{
    use WithPagination;
    use WireToast;

    public $school;

    public $activity;
    public $search;

    public $level_id;
    public $sublevel_id;
    public $area_id;
    public $name;

    public $classroom_id;

    public $levels;
    public $sublevels;
    public $areas;

    public $deleteModal;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'sublevel_id' => 'required',
        'area_id' => 'required|max:200',
        'name' => 'required|max:200',
    ];

    public function mount(School $school)
    {
        $this->school = $school;
        $this->activity = 'create';
        $this->search = "";
        $this->levels = Level::all();
        $this->sublevels = collect();
        $this->areas = Area::all();
        $this->deleteModal = false;
    }

    public function render()
    {
        $Query = Classroom::query()
            ->where('school_id', $this->school->id)
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        $classrooms = $Query->orderBy('id', 'DESC')->paginate(7);
        return view('livewire.component-classroom', compact('classrooms'));
    }

    public function updatedLevelId()
    {
        if ($this->level_id == null) {
            $this->sublevels = collect();
        } else {
            $this->sublevels = Sublevel::where('level_id', $this->level_id)->get();
            $this->sublevel_id = null;
        }
    }
    
    public function store()
    {
        $this->validate();

        $classroom = new Classroom();
        $classroom->school_id = $this->school->id;
        $classroom->sublevel_id = $this->sublevel_id;        
        $classroom->area_id = $this->area_id;
        $classroom->name = $this->name;
        $classroom->save();

        $this->clear();

        toast()
            ->success('Se guardo correctamente')
            ->push();
    }

    public function edit($id)
    {
        $this->clear();

        $this->classroom_id = $id;

        $classroom = Classroom::find($id);

        $this->level_id = $classroom->sublevel->level->id;

        $this->updatedLevelId();

        $this->sublevel_id = $classroom->sublevel_id;
        $this->area_id = $classroom->area_id;
        $this->name = $classroom->name;

        $this->activity = "edit";
    }

    public function update()
    {
        $classroom = Classroom::find($this->classroom_id);

        $this->validate();

        $classroom->sublevel_id = $this->sublevel_id;        
        $classroom->area_id = $this->area_id;
        $classroom->name = $this->name;
        $classroom->save();

        $this->activity = "create";
        $this->clear();

        toast()
            ->success('Se actualizo correctamente')
            ->push();
    }

    public function modalDelete($id)
    {
        $this->classroom_id = $id;
        $this->deleteModal = true;
    }

    public function delete()
    {
        $classroom = Classroom::find($this->classroom_id);
        $classroom->delete();

        $this->clear();
        $this->deleteModal = false;

        toast()
            ->success('Se elimino correctamente')
            ->push();
    }

    public function clear()
    {
        $this->reset(['level_id', 'sublevel_id', 'area_id', 'name', 'classroom_id']);
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
