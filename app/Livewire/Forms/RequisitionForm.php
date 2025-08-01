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

    #[Validate(['required', 'exists:users,id'])]
    public $requested_by;

    #[Validate(['required', 'exists:users,id'])]
    public $approved_by;

    #[Validate(['required', 'exists:users,id'])]
    public $issued_by;

    #[Validate(['required', 'exists:users,id'])]
    public $received_by;


    // items
    #[Validate(['required', 'exists:stocks,id'])]
    public $stock_id;

    #[Validate(['required', 'numeric'])]
    public $quantity;

    #[Validate(['required', 'exists:requisitions,id'])]
    public $requisition_id;


    public function submit()
    {

        // check if the requisition is existed
        $userRequest = Requisition::where('requested_by', Auth::id())->first();

        if ($userRequest) {
            return RequisitionItem::create([
                'stock_id' => $this->stock_id,
                'quantity' => (int) $this->quantity,
                'requisition_id' => $userRequest->id
            ]);
        }

        $requisition = Requisition::create([
            'ris' => $this->ris,
            'requested_by' => Auth::id(),
            'approved_by' => null,
            'issued_by' => null,
            'received_by' => null,
        ]);

        return RequisitionItem::create([
            'stock_id' => $this->stock_id,
            'quantity' => (int) $this->quantity,
            'requisition_id' => $requisition->id
        ]);
    }
}
