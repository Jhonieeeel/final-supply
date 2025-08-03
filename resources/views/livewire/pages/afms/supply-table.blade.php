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
                                        class="py-1.5 sm:py-2 px-3 ps-9 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
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
                                <x-button @click="$openModal('addSupply')" positive label="Add Supply" />
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
                                                Category</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Unit</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @forelse ($supplies as $supply)
                                            <tr class="hover:bg-gray-200 ">
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                    {{ $supply->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    {{ $supply->category }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm  text-gray-800">
                                                    <x-badge flat color="{{ badgeColor($supply->unit) }}"
                                                        label="{{ $supply->unit }}" />
                                                </td>
                                                <td colspan="2"
                                                    class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium space-x-2">
                                                    <button x-on:click="$openModal('editSupply')"
                                                        wire:click="select({{ $supply->id }})"
                                                        class="cursor-pointer ">
                                                        <x-icon name="pencil"
                                                            class="w-5 h-5 text-blue-500 hover:text-blue-700" />
                                                    </button>
                                                    <button wire:click="delete({{ $supply->id }})"
                                                        class="cursor-pointer">
                                                        <x-icon name="trash"
                                                            class="w-5 h-5 text-red-500 hover:text-red-700" />
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="hover:bg-gray-200">
                                                <td colspan="4"
                                                    class="px-6 py-4 whitespace-nowrap text-gray-500 text-center text-sm font-medium">
                                                    No data yet.
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
    <x-modal-card title="Add Supply" name="addSupply" warning>
        <form>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="cols-pan-1 sm:col-span-2">
                    <x-input wire:model="supplyForm.name" label="Item Description" warning placeholder="Supply name" />
                </div>
                <x-select wire:model="supplyForm.category" warning label="Select Category" placeholder="Select category"
                    :options="['Supplies', 'Nfi', 'Fuel', 'Others']" />

                <x-select wire:model="supplyForm.unit" warning label="Select Unit" placeholder="Select unit"
                    :options="[
                        'pc',
                        'pack',
                        'sachet',
                        'unit',
                        'ream',
                        'box',
                        'set',
                        'meter',
                        'kg',
                        'bag',
                        'case',
                        'kit',
                        'lot',
                        'bucket',
                        'galon',
                        'crate',
                        'bottle',
                    ]" />
            </div>

            <x-slot name="footer" class="flex justify-between gap-x-4">
                <div class="flex gap-x-4 ml-auto">
                    <x-button flat negative label="Cancel" x-on:click="close" />

                    <x-button positive spinner label="Save" wire:click.prevent="save" />
                </div>
            </x-slot>
        </form>
    </x-modal-card>

    <x-modal-card title="Edit Supply" name="editSupply" warning>
        <form>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="cols-pan-1 sm:col-span-2">
                    <x-input wire:model="supplyForm.name" label="Item Description" warning placeholder="Supply name" />
                </div>
                <x-select wire:model="supplyForm.category" warning label="Select Category" placeholder="Select category"
                    :options="['Supplies', 'Nfi', 'Fuel', 'Others']" />

                <x-select wire:model="supplyForm.unit" warning label="Select Unit" placeholder="Select unit"
                    :options="[
                        'pc',
                        'pack',
                        'sachet',
                        'unit',
                        'ream',
                        'box',
                        'set',
                        'meter',
                        'kg',
                        'bag',
                        'case',
                        'kit',
                        'lot',
                        'bucket',
                        'galon',
                        'crate',
                        'bottle',
                    ]" />
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

