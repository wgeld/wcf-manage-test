<div class="flex space-x-1 justify-around" wire:key="downgrade-upgrade-suspend-resume-{{ $ontObjectName }}">

    <div x-data="{ downgradeTooltip: 'Downgrade Service to Phone Only' }">
        <button x-tooltip="downgradeTooltip"
                wire:click="downgradeServicePhoneOnly('{{ $ontObjectName }}')"
                class="p-1 text-yellow-400 hover:bg-yellow-400 hover:text-white rounded">
            <x-far-arrow-alt-circle-down class="w-5 h-5" fill="currentColor"/>
        </button>
    </div>

    <div x-data="{ upgradeGigabitTooltip: 'Upgrade Service to Gigabit' }">
        <button x-tooltip="upgradeGigabitTooltip"
                wire:click="upgradeServiceGigabit('{{ $ontObjectName }}')"
                class="p-1 text-purple-400 hover:bg-purple-400 hover:text-white rounded">
            <x-far-arrow-alt-circle-up class="w-5 h-5" fill="currentColor"/>
        </button>
    </div>

    <div x-data="{ upgrade25mbTooltip: 'Upgrade Service to 25mb' }">
        <button x-tooltip="upgrade25mbTooltip"
                wire:click="upgradeService25mb('{{ $ontObjectName }}')"
                class="p-1 text-blue-400 hover:bg-purple-400 hover:text-white rounded">
            <x-far-arrow-alt-circle-right class="w-5 h-5" fill="currentColor"/>
        </button>
    </div>

    <div x-data="{ suspendTooltip: 'Suspend Service' }">
        <button x-tooltip="suspendTooltip"
                wire:click="suspend('{{ $ontObjectName }}')"
                class="p-1 text-red-400 hover:bg-red-400 hover:text-white rounded">
            <x-far-stop-circle class="w-5 h-5" fill="currentColor"/>
        </button>
    </div>

    <div x-data="{ resumeTooltip: 'Resume Service' }">
        <button x-tooltip="resumeTooltip"
                wire:click="resume('{{ $ontObjectName }}')"
                class="p-1 text-green-600 hover:bg-green-600 hover:text-white rounded">
            <x-far-play-circle class="w-5 h-5" fill="currentColor"/>
        </button>
    </div>

</div>
