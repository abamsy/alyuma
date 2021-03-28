<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Allocation;
use App\Models\Waybill;


class AWaybills extends Component
{
    public Allocation $allocation;

    public $modalVisibility = false;
    public $viewModalVisibility = false;
    public $receiveModalVisibility = false;
    public $modelId;
    public $allocation_id;
    public $dispatched_at;
    public $dquantity;
    public $received_at;
    public $rquantity;
    public $driver;
    public $dphone;
    public $dbags;
    public $rbags;
    public $truck;

    protected $listeners = ['delete'];

    public function rules ()
    {
        return [
        'dispatched_at' => 'required|date',          
        'dquantity' => 'required|integer|min:0',
        'dbags' => 'required|integer|min:0',
        'driver' => 'required|min:6',
        'dphone' => 
            'required|digits:11',
        'truck' => 'required',
        ];
    }

    public function viewModal()
    {
        $this->viewModalVisibility = true;
    }

    public function createModal()
    {
        $this->resetValidation();
        $this->reset(['allocation_id', 'dispatched_at', 'dquantity', 'dbags', 'driver', 'dphone', 'truck', 'modelId']);
        $this->modalVisibility = true;
    }

    public function editModal($id)
    {
        $this->resetValidation();
        $this->reset(['allocation_id', 'dispatched_at', 'dquantity', 'dbags', 'driver', 'dphone', 'truck', 'modelId']);
        $this->modelId = $id;
        $this->modalVisibility = true;
        $this->loadModal();
    }

    public function loadModal()
    {
        $data = Waybill::find($this->modelId);
        $this->allocation_id = $this->allocation->id;
        $this->dispatched_at = $data->dispatched_at;
        $this->dquantity = $data->dquantity;
        $this->dbags = $data->dbags;
        $this->driver = $data->driver;
        $this->dphone = $data->dphone;
        $this->truck = $data->truck;
    }

    public function modelData()
    {
        return [
            'allocation_id' => $this->allocation->id,
            'dispatched_at' => $this->dispatched_at,
            'dquantity' => $this->dquantity,
            'dbags' => $this->dbags,
            'driver' => $this->driver,
            'dphone' => $this->dphone,
            'truck' => $this->truck,
        ];
    }

    public function create()
    {
        $this->validate();

        $aq = $this->allocation->quantity;
        $sm = $this->allocation->waybills->sum('dquantity');
        $dq = $this->dquantity;
        $balance = $aq -  $sm;
        
        if ( $balance < $dq )
        {
            $this->dispatchBrowserEvent('swal:modal',[
                'type' => 'error',
                'title' => 'Allocated Quantity exceeded, balance is ' .$balance. 'MT',
                'text' => '',
            ]);

            
        }
        else
        {
            $waybill = Waybill::create($this->modelData());

        $this->modalVisibility = false; 

        $this->dispatchBrowserEvent('swal:modal',[
            'type' => 'success',
            'title' => 'Record added successfully',
            'text' => '',
        ]);

        $this->reset(['allocation_id', 'dispatched_at', 'dquantity', 'dbags', 'driver', 'dphone', 'truck']);

        //return redirect()->route('awaybills', [$this->allocation->id]);
        }
        
    }

    public function update()
    {
        $this->validate();
        $aq = $this->allocation->quantity;
        $sm = $this->allocation->waybills->sum('dquantity');
        $dq = $this->dquantity;
        $balance = $aq -  $sm;
        
        if ( $balance < $dq )
        {
            $this->dispatchBrowserEvent('swal:modal',[
                'type' => 'error',
                'title' => 'You cannot update the quantity by more than ' .$balance. 'MT',
                'text' => '',
            ]);

            
        }
        else
        {
        Waybill::find($this->modelId)->update($this->modelData());

        $this->modalVisibility = false;

        $this->dispatchBrowserEvent('swal:modal',[
            'type' => 'success',
            'title' => 'Record updated successfully',
            'text' => '',
        ]);
        }      
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
        Waybill::where('id', $id)->delete();

        $this->dispatchBrowserEvent('swal:modal',[
            'type' => 'success',
            'title' => 'Record deleted successfully',
            'text' => '',
        ]);

        //return redirect()->route('awaybills', [$this->allocation->id]);
    }

    public function receiveModal($id)
    {
        $this->modelId = $id;
        $this->receiveModalVisibility = true;
    }

    public function reditModal($id)
    {
        $this->resetValidation();
        $this->reset(['received_at', 'rquantity', 'rbags', 'modelId']);
        $this->modelId = $id;
        $this->receiveModalVisibility = true;
        $this->rloadModal();
    }

    public function rloadModal()
    {
        $data = Waybill::find($this->modelId);
        $this->received_at = $data->received_at;
        $this->rquantity = $data->rquantity;
        $this->rbags = $data->rbags;
    }

    public function rcreate()
    {
        $validatedData = $this->validate([
            'received_at' => 'required|date',
            'rquantity' => 'required|integer|min:0',
            'rbags' => 'required|integer|min:0',
        ]);

        Waybill::find($this->modelId)->update($validatedData);

        $this->receiveModalVisibility = false;

        $this->dispatchBrowserEvent('swal:modal',[
            'type' => 'success',
            'title' => 'Record created successfully',
            'text' => '',
        ]);

        $this->reset(['received_at', 'rquantity', 'rbags']);

        //return redirect()->route('awaybills', [$this->allocation->id]);
    }

    public function render()
    {   
        return view('livewire.a-waybills', [
            'allocation' => $this->allocation,
            'waybills' => Waybill::where('allocation_id', $this->allocation->id)->paginate(10)
            
        ]);
    }
}
