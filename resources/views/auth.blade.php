<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kontroller8</title>
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
</head>
<body>
<div id="auth">
    <div class="mdc-layout-grid">
        <div class="mdc-layout-grid__inner">
            <div class="mdc-layout-grid__cell--span-4"></div>
            <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-4">

                <span class="logo dark logo-k8">
                        <span class="k k1"></span>
                        <span class="k k2"></span>
                        <span class="k k3"></span>
                        <span class="k k4"></span>
                        <span class="k k5"></span>
                        <span class="k k6"></span>
                        <span class="k k7"></span>
                        <span class="k k8"></span>
                        <span class="k k9"></span>
                        <span class="k k10"></span>
                    </span>

                <h2 class="mdc-typography mdc-typography--headline6 auth-title">
                    Sign in to Kontroller8
                </h2>
                <div class="mdc-card">
                    <div class="mdc-card__primary-action" tabindex="0">
                        boo
                    </div>
                    <!-- ... content ... -->
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/auth.js') }}"></script>
</body>
</html>