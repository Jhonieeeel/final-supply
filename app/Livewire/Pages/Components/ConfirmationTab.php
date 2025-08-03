<?php

namespace App\Livewire\Pages\Components;

use App\Models\Requisition;
use App\Models\RequisitionItem;
use Livewire\Attributes\On;
use Livewire\Component;

class ConfirmationTab extends Component
{
    public $requisitions;

    public $activeTab;

    public function changeTab($tab) {
        $this->activeTab = $tab;
    }

    #[On('selectedRequisition')]
    public function setRequisition($requisition, $tab) 
    {
        $this->requisitions = RequisitionItem::with('stock.supply', 'requisition')
            ->whereHas('requisition', function ($query) use ($requisition) {
                $query->where('requested_by', $requisition);
            })
            ->get();
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.pages.components.confirmation-tab');
    }
}
