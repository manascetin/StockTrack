@extends('dashboard')

@section('content')
<h1>Kullanıcı Düzenle</h1>
<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ $user->email }}" required>
    </div>
    <div>
        <label for="password">Yeni Şifre (Opsiyonel):</label>
        <input type="password" name="password" id="password">
    </div>
    <button type="submit">Güncelle</button>
</form>
@endsection
