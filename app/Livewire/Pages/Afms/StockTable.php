<?php

namespace App\Livewire\Pages\Afms;

use App\Livewire\Forms\StockForm;
use App\Models\Stock;
use App\Models\Supply;
use Illuminate\Http\Request;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;

class StockTable extends Component
{

    use WireUiActions;
    use WithPagination;

    public StockForm $stockForm;

    public $selectedStock;
    public $tableSearch;

    public function edit()
    {
        $this->stockForm->edit($this->selectedStock);

        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Updated Successfully!',
            'description' => 'Supply updated.',
        ]);
    }

    public function select($stock_id)
    {
        $this->selectedStock = Stock::find($stock_id);
        $this->stockForm->fill(Stock::find($stock_id));
    }

    public function delete($stock_id)
    {
        Stock::find($stock_id)->delete();
        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Deleted Successfully!',
            'description' => 'Stock deleted',
        ]);
    }

    public function save()
    {
        $this->stockForm->submit();

        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Created Successfully!',
            'description' => 'Stock added',
        ]);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $stocks = Stock::with('supply')
                ->whereHas(
                    'supply',
                    fn($q) =>
                    $q->where('name', 'like', '%' . $this->tableSearch . '%')
                )
                ->paginate(10);
        

        return view('livewire.pages.afms.stock-table', [
            'stocks' => $stocks,
        ]);

        // return view('livewire.pages.afms.stock-table', [
        //     'stocks' => Stock::with('supply')
        //         ->whereHas('supply', function ($query) {
        //             $query->where('name', 'like', "%{$this->tableSearch}%");
        //         })
        //         ->paginate(5),
        // ]);
    }

    public function getSupplies()
    {
        return Supply::all(['id', 'name'])->toArray();
    }
}
