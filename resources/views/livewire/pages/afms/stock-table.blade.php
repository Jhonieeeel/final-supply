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
                                    <input type="text" wire:model.live.debounce.300ms='tableSearch'
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
                                <x-button x-on:click="$openModal('addStock')" positive label="Add stocks" />
                            </div>
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Item Description</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Barcode</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Quantity</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Price</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @forelse ($stocks as $stocks)
                                            <tr class="hover:bg-gray-200">
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                    {{ $stocks->supply->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    {{ $stocks->barcode }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    <x-badge flat info label="{{ $stocks->quantity }}" />
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    <x-badge flat warning label="₱ {{ $stocks->price }}" />
                                                </td>
                                                <td colspan="2"
                                                    class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium space-x-2">
                                                    <button x-on:click="$openModal('editStock')"
                                                        wire:click="select({{ $stocks->id }})"
                                                        class="cursor-pointer ">
                                                        <x-icon name="pencil"
                                                            class="w-5 h-5 text-blue-500 hover:text-blue-700" />
                                                    </button>
                                                    <button wire:click="delete({{ $stocks->id }})"
                                                        class="cursor-pointer">
                                                        <x-icon name="trash"
                                                            class="w-5 h-5 text-red-500 hover:text-red-700" />
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="hover:bg-gray-200">
                                                <td colspan="5"
                                                    class="px-6 py-4 whitespace-nowrap text-gray-500 text-center text-sm font-medium">
                                                    No stock yet.
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
    <x-modal-card title="Add Stock" name="addStock" warning>
        <form>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-input wire:model="stockForm.barcode" label="Barcode" warning placeholder="Input barcode" />
                <x-select wire:model="stockForm.supply_id" warning label="Search a Supply"
                    placeholder="Select some supply" :async-data="route('api.supplies.index')" option-label="name" option-value="id" />
                <x-number warning wire:model="stockForm.quantity" label="Quantity" placeholder="0" />
                <x-number wire:model="stockForm.price" min="1" max="99999999" step="0.2" label="Supply Price"
                    placeholder="0" />
            </div>

            <x-slot name="footer" class="flex justify-between gap-x-4">
                <div class="flex gap-x-4 ml-auto">
                    <x-button flat negative label="Cancel" x-on:click="close" />

                    <x-button positive spinner label="Save" wire:click.prevent="save" />
                </div>
            </x-slot>
        </form>
    </x-modal-card>

    <x-modal-card title="Edit Stock" name="editStock" warning>
        <form>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-input wire:model="stockForm.barcode" label="Barcode" warning placeholder="Input barcode" />
                <x-select wire:model="stockForm.supply_id" warning label="Search a Supply"
                    placeholder="Select some supply" :options="$this->getSupplies()" option-label="name" option-value="id" />
                <x-number warning wire:model="stockForm.quantity" label="Quantity" placeholder="0" />
                <x-number wire:model="stockForm.price" min="1" max="9999" step="0.2"
                    label="Supply Price" placeholder="0" />
            </div>

            <x-slot name="footer" class="flex justify-between gap-x-4">
                <div class="flex gap-x-4 ml-auto">
                    <x-button flat negative label="Cancel" x-on:click="close" />

                    <x-button positive spinner label="Save" wire:click.prevent="edit" />
                </div>
            </x-slot>
        </form>
    </x-modal-card>
</div>

