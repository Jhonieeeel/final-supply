<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Auth;
use App\Models\Requisition;
use App\Models\RequisitionItem;
use Livewire\Attributes\Validate;
use Livewire\Form;

class RequisitionForm extends Form
{
    // request
    #[Validate(['required', 'min:6'])]
    public $ris;

    #[Validate(['nullable', 'exists:users,id'])]
    public $approved_by;

    #[Validate(['nullable', 'exists:users,id'])]
    public $issued_by;

    #[Validate(['nullable', 'exists:users,id'])]
    public $received_by;

    #[Validate(['required', 'exists:stocks,id'])]
    public $stock_id;

    #[Validate(['required', 'numeric'])]
    public $quantity;


    public function submit()
    {
         $this->validate();

        $userRequest = Requisition::where('requested_by', Auth::id())->first();

        if ($userRequest) {
            RequisitionItem::create([
                'stock_id' => $this->stock_id,
                'quantity' => (int) $this->quantity,
                'requisition_id' => $userRequest->id
            ]);
        } else {
            $requisition = Requisition::create([
                'ris' => $this->ris,
                'requested_by' => Auth::id(),
                'approved_by' => $this->approved_by,
                'issued_by' => $this->issued_by,
                'received_by' => $this->received_by,
            ]);

            RequisitionItem::create([
                'stock_id' => $this->stock_id,
                'quantity' => (int) $this->quantity,
                'requisition_id' => $requisition->id
            ]);
        }

        $this->reset();
    }
}
