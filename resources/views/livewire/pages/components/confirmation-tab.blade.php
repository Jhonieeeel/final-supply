<div class="bg-white sm:mt-12 sm:px-6 shadow rounded">

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
            ? 'bg-white border-b-transparent text-gray-600 border-gray-300  hover:text-gray-600'
            : 'bg-gray-50 text-gray-500  border-gray-300 hover:text-gray-700' }}"
                    id="tab1" aria-selected="{{ $activeTab === 'tab1' ? 'true' : 'false' }}">
                    Requisition
                </button>
                @if ($requisitions->first()->requisition->status)
                    <button type="button" wire:click="changeTab('tab2')"
                        class="-mb-px py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium text-center border rounded-t-lg disabled:opacity-50 disabled:pointer-events-none
        {{ $activeTab === 'tab2'
            ? 'bg-white border-b-transparent text-gray-600 border-gray-300 hover:text-gray-600'
            : 'bg-gray-50 text-gray-500 border-gray-300 hover:text-gray-700' }}"
                        id="tab2" aria-selected="{{ $activeTab === 'tab2' ? 'true' : 'false' }}">
                        Requisition PDF
                    </button>
                @endif
            </nav>
        </div>
    @else
        <div class="flex flex-col items-center gap-3 sm:py-6">
            <p class="text-center"><x-icon name="arrow-up" class="w-8 h-8" solid /></p>
            <p class="text-center text-sm text-gray-700">Select a Requisition item</p>
        </div>
    @endif

    <div class="border border-gray-300  border-t-transparent {{ $activeTab ? 'border-b' : 'border-b-0' }}">
        <div id="card-type-tab-preview" role="tabpanel" aria-labelledby="card-type-tab-item-1">
            @if ($activeTab === 'tab1')
                @if ($requisitions)
                    @php
                        $groupedRequisitions = $requisitions->groupBy('requisition_id');
                    @endphp

                    @foreach ($groupedRequisitions as $requisitionId => $items)
                        <div class="w-full sm:px-2 sm:py-4 rounded">
                            <div class="flex flex-col">
                                <div>

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
    <div class="pt-5"></div>
</div>

