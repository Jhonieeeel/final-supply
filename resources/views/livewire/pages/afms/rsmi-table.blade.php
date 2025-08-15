<div class="py-12">
    <x-notifications position="top-end" />
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form wire:submit.prevent="create" class="space-y-4">
            <input type="file" accept="xls" wire:model="rsmiFile" id="file-input"
                class="block w-full border border-gray-300 rounded-lg text-xs focus:z-10 focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none 
                file:bg-orange-500 file:border-0 file:me-4 file:text-white file:py-3 file:px-4">
            @error('rsmiFile')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
            <x-button spinner type="submit" positive label="Test" />
        </form>
    </div>
</div>

