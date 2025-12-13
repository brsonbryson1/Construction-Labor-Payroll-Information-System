<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">

    {{-- Top Navigation --}}
    @include('components.nav-top')

    <div class="flex">

        {{-- Side Menu --}}
        @include('components.nav-sidemenu')

        {{-- Page Content --}}
        <main class="w-full p-6">
            @include('layouts.partials.breadcrumbs')

            {{ $slot ?? '' }}
        </main>
    </div>

    {{-- Footer --}}
    @include('components.nav-footer')

</body>
</html>
