@props(['name'])

<div class="text-black"
     x-data="{
        id: '',
        name: '{{ $name }}',
    }"
     x-show="name === activeTab; show: false"
     role="tabpanel"
     :aria-labelledby="'tab-${id}'"
     :id="'tab-panel-${id}'"
     x-init="$dispatch('register-tab',  { name: name })"
     x-cloak>
    {{ $slot }}

</div>
