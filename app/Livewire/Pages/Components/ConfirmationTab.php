<?php

namespace App\Livewire\Pages\Components;

use App\Livewire\Forms\RequisitionForm;
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

    public $requisitionStatus = false;

    public $activeTab;

    public RequisitionForm $reqForm;


    public function generateWord()
    {
        // dd(RequisitionSlip::all());
        $generateRequisition = Requisition::find($this->selectedRequisition);

        // word
        $word = new GenerateWordService();
        $docx = $word->writeDocument($generateRequisition);

        // pdf 
        $converter = new ConvertWordToPdfService();
        $pdf = $converter->convert($docx);

        if (!file_exists(storage_path($pdf['requisition_file']))) {
            RequisitionSlip::create([
                'requisition_file' => 'public/' . $pdf['file_name'],
                'requisition_id' => $this->selectedRequisition,
            ]);

            $this->notification()->send([
                'icon' => 'check',
                'title' => 'Requisition Slip Generated Successfully!',
                'description' => 'Requisition slip has been generated.',
            ]);
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

        $this->dispatch('selectedRequisition', requisition: $this->selectedRequisition, tab: $this->activeTab);
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

        $this->dispatch('selectedRequisition', requisition: $this->selectedRequisition, tab: $this->activeTab);
    }

    public function select($id)
    {
        $this->editRequisition = RequisitionItem::find($id);
        $this->reqForm->fill($this->editRequisition);
    }

    public function changeTab($tab)
    {
        $this->activeTab = $tab;

        if ($tab === 'tab1') {
            return $this->dispatch('selectedRequisition', requisition: $this->selectedRequisition, tab: $tab);
        }

        $this->dispatch('renderPdf', [
            'requisition' => $this->selectedRequisition,
        ])->to('pages.components.requisition-slip');
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
