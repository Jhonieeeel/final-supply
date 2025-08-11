<div class="bg-white sm:mt-12 sm:px-6 py-5 shadow rounded">

    @if ($requisitions)
        <div class="sm:py-6 flex items-center gap-x-2">
            <h3 class="text-lg font-semibold text-gray-800">Requisition Confirmation</h3>
            <x-icon name="check-circle" class="w-5 h-5 text-green-500" solid />
        </div>
        <div class="border-b border-gray-300">
            <nav class="flex gap-x-1" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
                <button type="button" wire:click="changeTab('tab1')"
                    class="-mb-px py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium text-center border border-gray-300 rounded-t-lg disabled:opacity-50 disabled:pointer-events-none
        {{ $activeTab === 'tab1'
            ? 'bg-white border-b-transparent text-gray-700 border-gray-300  hover:text-gray-600'
            : 'bg-gray-50 text-gray-500  border-gray-300 hover:text-gray-700' }}"
                    id="tab1" aria-selected="{{ $activeTab === 'tab1' ? 'true' : 'false' }}">
                    Requisition
                </button>

                <button type="button" wire:click="changeTab('tab2')"
                    class="-mb-px py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium text-center border rounded-t-lg disabled:opacity-50 disabled:pointer-events-none
        {{ $activeTab === 'tab2'
            ? 'bg-white border-b-transparent text-gray-700 border-gray-300 hover:text-gray-600'
            : 'bg-gray-50 text-gray-500 border-gray-300 hover:text-gray-700' }}"
                    id="tab2" aria-selected="{{ $activeTab === 'tab2' ? 'true' : 'false' }}">
                    Requisition PDF
                </button>
            </nav>
        </div>
    @else
        <div class="flex flex-col items-center gap-3 sm:py-6">
            <p class="text-center"><x-icon name="arrow-up" class="w-8 h-8" solid /></p>
            <p class="text-center text-sm text-gray-700">Select to View Requisition item</p>
        </div>
    @endif

    <div class="border border-gray-300  border-t-transparent {{ $activeTab ? 'border-b' : 'border-b-0 ' }} ">
        <div id="card-type-tab-preview" role="tabpanel" aria-labelledby="card-type-tab-item-1">
            @if ($activeTab === 'tab1')
                @if ($requisitions)
                    @php
                        $groupedRequisitions = $requisitions->groupBy('requisition_id');
                    @endphp

                    @foreach ($groupedRequisitions as $requisitionId => $items)
                        <div class="w-full sm:px-2 sm:py-4 rounded">
                            <div class="p-4">
                                <div class="w-full space-y-5">
                                    <div class="sm:flex gap-x-12 items-center">
                                        <x-badge md icon="shopping-cart" positive flat label="Requisition Details" />
                                        <small class="text-gray-500 italic">Feature RIS not added yet</small>
                                        @hasanyrole(['super-admin', 'admin'])
                                            <div class="ml-auto">
                                                <x-button :disabled="!(
                                                    $items->first()->requisition->approved_by &&
                                                    $items->first()->requisition->issued_by &&
                                                    $items->first()->requisition->received_by
                                                )" spinner wire:click="generateWord" icon="printer"
                                                    positive label=" Generate RIS" />
                                            </div>
                                        @endhasanyrole
                                    </div>
                                    <div class="sm:flex sm:justify-between sm:items-start">
                                        {{-- requested by --}}
                                        <div class="my-4 space-y-2">
                                            <small class="text-gray-700 font-medium">Requested By</small>

                                            <button wire:click="confirm({{ $items->first()->requisition->id }})"
                                                x-on:click="$openModal('selectRequester')" class="cursor-pointer">
                                                <x-icon name="pencil-square"
                                                    class="inline-block w-5 h-5 hover:text-gray-600 text-gray-500"
                                                    solid />
                                            </button>
                                            <span class="block text-start">
                                                <x-badge flat info
                                                    label="{{ $items->first()->requisition->requested_by ? $items->first()->requisition->requestedBy->name : $items->first()->requisition->owner->name }} (default)" />
                                            </span>
                                        </div>
                                        {{-- approved by --}}
                                        <div class="my-4 space-y-2">
                                            <small class="text-gray-700 font-medium">Approved By</small>
                                            @if (auth()->user()->hasAnyRole(['super-admin', 'admin']))
                                                <button wire:click="confirm({{ $items->first()->requisition->id }})"
                                                    x-on:click="$openModal('selectApprover')" class="cursor-pointer">
                                                    <x-icon name="pencil-square"
                                                        class="inline-block w-5 h-5 hover:text-gray-600 text-gray-500"
                                                        solid />
                                                </button>
                                            @endif
                                            <span class="block text-start">
                                                <x-badge flat :color="$items->first()->requisition->approved_by
                                                    ? 'positive'
                                                    : 'negative'"
                                                    label="{{ $items->first()->requisition->approved_by ? $items->first()->requisition->approvedBy->name : 'pending' }}" />
                                            </span>
                                        </div>
                                        {{-- issued by --}}
                                        <div class="my-4 space-y-2">
                                            <small class="text-gray-700 font-medium">Issued By</small>
                                            @if (auth()->user()->hasAnyRole(['super-admin', 'admin']))
                                                <button wire:click="confirm({{ $items->first()->requisition_id }})"
                                                    x-on:click="$openModal('selectIssuer')" class="cursor-pointer">
                                                    <x-icon name="pencil-square"
                                                        class="inline-block w-5 h-5 hover:text-gray-600 text-gray-500"
                                                        solid />
                                                </button>
                                            @endif
                                            <span class="block text-start">
                                                <x-badge flat :color="$items->first()->requisition->issued_by
                                                    ? 'positive'
                                                    : 'negative'"
                                                    label="{{ $items->first()->requisition->issued_by ? $items->first()->requisition->issuedBy->name : 'pending' }}" />
                                            </span>
                                        </div>
                                        {{-- received by --}}
                                        <div class="my-4 space-y-2">
                                            <small class="text-gray-700 font-medium">Received By</small>
                                            <button wire:click="confirm({{ $items->first()->requisition_id }})"
                                                x-on:click="$openModal('selectReceiver')" class="cursor-pointer">
                                                <x-icon name="pencil-square"
                                                    class="inline-block w-5 h-5 hover:text-gray-600 text-gray-500"
                                                    solid />
                                            </button>
                                            <span class="block text-start">
                                                <x-badge flat :color="$items->first()->requisition->received_by
                                                    ? 'positive'
                                                    : 'negative'"
                                                    label="{{ $items->first()->requisition->received_by ? $items->first()->requisition->receivedBy->name : 'pending' }}" />
                                            </span>
                                        </div>
                                    </div>
                                    <table class="w-full border border-gray-300 rounded">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th scope="col"
                                                    class="px-4 py-3 text-xs text-start text-gray-600 uppercase font-medium">
                                                    #
                                                </th>
                                                <th scope="col"
                                                    class="px-4 py-3 text-xs text-start text-gray-600 uppercase font-medium">
                                                    Item Description
                                                </th>
                                                <th scope="col"
                                                    class="px-4 py-3 text-xs text-start text-gray-600 uppercase font-medium">
                                                    Stock Availability
                                                </th>
                                                <th scope="col"
                                                    class="px-4 py-3 text-xs text-start text-gray-600 uppercase font-medium">
                                                    Requested Quantity
                                                </th>
                                                @if (auth()->id() === $items->first()->requisition->owner_id ||
                                                        auth()->user()->hasAnyRole(['admin', 'super-admin']))
                                                    <th spinner="delete" scope="col"
                                                        class="px-4 py-3 text-xs text-start text-gray-600 uppercase font-medium">
                                                        Action
                                                    </th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $item)
                                                <tr>
                                                    <td class="px-4 py-3 text-xs font-medium">
                                                        <x-checkbox
                                                            wire:model.live="confirmedItems.{{ $item->id }}"
                                                            value="true" />
                                                    </td>
                                                    <td class="px-4 py-3 text-xs  font-medium">
                                                        {{ $item->stock->supply->name }}</td>
                                                    <td class="px-4 py-3 text-xs text-start font-medium">
                                                        <x-badge flat info label="{{ $item->stock->quantity }}" />
                                                    </td>
                                                    <td class="px-4 py-3 text-xs text-start font-medium">
                                                        <x-badge flat positive label="{{ $item->quantity }}" />
                                                    </td>
                                                    @if (auth()->id() === $item->requisition->owner_id ||
                                                            auth()->user()->hasAnyRole(['admin', 'super-admin']))
                                                        <td colspan="2"
                                                            class="px-4 py-3 text-xs text-start font-medium">

                                                            <x-button x-on:click="$openModal('editRequisition')"
                                                                wire:click="select({{ $item->id }})" 2xs info
                                                                label="Edit" />

                                                            <form wire:submit.prevent="delete({{ $item->id }})"
                                                                class="inline-block">
                                                                <x-button type="submit" 2xs negative
                                                                    label="Delete" />
                                                            </form>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    @endforeach

                @endif
            @elseif($activeTab === 'tab2')
                <div class="w-full flex justify-center items-start gap-x-6 py-6">
                    @livewire('pages.components.requisition-slip')
                </div>
            @endif

        </div>
    </div>
    {{-- edit requisition --}}
    <x-modal-card class="max-w-sm" title="Edit Requisition" name="editRequisition" warning>
        <form>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <x-number warning wire:model="reqForm.quantity" label="Request Quantity" placeholder="0" />
            </div>

            <x-slot name="footer" class="flex justify-between gap-x-4">
                <div class="flex gap-x-4 ml-auto">
                    <x-button flat negative label="Cancel" x-on:click="close" />

                    <x-button positive spinner label="Save" wire:click.prevent="save" />
                </div>
            </x-slot>
        </form>
    </x-modal-card>

    {{-- requestby --}}
    <x-modal-card class="max-w-sm" title="Requested By" name="selectRequester" warning>
        <form>
            <x-select wire:model="reqForm.requested_by" label="Select User"
                placeholder="Select a user for Requested By" :options="$this->getUsers()" option-label="name" option-value="id"
                searchable />

            <x-slot name="footer" class="flex justify-between gap-x-4">
                <div class="flex gap-x-4 ml-auto">
                    <x-button flat negative label="Cancel" x-on:click="close" />
                    <x-button wire:click.prevent="updateConfirm" positive spinner label="Save" />
                </div>
            </x-slot>
        </form>
    </x-modal-card>

    {{-- requestby --}}
    <x-modal-card class="max-w-sm" title="Issued By" name="selectIssuer" warning>
        <form>
            <x-select wire:model="reqForm.issued_by" label="Select User" placeholder="Select a user for Issued By"
                :options="$this->getUsers()" option-label="name" option-value="id" searchable />

            <x-slot name="footer" class="flex justify-between gap-x-4">
                <div class="flex gap-x-4 ml-auto">
                    <x-button flat negative label="Cancel" x-on:click="close" />
                    <x-button wire:click.prevent="updateConfirm" positive spinner label="Save" />
                </div>
            </x-slot>
        </form>
    </x-modal-card>

    {{-- approveby --}}
    <x-modal-card class="max-w-sm" title="Approved By" name="selectApprover" warning>
        <form>
            <x-select wire:model="reqForm.approved_by" warning label="Search a Stock"
                placeholder="Select a user for Approved By" :options="$this->getUsers()" option-label="name" option-value="id"
                searchable />

            <x-slot name="footer" class="flex justify-between gap-x-4">
                <div class="flex gap-x-4 ml-auto">
                    <x-button flat negative label="Cancel" x-on:click="close" />
                    <x-button wire:click.prevent="updateConfirm" positive spinner label="Save" />
                </div>
            </x-slot>
        </form>
    </x-modal-card>

    {{-- issuedby --}}
    <x-modal-card class="max-w-sm" title="Issued By" name="selectApprover" warning>
        <form>
            <x-select wire:model="reqForm.issued_by" warning label="Search a Stock"
                placeholder="Select a user for Issued By" :options="$this->getUsers()" option-label="name" option-value="id"
                searchable />

            <x-slot name="footer" class="flex justify-between gap-x-4">
                <div class="flex gap-x-4 ml-auto">
                    <x-button flat negative label="Cancel" x-on:click="close" />
                    <x-button wire:click.prevent="updateConfirm" positive spinner label="Save" />
                </div>
            </x-slot>
        </form>
    </x-modal-card>

    {{-- receivedby --}}
    <x-modal-card class="max-w-sm" title="Received By" name="selectReceiver" warning>
        <form>
            <x-select wire:model="reqForm.received_by" warning label="Search a Stock"
                placeholder="Select a user for Received By" :options="$this->getUsers()" option-label="name" option-value="id"
                searchable />

            <x-slot name="footer" class="flex justify-between gap-x-4">
                <div class="flex gap-x-4 ml-auto">
                    <x-button flat negative label="Cancel" x-on:click="close" />
                    <x-button wire:click.prevent="updateConfirm" positive spinner label="Save" />
                </div>
            </x-slot>
        </form>
    </x-modal-card>
</div>

