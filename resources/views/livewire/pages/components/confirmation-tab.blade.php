<div class="bg-white sm:mt-12 sm:px-6">
    <div class="sm:py-6 flex items-center gap-x-1.5">
        <p class="font-medium text-md">Confirmation Tab</p>
        <x-icon name="check" class="w-5 h-5" outline />
    </div>
    <div class="border-b border-gray-200">
        <nav class="flex gap-x-1" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
            <button type="button"
                class="hs-tab-active:bg-white hs-tab-active:border-b-transparent hs-tab-active:text-blue-600 -mb-px py-3 px-4 inline-flex items-center gap-x-2 bg-gray-50 text-sm font-medium text-center border border-gray-200 text-gray-500 rounded-t-lg hover:text-gray-700 focus:outline-hidden focus:text-gray-700 disabled:opacity-50 disabled:pointer-events-none active"
                id="card-type-tab-item-1" aria-selected="true" data-hs-tab="#card-type-tab-preview"
                aria-controls="card-type-tab-preview" role="tab">
                User Request
            </button>
            <button type="button"
                class="hs-tab-active:bg-white hs-tab-active:border-b-transparent hs-tab-active:text-blue-600 -mb-px py-3 px-4 inline-flex items-center gap-x-2 bg-gray-50 text-sm font-medium text-center border border-gray-200 text-gray-500 rounded-t-lg hover:text-gray-700 focus:outline-hidden focus:text-gray-700 disabled:opacity-50 disabled:pointer-events-none active"
                id="card-type-tab-item-1" aria-selected="true" data-hs-tab="#card-type-tab-preview"
                aria-controls="card-type-tab-preview" role="tab">
                Requisition Slip
            </button>
        </nav>
    </div>

    <div class="mt-3">
        <div id="card-type-tab-preview" role="tabpanel" aria-labelledby="card-type-tab-item-1">
            @if ($requisitions)
                @php
                    $groupedRequisitions = $requisitions->groupBy('requisition_id');
                @endphp

                @foreach ($groupedRequisitions as $requisitionId => $items)
                    <div>
                        <div class="w-full flex items-start gap-x-6 py-6">
                            <div class="w-full border rounded p-4">
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

                            <div class="w-full border rounded p-4">
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
                <div class="w-full flex justify-center items-start gap-x-6 py-6">
                    <p class="text-sm text-center text-gray-500 font-medium">No selected Request</p>
                </div>
            @endif
        </div>
    </div>
</div>

