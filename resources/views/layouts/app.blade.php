<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dashboard')</title>
    @include('layouts.head')
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

    <div class="app-wrapper">

        @include('layouts.navbar')

        @yield('content')

        @include('layouts.sidebar')

        @include('layouts.footer')
    </div>

</body>

</html>
