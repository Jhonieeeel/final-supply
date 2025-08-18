<?php

namespace App\Livewire\Forms;

use App\Models\ReportSupply;
use Illuminate\Support\Facades\Auth;
use App\Models\Requisition;
use App\Models\RequisitionItem;
use App\Models\Stock;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Form;


class RequisitionForm extends Form
{
    // RIS FORMAT = RIS-YEAR-MONTH-DAY-0001
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

    #[Validate(['required', 'numeric', 'min:1'])]
    public $quantity;


    public function updateRequisition(Requisition $requisition)
    {
        return $requisition->update([
            'ris' => $this->ris,
            'requested_by' => $this->requested_by,
            'approved_by' => $this->approved_by,
            'issued_by' => $this->issued_by,
            'received_by' => $this->received_by,
        ]);
    }

    public function update(RequisitionItem $requisition)
    {
        $this->validate();
        $requisition->update([
            'stock_id' => $this->stock_id,
            'quantity' => $this->quantity,
            'requisition_id' => $this->requisition_id
        ]);
        return;
    }


    // create new requisition or update existing one
    public function create()
    {
        // checking report
        $report = ReportSupply::whereMonth('created_at', Carbon::now()->month)->first();

        if (!$report) {
            $report = ReportSupply::create([
                'serial_number' => Carbon::now()->format('Y-m-d') . '-' . 1
            ]);
        }

        // checking requisition
        $requisition = Requisition::where('owner_id', Auth::id())->where('completed', false)->first();

        if ($requisition && $requisition->items()->exists()) {
            // checking itesm
            $item = $requisition->items()->where('stock_id', $this->stock_id)->first();
            $requisition->items()->updateOrCreate(
                ['stock_id' => $this->stock_id],
                ['quantity' => ($item ? $item->quantity + $this->quantity : $this->quantity)]
            );

            $this->reset();
            return;
        }

        $newRequisition = Requisition::create([
            'ris' => $this->ris,
            'owner_id' => Auth::id(),
            'requested_by' => Auth::id(),
            'approved_by' => User::where('name', 'Dave Madayag')->first()->id,
            'issued_by' => User::where('name', 'Ray Alingasa')->first()->id,
            'received_by' => $this->received_by,
            'report_supply_id' => $report->id
        ]);

        $newRequisition->items()->create([
            'stock_id' => $this->stock_id,
            'quantity' => $this->quantity
        ]);

        $this->reset();

        return;
    }
}
