<?php

namespace App\Livewire\Forms;

use App\Models\Stock;
use Livewire\Attributes\Validate;
use Livewire\Form;

class StockForm extends Form
{
    #[Validate(['required', 'unique:stocks,barcode', 'min:1', 'max:21'])]
    public $barcode;

    #[Validate(['required', 'numeric'])]
    public $quantity;

    #[Validate(['required', 'numeric'])]
    public $price;

    #[Validate(['required', 'exists:supplies,id'])]
    public $supply_id;

    public function submit()
    {
        $this->validate();
        Stock::create([
            'barcode' => $this->barcode,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'supply_id' => (int) $this->supply_id
        ]);

        $this->reset();
    }

    public function edit(Stock $stock)
    {
        $stock->update([
            'barcode' => $this->barcode,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'supply_id' => (int) $this->supply_id
        ]);
    }
}
