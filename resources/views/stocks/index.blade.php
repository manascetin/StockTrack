<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stoklar</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        .action-buttons a {
            margin: 0 5px;
            text-decoration: none;
            color: white;
            padding: 5px 10px;
            border-radius: 3px;
        }
        .edit {
            background-color: #4CAF50;
        }
        .delete {
            background-color: #f44336;
        }
        .add {
            background-color: #008CBA;
        }
    </style>
</head>
<body>
    <h1>Hoşgeldiniz, {{ $user->name }}</h1>
    <p>Burası kullanıcı panelinizdir.</p>
    <a href="{{ route('logout') }}">Çıkış Yap</a>
    <h1>Stoklar</h1>
    <div>
        <a href="{{ route('mainstocks.create') }}">Ürün Ekle</a>
        <form method="GET" action="{{ route('stocks.index') }}">
            <label for="stocks_code">Stok Kodu:</label>
            <input type="text" name="stocks_code" value="{{ request('stocks_code') }}" placeholder="Stok Kodu">
            <label for="stocks_name">Stok Adı:</label>
            <input type="text" name="stocks_name" value="{{ request('stocks_name') }}" placeholder="Stok Adı">
            <button type="submit">Ara</button>
        </form>

    </div>
    <br>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Stok Kodu</th>
                <th>Barkod</th>
                <th>Stok Adı</th>
                <th>Kalan Miktar</th>
                <th>Birim</th>
                <th>Alış Fiyatı</th>
                <th>Satış Fiyatı</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($stocks as $stock)
                <tr>
                    <td>{{ $stock->stocks_code }}</td>
                    <td>{{ $stock->barcode }}</td>
                    <td>{{ $stock->stocks_name }}</td>
                    <td>{{ $stock->remaining_amount }}</td>
                    <td>{{ $stock->unit }}</td>
                    <td>{{ $stock->purchase_price }}</td>
                    <td>{{ $stock->sale_price }}</td>
                    <td>
                        <a href="{{ route('stocks.edit', $stock->id) }}">Düzenle</a>
                        <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Bu ürünü silmek istediğinize emin misiniz?')">Sil</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Aramanıza uygun stok bulunamadı.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
