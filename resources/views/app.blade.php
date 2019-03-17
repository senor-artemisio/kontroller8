<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kontroller8</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<b-container id="app" class="h-100">
    <router-view></router-view>
</b-container>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
