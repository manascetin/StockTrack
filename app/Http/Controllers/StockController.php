<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;


class StockController extends Controller
{
    // Tüm stokları görüntüle
    public function index(Request $request)
    {
        $query = DB::table('stocks')->where('branchs_id', session('user')->branch);

        if ($request->filled('stocks_code')) {
            $query->where('stocks_code', 'LIKE', '%' . $request->stocks_code . '%');
        }

        if ($request->filled('stocks_name')) {
            $query->where('stocks_name', 'LIKE', '%' . $request->stocks_name . '%');
        }

        $stocks = $query->get();

        $user = session('user');
        return view('stocks.index', compact('stocks', 'user'));
    }


    // Yeni ürün ekleme formu
    public function create()
    {
        $user = session('user');
        return view('stocks.create', compact('user'));
    }

    // Yeni ürün kaydetme
    public function store(Request $request)
    {
        $user = session('user');

        // Validation işlemi
        $request->validate([
            'stocks_code' => 'required|unique:main_stocks,stocks_code',
            'barcode' => 'required|unique:main_stocks,barcode',
            'stocks_name' => 'required',
            'remaining_amount' => 'required|numeric',
            'unit' => 'required',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
        ]);

        // Yeni ürün oluşturmayı main_stocks tablosuna yönlendirme
        DB::table('main_stocks')->insert([
            'stocks_code' => $request->stocks_code,
            'barcode' => $request->barcode,
            'stocks_name' => $request->stocks_name,
            'remaining_amount' => $request->remaining_amount,
            'unit' => $request->unit,
            'purchase_price' => $request->purchase_price,
            'sale_price' => $request->sale_price,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('mainstocks.index')->with('success', 'Ürün başarıyla eklendi.');
    }


    // Ürün düzenleme formu
    public function edit($id)
    {
        $user = session('user');
        $stock = Stock::where('branchs_id', $user->branch)->findOrFail($id);
        return view('stocks.edit', compact('stock', 'user'));
    }

    // Ürün güncelleme
    public function update(Request $request, $id)
    {
        $user = session('user');
        $stock = Stock::where('branchs_id', $user->branch)->findOrFail($id);

        // Validation işlemi
        $request->validate([
            'stocks_code' => 'required',
            'barcode' => 'required',
            'stocks_name' => 'required',
            'remaining_amount' => 'required|numeric',
            'unit' => 'required',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
        ]);

        // Güncelleme işlemi
        $stock->update($request->all());

        return redirect()->route('userdashboard')->with('success', 'Ürün başarıyla güncellendi.');
    }

    // Ürün silme
    public function destroy($id)
    {
        $user = session('user');
        $stock = Stock::where('branchs_id', $user->branch)->findOrFail($id);
        $stock->delete();

        return redirect()->route('userdashboard')->with('success', 'Ürün başarıyla silindi.');
    }

}
