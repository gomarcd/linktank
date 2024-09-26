<!DOCTYPE html>
<html data-theme="valentine" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'LinkTank' }}</title>
        @livewireStyles
        @fluxStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        {{ $slot }}
        <x-toaster-hub />
        @fluxScripts
        @livewireScriptConfig
    </body>
</html>