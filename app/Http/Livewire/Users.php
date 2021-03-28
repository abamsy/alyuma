<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Waybill;
use Illuminate\Support\Facades\URL;
use App\Notifications\SetPasswordNotification;
use Illuminate\Validation\Rule;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;
    
    public $modalVisibility = false;
    public $modelId;
    public $name;
    public $email;
    public $phone;
    public $role;

    protected $listeners = ['delete'];

    public function rules ()
    {
        return [
        'name' => 'required|min:6',
        'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($this->modelId)],
        'phone' => [
                    'required',
                    'digits:11',
                    Rule::unique('users')->ignore($this->modelId)],
        'role' => 'required',
        ];
    }

    public function createModal()
    {
        $this->resetValidation();
        $this->reset(['name', 'email', 'phone', 'role','modelId']);
        $this->modalVisibility = true;
    }

    public function editModal($id)
    {
        $this->resetValidation();
        $this->reset(['name', 'email', 'phone', 'role']);
        $this->modelId = $id;
        $this->modalVisibility = true;
        $this->loadModal();
    }

    public function loadModal()
    {
        $data = User::find($this->modelId);
        $this->name = $data->name;
        $this->email = $data->email;
        $this->phone = $data->phone;
        $this->role = $data->role;
    }

    public function modelData()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => $this->role,
        ];
    }

    public function create()
    {
        $this->validate();

        $user = User::create($this->modelData());

        $this->modalVisibility = false;

        $this->dispatchBrowserEvent('swal:modal',[
            'type' => 'success',
            'title' => 'Record added successfully',
            'text' => '',
        ]);

        $url = URL::signedRoute('setpassword.create', $user);
        $user->notify(new SetPasswordNotification($url));

        $this->reset(['name', 'email', 'phone', 'role']);
 
        
        //return redirect()->route('users');
    }

    public function update()
    {
        $this->validate();

        User::find($this->modelId)->update($this->modelData());

        $this->modalVisibility = false;

        $this->dispatchBrowserEvent('swal:modal',[
            'type' => 'success',
            'title' => 'Record updated successfully',
            'text' => '',
        ]);
    }

    public function deleteConfirm($id)
    {
        $this->dispatchBrowserEvent('swal:confirm',[
            'type' => 'warning',
            'title' => 'Are you sure?',
            'text' => '',
            'id' => $id,
        ]);
    }
    
    public function delete($id)
    {
        $user = User::find($id);

        if ($user->isReceiver())
        {
            if ( $user->ballocations->count()) {
                $this->dispatchBrowserEvent('swal:modal',[
                    'type' => 'error',
                    'title' => 'Cannot delete record, User has Allocations',
                    'text' => '',
                ]);
            }
            else
            {
                $user->delete();

            $this->dispatchBrowserEvent('swal:modal',[
            'type' => 'success',
            'title' => 'Record deleted successfully',
            'text' => '',
            ]);
            //return redirect()->route('users');
            }
        }
        elseif ($user->isDispatcher())
        {
            if ( $user->lallocations->count()) {
                $this->dispatchBrowserEvent('swal:modal',[
                    'type' => 'error',
                    'title' => 'Cannot delete record, User has Allocations',
                    'text' => '',
                ]);
            }
            else
            {

            $user->delete();

            $this->dispatchBrowserEvent('swal:modal',[
            'type' => 'success',
            'title' => 'Record deleted successfully',
            'text' => '',
            ]);
            //return redirect()->route('users');
            }
        }
        else
        {
            $user->delete();

        $this->dispatchBrowserEvent('swal:modal',[
            'type' => 'success',
            'title' => 'Record deleted successfully',
            'text' => '',
        ]);

        //return redirect()->route('users');
        }
       
        
        
    }

    public function render()
    {
        return view('livewire.users', [
            'users' =>  User::whereNotIn('role', ['super admin'])->paginate(10)
        ]);
    }
}