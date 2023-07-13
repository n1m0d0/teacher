<?php

namespace App\Http\Livewire;

use App\Models\Classroom;
use App\Models\Level;
use App\Models\School;
use App\Models\Student;
use App\Models\Sublevel;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentStudent extends Component
{
    use WithPagination;
    use WireToast;

    public $school;

    public $activity;
    public $search;

    public $level_id;
    public $sublevel_id;
    public $name;

    public $student_id;

    public $levels;
    public $sublevels;
    public $classrooms;
    public $filter_levels;
    public $filter_sublevels;

    public $classroom_id;
    public $filter_level_id;
    public $filter_sublevel_id;

    public $deleteModal;
    public $addClassroomModal;
    public $deleteClassroomModal;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'sublevel_id' => 'required',
        'name' => 'required|max:200',
    ];

    public function mount(School $school)
    {
        $this->school = $school;
        $this->activity = 'create';
        $this->search = "";
        $this->levels = Level::all();
        $this->sublevels = collect();
        $this->classrooms = collect();
        $this->filter_levels = Level::all();
        $this->filter_sublevels = collect();
        $this->deleteModal = false;
        $this->addClassroomModal = false;
        $this->deleteClassroomModal = false;
    }

    public function render()
    {
        $Query = Student::query()
            ->where('school_id', $this->school->id)
            ->when($this->filter_sublevel_id, function ($query) {
                $query->where('sublevel_id', $this->filter_sublevel_id);
            })
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        $students = $Query->orderBy('name', 'ASC')->paginate(10);
        return view('livewire.component-student', compact('students'));
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

    public function updatedFilterLevelId()
    {
        if ($this->filter_level_id == null) {
            $this->filter_sublevels = collect();
        } else {
            $this->filter_sublevels = Sublevel::where('level_id', $this->filter_level_id)->get();
            $this->filter_sublevel_id = null;
        }
    }

    public function store()
    {
        $this->validate();

        $student = new Student();
        $student->school_id = $this->school->id;
        $student->sublevel_id = $this->sublevel_id;
        $student->name = $this->name;
        $student->save();

        $this->clear();

        toast()
            ->success('Se guardo correctamente')
            ->push();
    }

    public function edit($id)
    {
        $this->clear();

        $this->student_id = $id;

        $student = Student::find($id);

        $this->level_id = $student->sublevel->level->id;

        $this->updatedLevelId();

        $this->sublevel_id = $student->sublevel_id;
        $this->name = $student->name;

        $this->activity = "edit";
    }

    public function update()
    {
        $student = Student::find($this->student_id);

        $this->validate();

        $student->sublevel_id = $this->sublevel_id;
        $student->name = $this->name;
        $student->save();

        $this->activity = "create";
        $this->clear();

        toast()
            ->success('Se actualizo correctamente')
            ->push();
    }

    public function modalDelete($id)
    {
        $this->student_id = $id;
        $this->deleteModal = true;
    }

    public function delete()
    {
        $student = Student::find($this->student_id);
        $student->delete();

        $this->clear();
        $this->deleteModal = false;

        toast()
            ->success('Se elimino correctamente')
            ->push();
    }

    public function modalAddClassroom($id)
    {
        $this->student_id = $id;

        $student = Student::find($id);
        $this->classrooms = Classroom::where('school_id', $this->school->id)->where('sublevel_id', $student->sublevel_id)->get();

        $this->addClassroomModal = true;
    }

    public function addClassroom()
    {
        $this->validate([
            'classroom_id' => 'required'
        ]);

        $student = Student::find($this->student_id);
        $student->classrooms()->attach($this->classroom_id);

        $this->addClassroomModal = false;
        $this->clear();
        toast()
            ->success('Se añadido correctamente')
            ->push();
    }

    public function modalDeleteClassroom($id, $classroom_id)
    {
        $this->student_id = $id;
        $this->classroom_id = $classroom_id;
        $this->deleteClassroomModal = true;
    }

    public function deleteClassroom()
    {
        $student = Student::find($this->student_id);
        $student->classrooms()->detach($this->classroom_id);

        $this->clear();
        $this->deleteClassroomModal = false;

        toast()
            ->success('Se elimino correctamente')
            ->push();
    }

    public function clear()
    {
        $this->reset(['level_id', 'sublevel_id', 'name', 'student_id', 'classroom_id']);
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

    public function updatingFilterSublevelId()
    {
        $this->resetPage();
    }
}
