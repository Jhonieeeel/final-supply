<?php

namespace App\Livewire\Pages\Components;

use App\Models\Requisition;
use App\Models\RequisitionItem;
use Livewire\Attributes\On;
use Livewire\Component;

class ConfirmationTab extends Component
{
    public $requisitions;

    #[On('selectedRequisition')]
    public function setRequisition($requisition) 
    {
        $this->requisitions = RequisitionItem::with('stock.supply', 'requisition')
            ->whereHas('requisition', function ($query) use ($requisition) {
                $query->where('requested_by', $requisition);
            })
            ->get();
    }

    public function render()
    {
        return view('livewire.pages.components.confirmation-tab');
    }
}
