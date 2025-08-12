<div class="w-full px-24 py-12 sm:flex sm:justify-start sm:items-start gap-x-4">
    @if ($pdf)
        <div class="sm:space-y-3 sm:flex-1">
            <h3 class="font-medium">
                Requisition Slip Form
            </h3>
            <form wire:submit.prevent="update" class="w-full space-y-1.5">
                <label for="file-input" class="sr-only">Choose file</label>
                <input type="file" wire:model="slipForm.requisition_pdf" id="file-input"
                    class="block w-full border border-gray-200  rounded-lg text-sm focus:z-10 focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none
                        file:bg-orange-50 file:border-0
                        file:me-4
                        file:py-3 file:px-4
                    ">
                @error('slipForm.requisition_pdf')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                <div class="pt-2">
                    <x-button spinner type="submit" positive label="Submit" />
                </div>
            </form>
        </div>
        <div>

            <iframe src="{{ Storage::url($pdf->requisition_pdf) }}" width="100%" height="700px" frameborder="0">
            </iframe>
        </div>
    @else
        <p class="text-center font-medium">No generated RIS yet</p>
    @endif
</div>

