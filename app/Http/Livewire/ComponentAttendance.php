<?php

namespace App\Http\Livewire;

use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\School;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentAttendance extends Component
{
    use WithPagination;
    use WireToast;

    public $school;

    public $activity;
    public $search;

    public $date;
    public $classroom_id;

    public $attendance_id;

    public $classrooms;

    public $deleteModal;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'date' => 'required|date',
        'classroom_id' => 'required',
    ];

    public function mount(School $school)
    {
        $this->school = $school;
        $this->activity = 'create';
        $this->search = "";
        $this->classrooms = Classroom::where('school_id', $this->school->id)->get();
        $this->deleteModal = false;
    }
    
    public function render()
    {
        $Query = Attendance::query()
        ->whereHas('classroom', function($query) {
            $query->where('school_id', $this->school->id);
        });
        $assists = $Query->orderBy('id', 'DESC')->paginate(7);
        return view('livewire.component-attendance', compact('assists'));
    }

    public function store()
    {
        $this->validate();

        $attendance = new Attendance();
        $attendance->date = $this->date;
        $attendance->classroom_id = $this->classroom_id;
        $attendance->save();

        $this->clear();

        toast()
            ->success('Se guardo correctamente')
            ->push();
    }

    public function edit($id)
    {
        $this->clear();

        $this->attendance_id = $id;

        $attendance = Attendance::find($id);

        $this->date = $attendance->date;
        $this->classroom_id = $attendance->classroom_id;

        $this->activity = "edit";
    }

    public function update()
    {
        $attendance = Attendance::find($this->attendance_id);

        $this->validate();

        $attendance->date = $this->date;
        $attendance->classroom_id = $this->classroom_id;
        $attendance->save();

        $this->activity = "create";
        $this->clear();

        toast()
            ->success('Se actualizo correctamente')
            ->push();
    }

    public function modalDelete($id)
    {
        $this->attendance_id = $id;
        $this->deleteModal = true;
    }

    public function delete()
    {
        $attendance = Attendance::find($this->attendance_id);
        $attendance->delete();

        $this->clear();
        $this->deleteModal = false;

        toast()
            ->success('Se elimino correctamente')
            ->push();
    }

    public function clear()
    {
        $this->reset(['date', 'classroom_id', 'attendance_id']);
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
