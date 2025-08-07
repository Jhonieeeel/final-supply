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
        $this->dispatch('selectedRequisition', requisition: $id, tab: 'tab1');
    }

    public function save()
    {
        $this->reqForm->submit();
        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Created Successfully!',
            'description' => 'Requisition added',
        ]);

        if ($this->requisitionId) {
            $this->dispatch('selectedRequisition', requisition: Auth::id(), tab: 'tab1');
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.afms.requisition-table', [
            'requisitions' => Requisition::with('items')->paginate(5)
        ]);
    }

    public function getSupplies()
    {
        $stocks = Stock::with('supply')
            ->get(['id', 'supply_id'])
            ->map(function ($stock) {
                return [
                    'id' => $stock->id,
                    'name' => $stock->supply->name,
                ];
            });

        return $stocks->toArray();
    }
}
