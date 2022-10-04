<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-tabs.tab-container active="Students">

                    <x-tabs.tab name="Students">
                        <h1>Stuff</h1>
                    </x-tabs.tab>

                    <x-tabs.tab name="Notes">
                        <h1>Note stuff</h1>
                    </x-tabs.tab>

                    <x-tabs.tab name="Finance">
                        <h1>Finance stuff</h1>
                    </x-tabs.tab>

                </x-tabs.tab-container>

            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @livewire('tables.account')
            </div>
        </div>
    </div>
</x-app-layout>
