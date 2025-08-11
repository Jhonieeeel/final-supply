<div class="py-12">
    <x-notifications position="top-end" />
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xs sm:rounded-lg">
            <div class="flex flex-col">
                <div class="-m-1.5 overflow-x-auto">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="w-full border border-gray-200 rounded-lg divide-y divide-gray-200">
                            <div class="py-3 px-4 sm:flex justify-between items-center w-full">
                                <div class="relative">
                                    <label class="sr-only">Search</label>
                                    <input type="text" name="hs-table-with-pagination-search"
                                        id="hs-table-with-pagination-search"
                                        class="py-1.5 sm:py-2 px-3 ps-9 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:z-10 focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none"
                                        placeholder="Search for items">
                                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                                        <svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <path d="m21 21-4.3-4.3"></path>
                                        </svg>
                                    </div>
                                </div>
                                <x-button x-on:click="$openModal('addRequisition')" positive label="Add Requisition" />
                            </div>
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Owner</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                No. Requested Items</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Request Status</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @forelse ($requisitions as $requisition)
                                            <tr class="hover:bg-gray-50">
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                    {{ $requisition->owner->name }}</td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                    <x-badge flat amber label="{{ $requisition->items->count() }}" />
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                    <x-badge flat :color="$requisition->completed ? 'info' : 'negative'"
                                                        label="{{ $requisition->completed ? 'Confirmed' : 'Pending' }}" />
                                                </td>
                                                <td
                                                    class="px-6 text-end py-4 whitespace-nowrap text-sm font-medium text-blue-800">
                                                    <x-button wire:click='select({{ $requisition->owner_id }})' 2xs
                                                        positive outline label="View" icon="check" />
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="hover:bg-gray-200">
                                                <td colspan="5"
                                                    class="px-6 py-4 whitespace-nowrap text-gray-500 text-center text-sm font-medium">
                                                    No requisitions yet.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @livewire('pages.components.confirmation-tab')
    </div>

    <x-modal-card title="Requisition" name="addRequisition" warning>

        <form>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-select wire:model="reqForm.stock_id" warning label="Search a Stock"
                    placeholder="Select item to request" :options="$this->getSupplies()" option-label="name" option-value="id"
                    option-description="quantity" searchable />
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
</div>

