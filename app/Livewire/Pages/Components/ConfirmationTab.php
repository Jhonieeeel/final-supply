<?php

namespace App\Livewire\Pages\Components;

use App\Models\Requisition;
use App\Models\RequisitionItem;
use Livewire\Attributes\On;
use Livewire\Attributes\Session;
use Livewire\Component;

class ConfirmationTab extends Component
{
    public $requisitions = [];

    public $selectedRequisition;
    public $requisitionStatus = false;

    public $activeTab;

    public function changeTab($tab)
    {
        $this->activeTab = $tab;
        $this->dispatch('selectedRequisition', requisition: $this->selectedRequisition, tab: $tab);
    }

    #[On('selectedRequisition')]
    public function setRequisition($requisition, $tab)
    {
        $this->selectedRequisition = $requisition;
        $this->activeTab = $tab;

        $this->requisitions = RequisitionItem::with('stock.supply', 'requisition')
            ->whereHas('requisition', function ($query) {
                $query->where('requested_by', $this->selectedRequisition);
            })
            ->get();
    }

    public function render()
    {
        return view('livewire.pages.components.confirmation-tab');
    }
}
