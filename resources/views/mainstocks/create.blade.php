<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürün Ekle</title>
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
        form {
            display: inline-block;
        }
    </style>
</head>
<body>
    <h1>Hoşgeldiniz, {{ $user->name }}</h1>
    <p>Stok ekleme panelindesiniz.</p>
    <a href="{{ route('logout') }}">Çıkış Yap</a>
    <a href="{{ route('stocks.index') }}">Ürünlerim</a>
    <form method="GET" action="{{ route('mainstocks.create') }}">
        <label for="stocks_code">Stok Kodu:</label>
        <input type="text" name="stocks_code" value="{{ request('stocks_code') }}" placeholder="Stok Kodu">
        <label for="stocks_name">Stok Adı:</label>
        <input type="text" name="stocks_name" value="{{ request('stocks_name') }}" placeholder="Stok Adı">
        <button type="submit">Ara</button>
    </form>
    <h1>Ürün Ekle</h1>
    <table>
        <thead>
            <tr>
                <th>Stok Kodu</th>
                <th>Barkod</th>
                <th>Stok Adı</th>
                <th>Kalan Miktar</th>
                <th>Birim</th>
                <th>Alış Fiyatı</th>
                <th>Satış Fiyatı</th>
                <th>Eklenecek Miktar</th>
                <th>İşlem</th>
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
                        <form action="{{ route('mainstocks.add', $stock->id) }}" method="POST">
                            @csrf
                            <input type="number" name="add_amount" min="1" max="{{ $stock->remaining_amount }}" required>
                    </td>
                    <td>
                            <button type="submit">Kaydet</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">Aramanıza uygun ürün bulunamadı.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
