<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Account') }}
        </h2>
    </x-slot>
    <div class="p-4">
        <div class="flex flex-col md:flex-row space-x-1">
            <div>
                <x-cards.base-card>
                    <x-slot name="cardHeaderTitle">
                        {{ __('Account Information') }}
                    </x-slot>
                    <x-slot name="cardHeaderDetail">
                        {{ __('Serviceable Address and customer information.') }}
                    </x-slot>
                    <x-slot name="cardHeaderLinks">
                        <a href="" target="_blank" id="deviceManagerSubscriber">
                            <x-far-user class="inline w-5 h-5" fill="currentColor"/>
                            {{ __('Device Manager') }}
                        </a>
                    </x-slot>
                    <table class="table-auto bg-white text-black">
                        <tbody>
                        <tr class="sm:grid sm:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                            <td>Number:</td>
                            <td>811565-400005</td>
                        </tr>
                        <tr class="sm:grid sm:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                            <td>Name:</td>
                            <td>LISAMARIE D'ORAZIO</td>
                        </tr>
                        <tr class="sm:grid sm:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                            <td>Email:</td>
                            <td>lisadtheriault@gmail.com</td>
                        </tr>
                        <tr class="sm:grid sm:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                            <td>Phone:</td>
                            <td>(413) 269-7602</td>
                        </tr>
                        <tr class="sm:grid sm:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                            <td>FSA:</td>
                            <td>01</td>
                        </tr>
                        <tr class="sm:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                            <td>Address:</td>
                            <td>490 PINE RD</td>
                        </tr>
                        <tr class="sm:grid sm:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                            <td>City:</td>
                            <td>OTIS</td>
                        </tr>
                        </tbody>
                    </table>
                </x-cards.base-card>
            </div>
            <div>
                <x-tabs.tab-container active="{{ __('Equipment') }}">

                    <x-tabs.tab name="{{ __('Equipment') }}">
                        <table class="table-fixed bg-white text-black">
                            <tbody>
                            <tr>
                                <td class="px-2 py-1 whitespace-nowrap">F-OLT:</td>
                                <td class="px-2 py-1 whitespace-nowrap">OT01.01.02.05</td>
                                <td class="px-2 py-1 whitespace-nowrap">
                                    <a href=""
                                       class="p-1 pl-2 pr-2 bg-green-500 text-gray-100 text-sm rounded-lg focus:border-4 border-green-300">View</a>
                                </td>
                                <td class="px-2 py-1 whitespace-nowrap">
                                    <a href=""
                                       class="p-1 pl-2 pr-2 bg-red-500 text-gray-100 text-sm rounded-lg focus:border-4 border-red-300">Remove</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-1 whitespace-nowrap">F-FDH:</td>
                                <td class="px-2 py-1 whitespace-nowrap">OT-F03.1A.05</td>
                                <td class="px-2 py-1 whitespace-nowrap">
                                    <a href=""
                                       class="p-1 pl-2 pr-2 bg-green-500 text-gray-100 text-sm rounded-lg focus:border-4 border-green-300">View</a>
                                </td>
                                <td class="px-2 py-1 whitespace-nowrap">
                                    <a href=""
                                       class="p-1 pl-2 pr-2 bg-red-500 text-gray-100 text-sm rounded-lg focus:border-4 border-red-300">Remove</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-1 whitespace-nowrap">F-ROUTER:</td>
                                <td class="px-2 py-1 whitespace-nowrap">3C90668B0E40</td>
                                <td class="px-2 py-1 whitespace-nowrap">
                                    <a href=""
                                       class="p-1 pl-2 pr-2 bg-green-500 text-gray-100 text-sm rounded-lg focus:border-4 border-green-300">View</a>
                                </td>
                                <td class="px-2 py-1 whitespace-nowrap">
                                    <a href=""
                                       class="p-1 pl-2 pr-2 bg-red-500 text-gray-100 text-sm rounded-lg focus:border-4 border-red-300">Remove</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-1 whitespace-nowrap">F-ONT:</td>
                                <td class="px-2 py-1 whitespace-nowrap">ALCLB150BB8E</td>
                                <td class="px-2 py-1 whitespace-nowrap">
                                    <a href=""
                                       class="p-1 pl-2 pr-2 bg-green-500 text-gray-100 text-sm rounded-lg focus:border-4 border-green-300">View</a>
                                </td>
                                <td class="px-2 py-1 whitespace-nowrap">
                                    <a href=""
                                       class="p-1 pl-2 pr-2 bg-red-500 text-gray-100 text-sm rounded-lg focus:border-4 border-red-300">Remove</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-1 whitespace-nowrap">F-TELO:</td>
                                <td class="px-2 py-1 whitespace-nowrap">MS1804K12811</td>
                                <td class="px-2 py-1 whitespace-nowrap">
                                    <a href=""
                                       class="p-1 pl-2 pr-2 bg-green-500 text-gray-100 text-sm rounded-lg focus:border-4 border-green-300">View</a>
                                </td>
                                <td class="px-2 py-1 whitespace-nowrap">
                                    <a href=""
                                       class="p-1 pl-2 pr-2 bg-red-500 text-gray-100 text-sm rounded-lg focus:border-4 border-red-300">Remove</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-1 whitespace-nowrap">F-LINX:</td>
                                <td class="px-2 py-1 whitespace-nowrap">HS1720SB3061</td>
                                <td class="px-2 py-1 whitespace-nowrap">
                                    <a href=""
                                       class="p-1 pl-2 pr-2 bg-green-500 text-gray-100 text-sm rounded-lg focus:border-4 border-green-300">View</a>
                                </td>
                                <td class="px-2 py-1 whitespace-nowrap">
                                    <a href=""
                                       class="p-1 pl-2 pr-2 bg-red-500 text-gray-100 text-sm rounded-lg focus:border-4 border-red-300">Remove</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </x-tabs.tab>

                    <x-tabs.tab name="{{ __('Optical') }}">
                        <table class="table-fixed bg-white text-black">
                            <tbody>
                            <tr>
                                <td class="px-2 py-1 whitespace-nowrap">Last Change Date</td>
                                <td class="px-2 py-1 whitespace-nowrap">2021-07-17 18:32:57</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-1 whitespace-nowrap">RX</td>
                                <td class="px-2 py-1 whitespace-nowrap">-8.088 dBm</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-1 whitespace-nowrap">TX</td>
                                <td class="px-2 py-1 whitespace-nowrap">1.924 dBm</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-1 whitespace-nowrap">Reporting Status</td>
                                <td class="px-2 py-1 whitespace-nowrap">[none]</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-1 whitespace-nowrap">Bias</td>
                                <td class="px-2 py-1 whitespace-nowrap">8650 uA</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-1 whitespace-nowrap">Temperature</td>
                                <td class="px-2 py-1 whitespace-nowrap">48.5 C</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-1 whitespace-nowrap">Voltage</td>
                                <td class="px-2 py-1 whitespace-nowrap">3.28 V</td>
                            </tr>
                            </tbody>
                        </table>
                    </x-tabs.tab>

                    <x-tabs.tab name="{{ __('ONT Template') }}">
                        <table class="table-fixed bg-white text-black">
                            <tbody>
                            <tr>
                                <td class="px-2 py-1 whitespace-nowrap">AMS Server</td>
                                <td class="px-2 py-1 whitespace-nowrap">AMS-HT-01</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-1 whitespace-nowrap">Object Name</td>
                                <td class="px-2 py-1 whitespace-nowrap">OTIS-7360-1:1-1-1-2-5</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-1 whitespace-nowrap">Serial Number</td>
                                <td class="px-2 py-1 whitespace-nowrap">ALCLB150BB8E</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-1 whitespace-nowrap font-bold">Template Name</td>
                                <td class="px-2 py-1 pr-1 whitespace-nowrap">O.HSI_010</td>
                                <td class="px-2 py-1 whitespace-nowrap font-bold">Version</td>
                                <td class="px-2 py-1 whitespace-nowrap">2</td>
                            </tr>
                            </tbody>
                        </table>
                    </x-tabs.tab>

                </x-tabs.tab-container>
            </div>
            <div>
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
            <div>
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
            <div>
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
</x-app-layout>
