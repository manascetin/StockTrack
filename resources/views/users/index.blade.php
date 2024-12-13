@extends('dashboard')

@section('content')
<h1>Kullanıcı Yönetimi</h1>
<a href="{{ route('users.create') }}">Yeni Kullanıcı Ekle</a>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>İşlemler</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <a href="{{ route('users.edit', $user->id) }}">Düzenle</a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Sil</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
