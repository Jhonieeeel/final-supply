<?php

namespace App\Livewire\Pages\Afms;

use App\Livewire\Forms\RequisitionForm;
use App\Models\RequisitionItem;
use App\Models\Stock;
use App\Models\Supply;
use Illuminate\Http\Request;
use Livewire\Attributes\Layout;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class RequisitionTable extends Component
{
    use WireUiActions;

    public RequisitionForm $reqForm;
    public $selectedStock;

    public function save()
    {
        $this->reqForm->submit();

        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Created Successfully!',
            'description' => 'Requisition added',
        ]);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $requisitions = RequisitionItem::with('stock.supply', 'requisition')->get();

        return view('livewire.pages.afms.requisition-table', [
            'requisitions' => $requisitions
        ]);
    }

    public function supplies(Request $request)
    {
        $search = $request->get('search', '');

        $stocks = Stock::with('supply')
            ->whereHas('supply', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->limit(10)
            ->get();

        return response()->json(
            $stocks->map(function ($stock) {
                return [
                    'id' => $stock->id,
                    'name' => $stock->supply->name,
                ];
            })
        );
    }
}
