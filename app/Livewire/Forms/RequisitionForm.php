<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Auth;
use App\Models\Requisition;
use App\Models\RequisitionItem;
use App\Models\Stock;
use Livewire\Attributes\Validate;
use Livewire\Form;

use function PHPSTORM_META\map;

class RequisitionForm extends Form
{
    // request
    #[Validate(['nullable', 'min:6'])]
    public $ris;

    #[Validate(['nullable', 'exists:users,id'])]
    public $requested_by;

    #[Validate(['nullable', 'exists:users,id'])]
    public $approved_by;

    #[Validate(['nullable', 'exists:users,id'])]
    public $issued_by;

    #[Validate(['nullable', 'exists:users,id'])]
    public $received_by;

    #[Validate(['required', 'exists:stocks,id'])]
    public $stock_id;

    #[Validate(['nullable', 'exists:requisitions,id'])]
    public $requisition_id;

    #[Validate(['required', 'numeric'])]
    public $quantity;


    public function updateRequisition(Requisition $requisition)
    {
        $this->validate();

        $requisition->update([
            'ris' => $this->ris,
            'requested_by' => $this->requested_by,
            'approved_by' => $this->approved_by,
            'issued_by' => $this->issued_by,
            'received_by' => $this->received_by,
        ]);

        if ($this->requested_by) {
            foreach ($requisition->items as $item) {
                $stock = Stock::find($item->stock_id);
                $stock->update([
                    'quantity' => $stock->quantity -= $item->quantity
                ]);
            }
        }
    }

    public function update(RequisitionItem $requisition)
    {
        $this->validate();
        $requisition->update([
            'stock_id' => $this->stock_id,
            'quantity' => $this->quantity,
            'requisition_id' => $this->requisition_id
        ]);
    }

    public function create()
    {
        $requisition = Requisition::where('ris', $this->ris)->orWhere('owner_id', Auth::id())->get();

        if ($requisition) {
            // check if thers existing items 

        }

        $this->validate();

        $newRequisition = Requisition::create([
            'ris' => $this->ris,
            'owner_id' => Auth::id(),
            'requested_by' => Auth::id(),
            'approved_by' => $this->approved_by,
            'issued_by' => $this->issued_by,
            'received_by' => $this->received_by
        ]);

        return RequisitionItem::create([
            'stock_id' => $this->stock_id,
            'quantity' => $this->quantity,
            'requisition_id' => $newRequisition->id
        ]);
    }

    // public function submit()
    // {
    //     $requisition = Requisition::firstOrCreate(
    //         ['owner_id' => Auth::id()],
    //         [
    //             'ris' => $this->ris,
    //             'requested_by' => Auth::id(),
    //             'approved_by' => $this->approved_by,
    //             'issued_by' => $this->issued_by,
    //             'received_by' => $this->received_by
    //         ]
    //     );

    //     $existingItem = $requisition->items->firstWhere('stock_id', $this->stock_id);

    //     if ($existingItem) {
    //         return $existingItem->increment('quantity', $this->quantity);
    //     }

    //     return $requisition->items()->create([
    //         'stock_id' => $this->stock_id,
    //         'quantity' => $this->quantity,
    //         'requisition_id' => $requisition->id
    //     ]);
    // }
}
