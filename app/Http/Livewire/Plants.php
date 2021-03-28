<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Plant;
use Illuminate\Validation\Rule;

class Plants extends Component
{
    public $modalVisibility = false;
    public $modelId;
    public $name;
    public $user_id;
    public $address;
    public $city;
    public $state; 

    protected $listeners = ['delete'];

    public function rules ()
    {
        return [
        'name' => ['required', 'min:6',
                    Rule::unique('plants')->ignore($this->modelId)],
        'user_id' => [
                    'required',
                    Rule::unique('plants')->ignore($this->modelId)],
        'address' => ['required',
                    Rule::unique('plants')->ignore($this->modelId)],
        'city' => 'required',
        'state' => 'required',
        ];
    }

    public function createModal()
    {
        $this->resetValidation();
        $this->reset(['name', 'user_id', 'address', 'city', 'state', 'modelId']);
        $this->modalVisibility = true;
    }

    public function editModal($id)
    {
        $this->resetValidation();
        $this->reset(['name', 'user_id', 'address', 'city', 'state', 'modelId']);
        $this->modelId = $id;
        $this->modalVisibility = true;
        $this->loadModal();
    }

    public function loadModal()
    {
        $data = Plant::find($this->modelId);
        $this->name = $data->name;
        $this->user_id = $data->user_id;
        $this->address = $data->address;
        $this->city = $data->city;
        $this->state = $data->state;
    }

    public function modelData()
    {
        return [
            'name' => $this->name,
            'user_id' => $this->user_id,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
        ];
    }

    public function create()
    {
        $this->validate();

        $plant = Plant::create($this->modelData());

        $this->modalVisibility = false; 

        $this->dispatchBrowserEvent('swal:modal',[
            'type' => 'success',
            'title' => 'Record added successfully',
            'text' => '',
        ]);

        $this->reset(['name', 'user_id', 'address', 'city', 'state']);

        //return redirect()->route('plants');
    }

    public function update()
    {
        $this->validate();

        Plant::find($this->modelId)->update($this->modelData());

        $this->modalVisibility = false;

        $this->dispatchBrowserEvent('swal:modal',[
            'type' => 'success',
            'title' => 'Record updated successfully',
            'text' => '',
        ]);

        $this->reset(['name', 'user_id', 'address', 'city', 'state']);
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
        $plant = Plant::find($id);

        if ( $plant->allocations()->count()) {
            $this->dispatchBrowserEvent('swal:modal',[
                'type' => 'error',
                'title' => 'Cannot delete record, Blending plant has Allocation',
                'text' => '',
            ]);
        }
        else
        {
            $plant->delete();

            $this->dispatchBrowserEvent('swal:modal',[
            'type' => 'success',
            'title' => 'Record deleted successfully',
            'text' => '',
        ]);

        //return redirect()->route('plants');
    }
    }

    public function render()
    {
        return view('livewire.plants', [
            'users' => User::where('role', 'receiver')->get(),
            'plants' => Plant::with('user')->paginate(10)
        ]);
    }
}
