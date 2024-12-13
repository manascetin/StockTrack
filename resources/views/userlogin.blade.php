<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
</head>
<body>
    <h1>User Login</h1>

    @if ($errors->any())
        <div style="color: red;">
            <strong>{{ $errors->first('login_error') }}</strong>
        </div>
    @endif

    <form method="POST" action="{{ route('userlogin') }}">
        @csrf
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Şifre:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Giriş Yap</button>
    </form>
</body>
</html>
