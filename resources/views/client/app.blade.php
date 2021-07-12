<!DOCTYPE html>
<html lang="en">

<head>

    @include('client.includes.header')
    <title>@yield('title')</title>
    @stack('css')
    @yield('head')

</head>

<body>
    @include('client.includes.navbar')

    @yield('content')

    @include('client.includes.footer')
</body>

</html>
