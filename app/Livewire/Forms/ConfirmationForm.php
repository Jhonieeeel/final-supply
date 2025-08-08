<?php

namespace App\Livewire\Forms;

use App\Models\Requisition;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ConfirmationForm extends Form
{
    #[Validate(['nullable', 'exists:users,id'])]
    public $requested_by;

    #[Validate(['nullable', 'exists:users,id'])]
    public $approved_by;

    #[Validate(['nullable', 'exists:users,id'])]
    public $issued_by;

    #[Validate(['nullable', 'exists:users,id'])]
    public $received_by;

    public function requestedBy(Requisition $requisition)
    {
        $validated = $this->validate([
            'requested_by' => ['required', 'exists:users,id']
        ]);
        dd($validated);
    }
}
