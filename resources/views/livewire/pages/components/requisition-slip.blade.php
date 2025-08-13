<div class="w-full px-12 py-6 sm:flex sm:justify-between sm:items-start gap-x-4">
    @if ($requisition && !$requisition->completed)
        <div class="sm:space-y-3 sm:flex-1">
            <h3 class="font-medium text-lg">Requisition Slip Form</h3>

            <div class="bg-orange-50 p-6 space-y-4 rounded-lg border border-orange-600">
                <div class="space-y-2">
                    <p class="text-sm text-orange-700">
                        Please <span class="font-semibold ">print the requisition slip (RIS)</span> and <span
                            class="font-semibold ">have it signed by the required superiors.</span> Once the RIS
                        is signed, please <span class="font-semibold ">scan the signed document</span> and upload
                        the scanned version here.
                    </p>

                    <p class="text-xs text-gray-500">
                        <strong>Note:</strong> The requisition slip is generated in PDF format. Ensure that the scanned
                        document is clear and legible.
                    </p>
                </div>

                <div>
                    <span class="font-medium text-sm text-gray-800">Steps</span>
                    <ol class="list-decimal text-sm list-inside text-gray-800">
                        <li>Print the <span class="font-semibold">Requisition Slip (RIS).</span></li>
                        <li>Obtain the necessary <span class="font-semibold">signatures from the superiors.</span></li>
                        <li><span class="font-semibold">Scan</span> the signed RIS document.</li>
                        <li>Upload the <span class="font-semibold">scanned copy</span> of the signed RIS here.</li>
                    </ol>
                </div>
            </div>

            <form wire:submit.prevent="save" class="w-full sm:pt-5 space-y-3">
                <label for="file-input" class="sr-only">Choose file</label>

                <input type="file" wire:model="slipForm.requisition_pdf" id="file-input"
                    class="block w-full border border-gray-300 rounded-lg text-xs focus:z-10 focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none 
                file:bg-orange-500 file:border-0 file:me-4 file:text-white file:py-3 file:px-4">
                @error('slipForm.requisition_pdf')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror

                <div class="pt-2">
                    <x-button spinner type="submit" positive label="Submit" />
                </div>
            </form>
        </div>

        @if ($requisition && $requisition->requisition_pdf)
            <div>
                <h4 class="text-xl font-medium text-gray-800">Preview of the Requisition Slip (RIS)</h4>
                <iframe src="{{ Storage::url($requisition->requisition_pdf) }}" width="100%" height="700px"
                    frameborder="0" class="border border-gray-300 mt-4"></iframe>
            </div>
        @endif
    @elseif($requisition && $requisition->completed)
        <iframe src="{{ Storage::url($requisition->requisition_pdf) }}" width="100%" height="700px" frameborder="0">
        </iframe>
    @else
        <p class="text-center font-medium">No generated RIS yet</p>
    @endif
</div>

