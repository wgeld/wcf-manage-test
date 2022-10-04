
<div
    x-data="{ isUploading: false, progress: 0 }"
    x-on:livewire-upload-start="isUploading = true"
    x-on:livewire-upload-finish="isUploading = false"
    x-on:livewire-upload-error="isUploading = false"
    x-on:livewire-upload-progress="progress = $event.detail.progress"
>
    <form wire:submit.prevent="import">
        <label
            class="w-64 flex flex-col items-center px-4 py-6 bg-white rounded-md shadow-md tracking-wide uppercase border border-blue cursor-pointer hover:bg-purple-600 hover:text-white text-purple-600 ease-linear transition-all duration-150">
            <x-iconic-upload class="w-12 h-12" />
            <span class="mt-2 text-base leading-normal">Select File(s)</span>
            <input type=file class="hidden" wire:model="files" multiple />
        </label>


        <div class="mt-1" wire:loading.flex wire.target="files">
            <svg class="animate-spin -ml-1 mr-3 h-7 w-7 text-purple-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <div>Processing File(s)</div>
        </div>
        @error('files.*')
        <div>
            <span class="error">{{ $message }}</span>
        </div>
        @enderror
        <div class="pt-2 text-left">
            <x-jet-button>Import</x-jet-button>
        </div>
    </form>

</div>
