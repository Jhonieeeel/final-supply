<?php

namespace App\Livewire\Pages\Components;

use App\Models\RequisitionItem;
use Livewire\Attributes\On;
use Livewire\Component;

class ConfirmationTab extends Component
{
    public $requisition;

    #[On('selectedRequisition')]
    public function setRequisition($requisition) 
    {
        $this->requisition = RequisitionItem::query()
            ->with(['stock.supply', 'requisition'])
            ->find($requisition)->get();
    }

    public function render()
    {
        return view('livewire.pages.components.confirmation-tab');
    }
}
