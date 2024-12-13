<table>
    <thead>
    <a href="{{ route('dashboard') }}">Dashboard</a>
        <tr>
            <th>Kullanıcı</th>
            <th>Ürün</th>
            <th>Talep Miktarı</th>
            <th>Durum</th>
            <th>İşlem</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($requests as $request)
        <tr>
            <td>{{ $request->user_name }}</td>
            <td>{{ $request->stocks_name }}</td>
            <td>{{ $request->requested_amount }}</td>
            <td>{{ $request->status }}</td>
            <td>
                <form action="{{ route('mainstocks.approveRequest', $request->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit">Onayla</button>
                </form>
                <form action="{{ route('mainstocks.rejectRequest', $request->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit">Reddet</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
