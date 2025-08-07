<?php

namespace App\Livewire\Pages\Components;

use App\Livewire\Forms\RequisitionForm;
use App\Models\Requisition;
use App\Models\RequisitionItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Attributes\Session;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

use function PHPUnit\Framework\isEmpty;

class ConfirmationTab extends Component
{

    use WireUiActions;

    public $requisitions = [];
    public $confirmedItems = [];

    public $selectedRequisition;
    public $editRequisition;

    public $requisitionStatus = false;

    public $activeTab;

    public RequisitionForm $reqForm;


    public function issued($requisition_id)
    {
        $data = Requisition::find($requisition_id);
        $data->update([
            'issued_by' => Auth::id()
        ]);
    }

    public function approved($requisition_id)
    {
        $data = Requisition::find($requisition_id);
        $data->update([
            'approved_by' => Auth::id()
        ]);
    }

    public function delete($requisition_id)
    {
        RequisitionItem::find($requisition_id)->delete();
        $this->notification()->send([
            'icon' => 'trash',
            'title' => 'Deleted Successfully!',
            'description' => 'Stock deleted',
        ]);

        $this->dispatch('selectedRequisition', requisition: $this->selectedRequisition, tab: $this->activeTab);
    }

    public function save()
    {
        $this->reqForm->update($this->editRequisition);

        $this->notification()->send([
            'icon' => 'arrow-path',
            'title' => 'Updated Successfully!',
            'description' => 'Supply updated.',
        ]);
    }

    public function select($id)
    {
        $this->editRequisition = RequisitionItem::find($id);
        $this->reqForm->fill($this->editRequisition);
    }

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
