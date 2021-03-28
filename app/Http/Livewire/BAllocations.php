<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Plant;
use App\Models\Allocation;

class BAllocations extends Component
{
    public Plant $plant;

    public function render()
    {
        return view('livewire.b-allocations', [
            'allocations' => Allocation::where('plant_id', $this->plant->id)->paginate(10),
            'plant' => $this->plant
        ]);
    }
}
