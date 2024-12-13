<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
</head>
<body>
    <header>
        <a href="{{ route('logout') }}">Çıkış Yap</a>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>
