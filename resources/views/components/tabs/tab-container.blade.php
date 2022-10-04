@props(['active'])

<div
    @register-tab.stop="headings.push($event.detail.name)"
    x-data="{
    activeTab: '{{ $active }}',
    headings: [],
  }"
>

    <div class="mb-3 bg-white text-black"
         role="tablist"
    >
        <div class="pt-4 pr-4 pl-4">
        <template x-for="(tab, index) in headings"
                  :key="index"
        >
            <button x-text="tab"
                    @click="activeTab = tab; console.log(activeTab);"
                    class="px-6 py-2 text-sm border-top rounded hover:bg-blue-500 hover:text-white"
                    :class="tab === activeTab ? 'bg-blue-500 text-white' : 'text-gray-800'"
                    :id="'tab-${index + 1}'"
                    role="tab"
                    :aria-selected="(tab === activeTab).toString()"
                    :aria-controls="'tab-panel-${index + 1}'"
            ></button>
        </template>
    </div>
    </div>
    <div x-ref="tabs">
        {{ $slot }}
    </div>
</div>
