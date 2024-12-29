<?php

namespace App\Http\Controllers\WEB\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Driver;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index(Request $request, Product $product)
    {
        $product = Product::take(4)->get();
        $categories = Category::all();

        $selectedCategory = $request->query('kategori');
        $product = Product::when($selectedCategory, function ($query) use ($selectedCategory) {
            return $query->whereHas('category', function ($query) use ($selectedCategory) {
                $query->where('categories_name', $selectedCategory);
            });
        })->get();

        return view('customer.dashboard.index', compact('product', 'categories'));
    }

    public function dashboard(Request $request, Product $product)
    {
        $product = Product::take(4)->get();
        $categories = Category::all();

        // Ambil keyword dari input pencarian
        $keyword = $request->input('keyword');

        // Ambil 4 produk pertama, atau lakukan pencarian berdasarkan keyword
        $product = Product::when($keyword, function ($query) use ($keyword) {
            // Cari produk berdasarkan nama atau deskripsi
            return $query->where('product_name', 'like', '%' . $keyword . '%')
                ->orWhere('deskripsi', 'like', '%' . $keyword . '%');
        })->take(4)->get();

        $selectedCategory = $request->query('kategori');
        if ($selectedCategory) {
            $product = Product::whereHas('category', function ($query) use ($selectedCategory) {
                $query->where('categories_name', $selectedCategory);
            })->get();
        }

        return view('customer.dashboard.index', compact('product', 'categories'));
    }

    public function paket(Request $request, Product $product)
    {
        $product = Product::all();
        $countData = $product->count();
        $categories = Category::all();

        $keyword = $request->input('keyword');

        $selectedCategory = $request->query('kategori');

        if ($selectedCategory) {
            $product = Product::whereHas('category', function ($query) use ($selectedCategory) {
                $query->where('categories_name', $selectedCategory);
            })->get();

            $countData = $product->count();
        }

        $product = Product::when($keyword, function ($query) use ($keyword) {
            return $query->where('product_name', 'like', '%' . $keyword . '%')
                ->orWhere('deskripsi', 'like', '%' . $keyword . '%');
        })->get();


        return view('customer.paket.index', compact('product', 'countData', 'categories'));
    }

    public function contact(Request $request, Product $product)
    {
        $categories = Category::all();

        $selectedCategory = $request->query('kategori');
        $product = Product::when($selectedCategory, function ($query) use ($selectedCategory) {
            return $query->whereHas('category', function ($query) use ($selectedCategory) {
                $query->where('categories_name', $selectedCategory);
            });
        })->get();

        return view('customer.contact.index', compact('categories'));
    }

    public function about(Request $request, Product $product)
    {
        $categories = Category::all();

        $selectedCategory = $request->query('kategori');
        $product = Product::when($selectedCategory, function ($query) use ($selectedCategory) {
            return $query->whereHas('category', function ($query) use ($selectedCategory) {
                $query->where('categories_name', $selectedCategory);
            });
        })->get();

        return view('customer.about.index', compact('categories'));
    }

    public function pesan(Request $request, $name)
    {
        $categories = Category::all();
        $drivers = Driver::all();

        $selectedCategory = $request->query('kategori');
        $product = Product::when($selectedCategory, function ($query) use ($selectedCategory) {
            return $query->whereHas('category', function ($query) use ($selectedCategory) {
                $query->where('categories_name', $selectedCategory);
            });
        })->get();

        $product = Product::where('product_name', $name)->first();

        if (!$product) {
            return redirect()->route('customer.paket')->with('error', 'Produk tidak ditemukan.');
        }

        return view('customer.pesan.index', compact('categories', 'product', 'drivers'));
    }

    public function map(Request $request, Product $product)
    {
        $categories = Category::all();

        $selectedCategory = $request->query('kategori');
        $product = Product::when($selectedCategory, function ($query) use ($selectedCategory) {
            return $query->whereHas('category', function ($query) use ($selectedCategory) {
                $query->where('categories_name', $selectedCategory);
            });
        })->get();

        return view('customer.map.index', compact('categories'));
    }

    public function proses(Request $request, Product $product, Order $order, $name)
    {
        $request->validate([
            'address' => 'required|string',
            'order_date' => 'required|date',
            'installation_date' => 'required|date'
        ]);

        $product = Product::where('product_name', $name)->first();

        $user = Auth::user();

        Order::create([
            'address' => $request->address,
            'users_id' => $user->id,
            'product_id' => $product->id,
            'status_id' => 1,
            'drivers_id' => $request->drivers_id,
            'order_date' => $request->order_date,
            'installation_date' => $request->installation_date
        ]);

        return redirect()->route('customer.profil', compact('product'))->with('success', 'Order has been successfully placed, wait for admin confirmation');
    }

    public function profil(Request $request)
    {
        $categories = Category::all();

        $selectedCategory = $request->query('kategori');
        $product = Product::when($selectedCategory, function ($query) use ($selectedCategory) {
            return $query->whereHas('category', function ($query) use ($selectedCategory) {
                $query->where('categories_name', $selectedCategory);
            });
        })->get();

        $orders = Order::where('users_id', Auth::id())->get();

        return view('customer.profil.index', compact('categories', 'orders'));
    }

    public function profil_edit(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'no_telp' => 'required|string|min:11',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $user = Auth::user();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->move('profile_images', time() . '_' . $request->file('image')->getClientOriginalName());

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
                'image' => $imagePath
            ]);
        } else {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
            ]);
        }

        return redirect()->route('customer.profil')->with('success', 'Profil berhasil diperbarui!');
    }
}
