<?php

namespace App\Livewire\Forms;

use App\Models\Requisition;
use Livewire\Attributes\Validate;
use Livewire\Form;

class RequisitionSlipForm extends Form
{
    #[Validate('required|file|mimes:pdf')]
    public $requisition_pdf;

    public function updateRequisition($requisition_id)
    {
        $this->validate();

        $slip = Requisition::find($requisition_id);

        if (file_exists(storage_path('app/public/' . $slip->requisition_file))) {
            unlink(storage_path('app/public/' . $slip->requisition_file));
        }

        return $slip->update([
            'requisition_file' => 'public/requisition_slip/' . $this->requisition_pdf->store('requisition_slip', 'public'),
            'completed' => true,
        ]);
    }
}
