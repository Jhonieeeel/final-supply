<?php

namespace App\Livewire\Pages\Afms;

use App\Livewire\Forms\RequisitionForm;
use App\Models\Requisition;
use App\Models\RequisitionItem;
use App\Models\Stock;
use App\Models\Supply;
use Illuminate\Http\Request;
use Livewire\Attributes\Layout;
use Livewire\Component;

class RequisitionTable extends Component
{

    public RequisitionForm $reqForm;
    public $selectedStock;

    public function save()
    {
        $this->reqForm->submit();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $requisitions = Requisition::with('items.stock.supply')->paginate(5);

        return view('livewire.pages.afms.requisition-table', [
            'requisitions' => $requisitions
        ]);
    }

    public function supplies(Request $request)
    {
        $search = $request->get('search', '');

        return response()->json(
            Supply::where('name', 'like', "%{$search}%")
                ->limit(10)
                ->with('stock')
                ->get(['id', 'name', 'quantity'])
        );
    }
}
