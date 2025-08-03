<?php

namespace App\Livewire\Pages\Afms;

use App\Livewire\Forms\SupplyForm;
use App\Models\Supply;
use Livewire\Attributes\Layout;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class SupplyTable extends Component
{
    use WireUiActions;
    public SupplyForm $supplyForm;

    public $search;
    public $selectedSupply;


    public function edit()
    {
        $this->supplyForm->edit($this->selectedSupply);

        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Updated Successfully!',
            'description' => 'Supply updated.',
        ]);
    }

    public function select($supply_id)
    {
        $this->selectedSupply = Supply::find($supply_id);
        $this->supplyForm->fill(Supply::find($supply_id));
    }

    public function delete($supply_id)
    {
        $supply = Supply::find($supply_id)->delete();

        $this->notification()->send([
            'icon' => 'trash',
            'title' => 'Deleted Successfully!',
            'description' => 'Supply deleted',
        ]);
    }

    public function save()
    {
        $this->supplyForm->submit();
        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Created Successfully!',
            'description' => 'Supply created.',
        ]);

        $this->supplyForm->reset();
    }


    public function addModal() {
        $this->dispatch('addSupply');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.afms.supply-table', [
            'supplies' => Supply::where('name', 'like', "%{$this->search}%")->limit(3)->paginate(5)
        ]);
    }
}
