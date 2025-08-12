<?php

namespace App\Livewire\Pages\Components;

use App\Livewire\Forms\RequisitionForm;
use App\Livewire\Forms\RequisitionSlipForm;
use App\Models\Requisition;
use App\Models\RequisitionItem;
use App\Models\RequisitionSlip;
use App\Models\User;
use App\Services\ConvertWordToPdfService;
use App\Services\GenerateWordService;
use Livewire\Attributes\On;
use Livewire\Component;

use WireUi\Traits\WireUiActions;



class ConfirmationTab extends Component
{

    use WireUiActions;

    public $requisitions = [];
    public $confirmedItems = [];

    public $selectedRequisition;
    public $editRequisition;
    public $pdf;

    public $requisitionStatus = false;

    public $activeTab;
    public $activeModal;

    public RequisitionForm $reqForm;
    public RequisitionSlipForm $slipform;

    public function generateWord()
    {
        $requisitionData = Requisition::find($this->selectedRequisition);

        // docx
        $word = new GenerateWordService();
        $docx = $word->writeDocument($requisitionData);

        // pdf 
        $converter = new ConvertWordToPdfService();
        $pdf = $converter->convert($docx);

        if (!file_exists(storage_path($pdf['pdf_path']))) {
            $requisitionData->update([
                'requisition_pdf' => 'requisition_slip/' . $pdf['file_name']
            ]);

            $this->notification()->send([
                'icon' => 'check',
                'title' => 'Requisition Slip Generated Successfully!',
                'description' => 'Requisition slip has been generated.',
            ]);

            return;
        }
    }

    public function updateConfirm()
    {
        $this->reqForm->updateRequisition($this->editRequisition);

        $this->notification()->send([
            'icon' => 'check',
            'title' => 'Confirmed Successfully!',
            'description' => 'Requisition confirmed.',
        ]);
        $this->dispatch("close-wireui-modal:{$this->activeModal}");

        $this->dispatch('selectedRequisition', owner_id: $this->selectedRequisition, tab: $this->activeTab);
    }

    public function confirm($id)
    {
        $this->editRequisition = Requisition::find($id);
        $this->reqForm->fill($this->editRequisition);
    }

    public function getUsers()
    {
        return User::all(['id', 'name'])->toArray();
    }

    public function delete($requisition_id)
    {
        RequisitionItem::find($requisition_id)->delete();
        $this->notification()->send([
            'icon' => 'trash',
            'title' => 'Deleted Successfully!',
        ]);

        $this->dispatch('refresh-requisition-table');

        $this->dispatch('selectedRequisition', owner_id: $this->selectedRequisition, tab: $this->activeTab);
    }

    public function save()
    {
        $this->reqForm->update($this->editRequisition);

        $this->notification()->send([
            'icon' => 'arrow-path',
            'title' => 'Updated Successfully!',
            'description' => 'Item updated.',
        ]);


        $this->dispatch('selectedRequisition', owner_id: $this->selectedRequisition, tab: $this->activeTab);
    }

    public function select($id)
    {
        $this->editRequisition = RequisitionItem::find($id);
        $this->reqForm->fill($this->editRequisition);
    }

    public function changeTab($tab)
    {
        $this->activeTab = $tab;

        if ($tab === 'tab2') {
            $this->pdf = Requisition::find($this->selectedRequisition)->first();
        }

        $this->dispatch('selectedRequisition', owner_id: $this->selectedRequisition, tab: $tab);
    }

    #[On('selectedRequisition')]
    public function setRequisition($owner_id, $tab)
    {

        $this->selectedRequisition = $owner_id;
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
