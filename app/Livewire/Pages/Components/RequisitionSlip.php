<?php

namespace App\Livewire\Pages\Components;

use App\Livewire\Forms\RequisitionSlipForm;
use Livewire\Component;
use Livewire\WithFileUploads;;;

class RequisitionSlip extends Component
{

    use WithFileUploads;

    public RequisitionSlipForm $slipForm;

    public $pdf;

    public function update()
    {
        $this->slipForm->updateRequisition($this->pdf->requisition_id);
    }

    public function render()
    {
        return view('livewire.pages.components.requisition-slip');
    }
}
