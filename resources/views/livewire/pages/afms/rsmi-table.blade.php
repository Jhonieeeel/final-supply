<div class="py-12">
    <x-notifications position="top-end" />
    <div class="max-w-7xl bg-white  mx-auto shadow rounded-sm sm:px-6 lg:px-8">
        <div class="p-4">
            <form wire:submit.prevent="create" class="space-y-2 max-w-sm">
                <x-datetime-picker wire:model.live="inputtedDate" label="Appointment Date" placeholder="Reporting Date"
                    {{-- parse-format="DD-MM-YYYY HH:mm"  --}} />
                <x-button type="submit" positive label="Positive" />
            </form>
        </div>
    </div>
</div>

