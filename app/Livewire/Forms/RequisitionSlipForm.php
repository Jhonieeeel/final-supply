<?php

namespace App\Livewire\Forms;

use App\Models\Requisition;
use App\Models\RequisitionItem;
use App\Models\Stock;
use Livewire\Attributes\Validate;
use Livewire\Form;

class RequisitionSlipForm extends Form
{
    #[Validate('required|file|mimes:pdf')]
    public $requisition_pdf;

    public function updateRequisition($requisition)
    {
        $this->validate();

        $filename = $this->requisition_pdf->getClientOriginalName();

        foreach ($requisition->items as $item) {
            Stock::find($item->stock_id)->decrement('quantity', $item->quantity);
        }

        return $requisition->update([
            'completed' => true,
            'requisition_pdf' => $this->requisition_pdf->storeAs('requisition_slip', $filename, 'public'),
        ]);

        $this->reset();
    }
}
