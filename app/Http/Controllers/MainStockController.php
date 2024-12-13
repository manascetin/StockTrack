<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Stock;

class MainStockController extends Controller
{
    // Tüm stokları görüntüle
    public function index(Request $request)
    {
        $query = DB::table('main_stocks');

        if ($request->filled('stocks_code')) {
            $query->where('stocks_code', 'LIKE', '%' . $request->stocks_code . '%');
        }

        if ($request->filled('stocks_name')) {
            $query->where('stocks_name', 'LIKE', '%' . $request->stocks_name . '%');
        }

        $stocks = $query->get();

        $user = session('user');
        return view('mainstocks.index', compact('stocks', 'user'));
    }


    // Yeni ürün ekleme sayfası
    public function create(Request $request)
    {
        $user = session('user');

        $stocksQuery = DB::table('main_stocks');

        if ($request->filled('stocks_code')) {
            $stocksQuery->where('stocks_code', 'like', '%' . $request->stocks_code . '%');
        }

        if ($request->filled('stocks_name')) {
            $stocksQuery->where('stocks_name', 'like', '%' . $request->stocks_name . '%');
        }

        $stocks = $stocksQuery->get();

        return view('mainstocks.create', compact('stocks', 'user'));
    }


    // Kullanıcının stok eklemesi
    public function add(Request $request, $id)
    {
        $request->validate([
            'add_amount' => 'required|numeric|min:1',
        ]);

        $user = session('user');

        // Main stock'tan seçilen ürün bilgisi alınır
        $mainStock = DB::table('main_stocks')->where('id', $id)->first();

        if (!$mainStock) {
            return redirect()->route('mainstocks.create')->with('error', 'Ürün bulunamadı.');
        }

        if ($mainStock->remaining_amount < $request->add_amount) {
            return redirect()->route('mainstocks.create')->with('error', 'Yeterli stok bulunmuyor.');
        }

        // Talep oluşturulur
        DB::table('product_requests')->insert([
            'user_id' => $user->id,
            'product_id' => $mainStock->id,
            'requested_amount' => $request->add_amount,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('mainstocks.create')->with('success', 'Talebiniz iletildi.');
    }

    // Talepleri görüntüle
    public function requests()
    {
        $requests = DB::table('product_requests')
            ->join('main_stocks', 'product_requests.product_id', '=', 'main_stocks.id')
            ->join('users', 'product_requests.user_id', '=', 'users.id')
            ->where('product_requests.status', 'pending')
            ->select('product_requests.*', 'main_stocks.stocks_name', 'users.name as user_name')
            ->get();

        return view('mainstocks.requests', compact('requests'));
    }

    // Talebi onayla
    public function approveRequest($id)
    {
        $request = DB::table('product_requests')->where('id', $id)->first();

        if ($request) {
            // Main stocks güncellenir
            DB::table('main_stocks')->where('id', $request->product_id)->decrement('remaining_amount', $request->requested_amount);

            // Stocks tablosunda mevcut bir kayıt var mı kontrol edelim
            $existingStock = DB::table('stocks')->where('stocks_id', $request->product_id)->first();

            if ($existingStock) {
                // Mevcut kaydı güncelle
                DB::table('stocks')->where('stocks_id', $request->product_id)->update([
                    'remaining_amount' => $existingStock->remaining_amount + $request->requested_amount,
                    'updated_at' => now(),
                ]);
            } else {
                // Yeni bir kayıt oluştur
                DB::table('stocks')->insert([
                    'stocks_id' => $request->product_id,
                    'branchs_id' => $request->user_id,
                    'stocks_code' => $request->stocks_code,
                    'barcode' => $request->barcode,
                    'stocks_name' => $request->stocks_name,
                    'remaining_amount' => $request->requested_amount,
                    'unit' => $request->unit,
                    'purchase_price' => $request->purchase_price,
                    'sale_price' => $request->sale_price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Talebin durumu güncellenir
            DB::table('product_requests')->where('id', $id)->update(['status' => 'approved']);
        }

        return redirect()->route('mainstocks.requests')->with('success', 'Talep onaylandı.');
    }


    // Talebi reddet
    public function rejectRequest($id)
    {
        DB::table('product_requests')->where('id', $id)->update(['status' => 'rejected']);
        return redirect()->route('mainstocks.requests')->with('success', 'Talep reddedildi.');
    }

    // Admin dashboard
    public function dashboard()
    {
        $requests = DB::table('product_requests')
            ->join('main_stocks', 'product_requests.product_id', '=', 'main_stocks.id')
            ->join('users', 'product_requests.user_id', '=', 'users.id')
            ->select(
                'product_requests.id as request_id',
                'main_stocks.stocks_name',
                'product_requests.requested_amount',
                'product_requests.status',
                'users.name as requested_by',
                'product_requests.created_at'
            )
            ->where('product_requests.status', 'pending') // Sadece bekleyen durumdaki istekler
            ->get();

        return view('dashboard', compact('requests'));
    }
}