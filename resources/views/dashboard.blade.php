<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <nav>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('users.index') }}">Kullanıcı Yönetimi</a>
        <a href="{{ route('mainstocks.index') }}">Stoklarım</a>
        <a href="{{ route('mainstocks.requests') }}">Taleplerim</a>
        <a href="{{ route('logout') }}">Çıkış Yap</a>
    </nav>
    <div>
        @yield('content')
    </div>
</body>
</html>
