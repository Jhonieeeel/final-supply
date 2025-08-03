<div class="bg-white sm:mt-12 sm:px-6">
    <div class="sm:py-6 flex items-center gap-x-1.5">
        <p class="font-medium text-md">Confirmation Tab</p>
        <x-icon name="check" class="w-5 h-5" outline />
    </div>
    @if ($requisitions)
        <div class="border-b border-gray-200">
            <nav class="flex gap-x-1" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
                <button type="button" wire:click="$set('activeTab', 'tab1')"
                    class="-mb-px py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium text-center border rounded-t-lg disabled:opacity-50 disabled:pointer-events-none
        {{ $activeTab === 'tab1'
            ? 'bg-white border-b-transparent text-gray-600 border-gray-200  hover:text-gray-600'
            : 'bg-gray-50 text-gray-500 border-gray-200 hover:text-gray-700' }}"
                    id="tab1" aria-selected="{{ $activeTab === 'tab1' ? 'true' : 'false' }}">
                    User Request
                </button>

                <button type="button" wire:click="$set('activeTab', 'tab2')"
                    class="-mb-px py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium text-center border rounded-t-lg disabled:opacity-50 disabled:pointer-events-none
        {{ $activeTab === 'tab2'
            ? 'bg-white border-b-transparent text-gray-600 border-gray-200 hover:text-gray-600'
            : 'bg-gray-50 text-gray-500 border-gray-200 hover:text-gray-700' }}"
                    id="tab2" aria-selected="{{ $activeTab === 'tab2' ? 'true' : 'false' }}">
                    Requisition Slip
                </button>
            </nav>
        </div>
    @endif

    <div class="border  border-t-transparent {{ $activeTab ? 'border-b' : 'border-b-0' }}">
        <div id="card-type-tab-preview" role="tabpanel" aria-labelledby="card-type-tab-item-1">
            @if ($activeTab === 'tab1')
                @if ($requisitions)
                    @php
                        $groupedRequisitions = $requisitions->groupBy('requisition_id');
                    @endphp

                    @foreach ($groupedRequisitions as $requisitionId => $items)
                        <div>
                            <div class="w-full  flex items-start gap-x-6 sm:px-2 sm:py-4">
                                <div class="w-full rounded p-4 border">
                                    <div class="flex items-center justify-between shadow">
                                        <h3 class="text-sm font-medium">Requested Items</h3>
                                        <h3 class="text-sm font-medium">Requested Quantity</h3>
                                    </div>
                                    <hr>

                                    <div class="pt-2.5">
                                        <ul class="list-disc list-inside text-gray-800 space-y-1.5">
                                            @foreach ($items as $item)
                                                <li class="flex items-center justify-between">
                                                    <span class="text-sm">
                                                        {{ $item->stock->supply->name }}
                                                    </span>
                                                    <x-badge flat amber label="{{ $item->quantity }}" />
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                <div class="w-full rounded p-4 border">
                                    <div class="flex items-center justify-between shadow">
                                        <h3 class="text-sm font-medium">Requested By</h3>
                                        <h3 class="text-sm font-medium">Approved By</h3>
                                        <h3 class="text-sm font-medium">Issued By</h3>
                                        <h3 class="text-sm font-medium">Received By</h3>
                                    </div>
                                    <hr>
                                    <div class="pt-2">
                                        <ul
                                            class="list-disc list-inside text-gray-800 space-y-1.5 flex items-center justify-between">
                                            <li class="list-none">
                                                <span class="text-sm">
                                                    {{ $items->first()->requisition->requestedBy->name }}
                                                </span>
                                            </li>
                                            <li class="list-none">
                                                <span
                                                    class="text-sm {{ $items->first()->requisition->approved_by ? 'text-gray-700' : 'text-gray-400' }}">
                                                    {{ optional($items->first()->requisition->approvedBy)->name ?? 'No user' }}
                                                </span>
                                            </li>
                                            <li class="list-none">
                                                <span
                                                    class="text-sm {{ $items->first()->requisition->issued_by ? 'text-gray-700' : 'text-gray-400' }}">
                                                    {{ optional($items->first()->requisition->issuedBy)->name ?? 'No user' }}
                                                </span>
                                            </li>
                                            <li class="list-none">
                                                <span
                                                    class="text-sm {{ $items->first()->requisition->received_by ? 'text-gray-700' : 'text-gray-400' }}">
                                                    {{ optional($items->first()->requisition->receivedBy)->name ?? 'No user' }}
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="w-full  flex justify-center items-start gap-x-6">
                        <p class="text-sm text-center text-gray-500 font-medium">No selected Request</p>
                    </div>
                @endif
            @elseif($activeTab === 'tab2')
                <div class="w-full flex justify-center items-start gap-x-6 py-6">
                    <p>Requisition Slip</p>
                </div>
            @endif
        </div>
    </div>
    <div class="pt-5"></div>
</div>

