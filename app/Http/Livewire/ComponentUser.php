<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentUser extends Component
{
    use WithPagination;
    use WireToast;

    public $activity;
    public $search;

    public $name;
    public $email;

    public $user_id;

    public $deleteModal;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'name' => 'required|max:200',
        'email' => 'required|unique:users|max:100',
    ];

    public function mount()
    {
        $this->activity = 'create';
        $this->search = "";
        $this->deleteModal = false;
    }

    public function render()
    {
        $Query = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        $users = $Query->orderBy('id', 'DESC')->paginate(7);
        return view('livewire.component-user', compact('users'));
    }

    public function store()
    {
        $this->validate();

        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = bcrypt("sistemas123");;
        $user->save();

        $this->clear();

        toast()
            ->success('Se guardo correctamente')
            ->push();
    }

    public function edit($id)
    {
        $this->clear();

        $this->user_id = $id;

        $user = User::find($id);

        $this->name = $user->name;
        $this->email = $user->email;

        $this->activity = "edit";
    }

    public function update()
    {
        $user = User::find($this->user_id);

        $this->validate([
            'name' => 'required|max:200',
            'email' => ['required', 'max:100', Rule::unique('users')->ignore($this->user_id)]
        ]);

        $user->name = $this->name;
        $user->email = $this->email;
        $user->save();

        $this->activity = "create";
        $this->clear();

        toast()
            ->success('Se actualizo correctamente')
            ->push();
    }

    public function modalDelete($id)
    {
        $this->user_id = $id;
        $this->deleteModal = true;
    }

    public function delete()
    {
        $user = User::find($this->user_id);
        $user->delete();

        $this->clear();
        $this->deleteModal = false;

        toast()
            ->success('Se elimino correctamente')
            ->push();
    }

    public function clear()
    {
        $this->reset(['name', 'email', 'user_id']);
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
