<?php

namespace App\Livewire\Pages\Components;

use Livewire\Attributes\On;
use Livewire\Component;

class RequisitionSlip extends Component
{

    public $requisition;

    #[On('renderPdf')]
    public function handleRequisition($requisition)
    {
        $this->requisition = $requisition;;
        dd($this->requisition);
    }

    public function render()
    {
        return view('livewire.pages.components.requisition-slip');
    }
}
