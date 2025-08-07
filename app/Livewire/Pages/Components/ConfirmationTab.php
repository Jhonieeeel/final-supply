<?php

namespace App\Livewire\Pages\Components;

use App\Livewire\Forms\RequisitionForm;
use App\Models\Requisition;
use App\Models\RequisitionItem;
use App\Models\User;
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

    public function editRequisitions()
    {
        $this->reqForm->updateRequisition($this->editRequisition);

        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Updated Successfully!',
            'description' => 'Requested By updated',
        ]);
    }


    public function confirm($requisition_id)
    {
        $this->editRequisition = Requisition::find($requisition_id);
        $this->reqForm->fill($this->editRequisition);
    }


    public function getReceivers()
    {
        return User::all(['id', 'name'])->toArray();
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
                $query->where('owner_id', $this->selectedRequisition);
            })
            ->get();
    }

    public function render()
    {
        return view('livewire.pages.components.confirmation-tab');
    }
}
