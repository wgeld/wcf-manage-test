<div
    x-data="{ isUploading: false, progress: 0 }"
    x-on:livewire-upload-start="isUploading = true"
    x-on:livewire-upload-finish="isUploading = false"
    x-on:livewire-upload-error="isUploading = false"
    x-on:livewire-upload-progress="progress = $event.detail.progress"
>

        <form wire:submit.prevent="import">
            <x-input.filepond wire:model="terminationFiles" multiple/>
        </form>

    <div>

    </div>
</div>


