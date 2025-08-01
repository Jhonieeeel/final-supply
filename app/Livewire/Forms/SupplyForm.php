<?php

namespace App\Livewire\Forms;

use App\Models\Supply;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SupplyForm extends Form
{
    #[Validate('required', 'min:1')]
    public $name;

    #[Validate('required')]
    public $category;

    #[Validate('required')]
    public $unit;

    public function submit()
    {
        $this->validate();

        Supply::create([
            'name' => $this->name,
            'category' => $this->category,
            'unit' => $this->unit
        ]);

        $this->reset();
    }

    public function edit(Supply $supply)
    {
        $supply->update([
            'name' => $this->name,
            'category' => $this->category,
            'unit' => $this->unit
        ]);
    }
}
