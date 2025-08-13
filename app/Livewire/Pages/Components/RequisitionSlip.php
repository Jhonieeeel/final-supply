<?php

namespace App\Livewire\Pages\Components;

use App\Livewire\Forms\RequisitionSlipForm;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\WireUiActions;;;

class RequisitionSlip extends Component
{

    use WithFileUploads, WireUiActions;

    public RequisitionSlipForm $slipForm;

    public $requisition;

    public function save()
    {
        $this->slipForm->updateRequisition($this->requisition);

        $this->notification()->send([
            'icon' => 'arrow-path',
            'title' => 'Updated Successfully!',
            'description' => 'Pdf updated.',
        ]);

        $this->dispatch('refresh-requisition-table');
    }

    public function render()
    {
        return view('livewire.pages.components.requisition-slip');
    }
}
