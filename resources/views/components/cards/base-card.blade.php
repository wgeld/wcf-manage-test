<div class="flex flex-col border bg-white border-1 border-gray-300 m-0 p-0">
    <div class="mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
        <div class="p-2">
            <div class="grid gap-1 grid-cols-2">
                <strong>{{ $cardHeaderTitle }}</strong>
                @isset($cardHeaderLinks)
                    <div class="rounded text-center bg-green-500 text-white hover:bg-green-600 p-1">
                        {{ $cardHeaderLinks }}
                    </div>
                @endisset
            </div>
            <div>
                <span class="text-sm text-gray-500">{{ $cardHeaderDetail }}</span>
            </div>

        </div>

        <div class="flex-auto">
            {{ $slot }}
        </div>
    </div>
</div>
