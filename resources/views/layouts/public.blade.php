<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
       <link href="https://fonts.googleapis.com/css2?family=Hind:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style type="text/css">
            body{
  font-family: "Hind", sans-serif !important;
            }
        </style>
    </head>

    <body class=" antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.pubnav')

          

            <!-- Page Content -->
            <main>
        @yield('content')
            </main>
        </div>
    </body>
</html>
