<?php

namespace App\Livewire\Pages\Afms;

use App\Livewire\Forms\RequisitionForm;
use App\Models\Requisition;
use App\Models\RequisitionItem;
use App\Models\Stock;
use App\Models\Supply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class RequisitionTable extends Component
{
    use WireUiActions;

    public RequisitionForm $reqForm;
    public $selectedTab;
    public $requisitionId;

    public function select($id)
    {
        $this->selectedTab = 'tab1';
        $this->requisitionId = $id;
        $this->dispatch('selectedRequisition', requisition_id: $this->requisitionId, tab: 'tab1');
    }

    public function save()
    {
        $this->reqForm->create();


        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Created Successfully!',
            'description' => 'Requisition added',
        ]);

        if ($this->requisitionId) {
            $this->dispatch('selectedRequisition', requisition_id: $this->requisitionId, tab: 'tab1');
        }

        $this->dispatch('close-wireui-modal:add-requisition');
    }

    #[On('refresh-requisition-table')]
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.afms.requisition-table', [
            'requisitions' => Requisition::with('items')
                ->has('items')
                ->paginate(5)
        ]);
    }

    public function getSupplies()
    {
        $stocks = Stock::where('quantity', '>', 0)->with('supply')
            ->get(['id', 'supply_id', 'quantity'])
            ->map(function ($stock) {
                return [
                    'id' => $stock->id,
                    'name' => $stock->supply->name,
                    'quantity' => "Available: {$stock->quantity} pcs", // formatted
                ];
            });
        return $stocks->toArray();
    }
}
