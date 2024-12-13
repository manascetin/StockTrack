@extends('layouts.app')

@section('content')
<h1>Ürün Düzenle</h1>
<form action="{{ route('stocks.update', $stock->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div>
        <label for="stocks_code">Stok Kodu:</label>
        <input type="text" name="stocks_code" value="{{ $stock->stocks_code }}" required>
    </div>
    <div>
        <label for="barcode">Barkod:</label>
        <input type="text" name="barcode" value="{{ $stock->barcode }}" required>
    </div>
    <div>
        <label for="stocks_name">Stok Adı:</label>
        <input type="text" name="stocks_name" value="{{ $stock->stocks_name }}" required>
    </div>
    <div>
        <label for="remaining_amount">Kalan Miktar:</label>
        <input type="text" name="remaining_amount" value="{{ $stock->remaining_amount }}" required>
    </div>
    <div>
        <label for="unit">Birim:</label>
        <input type="text" name="unit" value="{{ $stock->unit }}" required>
    </div>
    <div>
        <label for="purchase_price">Alış Fiyatı:</label>
        <input type="text" name="purchase_price" value="{{ $stock->purchase_price }}" required>
    </div>
    <div>
        <label for="sale_price">Satış Fiyatı:</label>
        <input type="text" name="sale_price" value="{{ $stock->sale_price }}" required>
    </div>
    <button type="submit">Güncelle</button>
</form>
@endsection
