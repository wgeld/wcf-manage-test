<div
    wire:ignore
    x-data
    x-init="
        FilePond.setOptions({
            allowMultiple: {{ isset($attributes['multiple']) ? 'true' : 'false' }},
            server: {
            process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                @this.upload({{ $attributes['wire:model'] }}, file, load, error, progress)
                },
                revert: (filename, load) => {
                   @this.removeUpload({{ $attributes['wire:model'] }}, filename, load)
                },
            },
        });
        FilePond.create($refs.input);
    "
>

    <input type="file" x-ref="input">
</div>

@push('styles')
    @once
        <link rel="stylesheet" href="https://unpkg.com/filepond@^4/dist/filepond.css"/>
    @endonce
@endpush


@push('scripts')
    @once
        <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    @endonce
@endpush
