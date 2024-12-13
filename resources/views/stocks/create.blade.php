<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürün Ekle</title>
</head>
<body>
    <h1>Ürün Ekle</h1>
    <form method="POST" action="{{ route('stocks.store') }}">
        @csrf
        <label>Stok Kodu:</label>
        <input type="text" name="stocks_code" required><br>
        <label>Barkod:</label>
        <input type="text" name="barcode" required><br>
        <label>Stok Adı:</label>
        <input type="text" name="stocks_name" required><br>
        <label>Kalan Miktar:</label>
        <input type="number" name="remaining_amount" required><br>
        <label>Birim:</label>
        <input type="text" name="unit" required><br>
        <label>Alış Fiyatı:</label>
        <input type="number" step="0.01" name="purchase_price" required><br>
        <label>Satış Fiyatı:</label>
        <input type="number" step="0.01" name="sale_price" required><br>
        <button type="submit">Kaydet</button>
    </form>
</body>
</html>
