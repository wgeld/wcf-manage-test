<div class="flex space-x-1 justify-around" wire:init="ontDescriptions('{{ $ontObjectName }}')">

    <div
        x-data="{
                init() {
                    console.log($wire.__instance),
                    console.log($wire.get('$ontObjectName'))
                    },
                    hasPhone: $wire.get('$ontObjectName'),
                    ontObject: $row
            }"
        x-init="$wire.get('hasPhone')"
    >
        <div x-text="hasPhone"></div>
    </div>
    <div wire:model="ontDescription"
         class="p-1 text-yellow-400 hover:bg-yellow-400 hover:text-white rounded">
        {{ $ontDescription }}
    </div>
</div>
