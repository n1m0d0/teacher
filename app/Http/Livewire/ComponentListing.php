<?php

namespace App\Http\Livewire;

use App\Models\Attendance;
use App\Models\Listing;
use App\Models\Student;
use Attribute;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentListing extends Component
{
    use WithPagination;
    use WireToast;

    public $attendance;

    public $activity;
    public $search;

    public $category_id;
    
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

    public function mount(Attendance $attendance)
    {
        $this->attendance = $attendance;
        $this->activity = 'create';
        $this->search = "";
        $this->deleteModal = false;

        $aux = Listing::where('attendance_id', $this->attendance->id)->get();
        if($aux->count() == 0)
        {
            $students = Student::where('school_id', $this->attendance->classroom->school->id)->where('sublevel_id', $this->attendance->classroom->sublevel_id)->get();
            foreach($students as $student)
            {
                $listing = new Listing();
                $listing->attendance_id = $this->attendance->id;
                $listing->student_id = $student->id;
                $listing->type = Listing::Attended;
                $listing->save();
            }
        }
    }
    
    public function render()
    {
        $Query = Listing::query()
            ->when($this->search, function ($query) {
                $query->whereHas('student', function($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                });
            });
        $listings = $Query->orderBy('id', 'DESC')->paginate(10);
        return view('livewire.component-listing', compact('listings'));
    }
    
    public function modalDelete($id)
    {
        $this->category_id = $id;
        $this->deleteModal = true;
    }

    public function delete()
    {
        $category = Listing::find($this->category_id);
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
