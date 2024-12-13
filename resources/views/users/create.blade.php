@extends('dashboard')

@section('content')
<h1>Yeni Kullanıcı Ekle</h1>
<form action="{{ route('users.store') }}" method="POST">
    @csrf
    <label for="name">Ad:</label>
    <input type="text" id="name" name="name" required>
    <br>
    <label for="email">E-posta:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="password">Şifre:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <button type="submit">Kaydet</button>
</form>
@endsection
