<div class="bg-white sm:mt-12 sm:px-6">
    <div class="sm:py-6 flex items-center gap-x-4">
        <p>Confirmation Tab</p>
        <p class="italic text-gray-400 text-sm">Requisition tab not added.</p>
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
            <div>
                @if ($requisition)
                    <div class="py-6 max-w-sm">
                        <x-badge icon-size="md" lg icon="shopping-cart" positive label="Requested Item(s)" />
                        <ul class="list-disc list-inside text-gray-800 pt-3 space-y-2.5">
                            @foreach ($requisition as $item)
                                <li class="w-full flex justify-between items-center">
                                    <span class="font-medium text-gray-600">{{ $item->stock->supply->name }}</span>
                                    <span class="text-gray-400 text-sm">{{ $item->quantity }} pc(s)</span>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                @else
                    <p>No Selected Requisition yet</p>
                @endif
            </div>
        </div>
    </div>
</div>

