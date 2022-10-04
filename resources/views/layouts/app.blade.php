<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css" />

    @livewireStyles
    @stack('styles')

<!-- must be added in order for the x-cloak html tag to work -->
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

</head>
<body class="font-sans antialiased nightwind system">

<x-jet-banner/>

<div class="min-h-screen bg-gray-100">
    @livewire('navigation-menu')

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
@endif

<!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
</div>

@stack('modals')

@livewireScripts

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}" defer></script>

@stack('scripts')

<script>
    var nightwind = {
        beforeTransition: () => {
            const doc = document.documentElement;
            const onTransitionDone = () => {
                doc.classList.remove('nightwind');
                doc.removeEventListener('transitionend', onTransitionDone);
            }
            doc.addEventListener('transitionend', onTransitionDone);
            if (!doc.classList.contains('nightwind')) {
                doc.classList.add('nightwind');
            }
        },

        toggle: () => {
            nightwind.beforeTransition();
            if (!document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.add('dark');
                window.localStorage.setItem('nightwind-mode', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                window.localStorage.setItem('nightwind-mode', 'light');
            }
        },

        enable: (dark) => {
            const mode = dark ? "dark" : "light";
            const opposite = dark ? "light" : "dark";

            nightwind.beforeTransition();

            if (document.documentElement.classList.contains(opposite)) {
                document.documentElement.classList.remove(opposite);
            }
            document.documentElement.classList.add(mode);
            window.localStorage.setItem('nightwind-mode', mode);
        },
    }
</script>
<script>
    (function() {
        function getInitialColorMode() {
            const persistedColorPreference = window.localStorage.getItem('nightwind-mode');
            const hasPersistedPreference = typeof persistedColorPreference === 'string';
            if (hasPersistedPreference) {
                return persistedColorPreference;
            }
            const mql = window.matchMedia('(prefers-color-scheme: dark)');
            const hasMediaQueryPreference = typeof mql.matches === 'boolean';
            if (hasMediaQueryPreference) {
                return mql.matches ? 'dark' : 'light';
            }
            return 'light';
        }
        getInitialColorMode() === 'light' ? document.documentElement.classList.remove('dark') : document.documentElement.classList.add('dark');
    })()
</script>

</body>
</html>
