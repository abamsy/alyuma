<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Point;
use App\Models\Allocation;
use App\Models\Product;
use App\Models\Plant;
use Illuminate\Validation\Rule;

class LAllocations extends Component
{
    public Point $point; 

    public $modalVisibility = false;
    public $modelId;
    public $point_id;
    public $allocated_at;
    public $product_id;
    public $quantity;
    public $plant_id;

    protected $listeners = ['delete'];

    public function rules ()
    {
        return [
        'allocated_at' => 'required|date',
        'product_id' => 
                    'required',
                    
        'quantity' => 'required|integer|min:0',
                    
        'plant_id' => 
                    'required',
                    
        ];
    }

    public function createModal()
    {
        $this->resetValidation();
        $this->reset(['allocated_at', 'product_id', 'quantity', 'point_id', 'plant_id', 'modelId']);
        $this->modalVisibility = true;
    }

    public function editModal($id)
    {
        $this->resetValidation();
        $this->reset(['allocated_at', 'product_id', 'quantity', 'point_id', 'plant_id', 'modelId']);
        $this->modelId = $id;
        $this->modalVisibility = true;
        $this->loadModal();
    }

    public function loadModal()
    {
        $data = Allocation::find($this->modelId);
        $this->allocated_at = $data->allocated_at;
        $this->product_id = $data->product_id;
        $this->quantity = $data->quantity;
        $this->point_id = $data->point_id;
        $this->plant_id = $data->plant_id;
    }

    public function modelData()
    {
        return [
            'allocated_at' => $this->allocated_at,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'point_id' => $this->point->id,
            'plant_id' => $this->plant_id,
        ];
    }

    public function create()
    {
        $this->validate();


        $allocation = Allocation::create($this->modelData());

        $this->modalVisibility = false; 

        $this->dispatchBrowserEvent('swal:modal',[
            'type' => 'success',
            'title' => 'Record added successfully',
            'text' => '',
        ]);

        $this->reset(['allocated_at', 'product_id', 'quantity', 'point_id', 'plant_id']);

        //return redirect()->route('lallocations', [$this->point->id]);
    }

    public function update()
    {
        $this->validate();

        Allocation::find($this->modelId)->update($this->modelData());

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
        $allocation = Allocation::find($id);

        if ( $allocation->waybills()->count()) {
            $this->dispatchBrowserEvent('swal:modal',[
                'type' => 'error',
                'title' => 'Cannot delete record, Allocation has Waybills',
                'text' => '',
            ]);
        }
        else
        {
        
        $allocation->delete();

        $this->dispatchBrowserEvent('swal:modal',[
            'type' => 'success',
            'title' => 'Record deleted successfully',
            'text' => '',
        ]);

        //return redirect()->route('lallocations', [$this->point->id]);
        }
    }

    public function render()
    {
        return view('livewire.l-allocations', [
            'allocations' => Allocation::where('point_id', $this->point->id)->paginate(10),
            'products' => Product::all(),
            'plants' => Plant::all(),
            'point' => $this->point
        ]);
    }
    
}
