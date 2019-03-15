<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kontroller8</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <drawer></drawer>
    <div class="mdc-drawer-scrim"></div>
    <div class="mdc-drawer-app-content">
        <top-app-bar></top-app-bar>
        <main class="main-content" id="main-content">
            <div class="mdc-top-app-bar--fixed-adjust">
                <router-view></router-view>
            </div>
        </main>
    </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
