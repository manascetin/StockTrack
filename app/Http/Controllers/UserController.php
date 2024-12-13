<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Stock;

class UserController extends Controller
{
    // Kullanıcı listesini görüntüleme
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Yeni kullanıcı ekleme sayfası
    public function create()
    {
        return view('users.create');
    }

    // Yeni kullanıcıyı kaydetme
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);
    
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        return redirect()->route('users.index')->with('success', 'Kullanıcı başarıyla eklendi.');
    }

    // Kullanıcı düzenleme sayfası
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    // Kullanıcıyı güncelleme
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);

        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('users.index')->with('success', 'Kullanıcı başarıyla güncellendi.');
    }

    // Kullanıcıyı silme
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Kullanıcı başarıyla silindi.');
    }

    // Stokları gösterme
    public function showStocks()
    {
        // Kullanıcı bilgilerini al
        $user = session('user');
        
        // Eğer kullanıcı oturumu yoksa login sayfasına yönlendir
        if (!$user) {
            return redirect()->route('userlogin')->with('error', 'Öncelikle giriş yapmalısınız.');
        }

        // Kullanıcıyı direkt olarak stocks sayfasına yönlendir
        return redirect()->route('stocks.index');
    }
}
