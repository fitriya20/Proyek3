<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Exports\ProfitExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Driver;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function index()
    {
        $user = User::where('role_id', 2)->count();
        $product = Product::count();

        $orders = Order::count();

        $order = Order::with('product')->get();

        $total_profit = $order->sum(function ($order) {
            return $order->product->price;
        });

        return view('admin.dashboard.index', compact('user', 'product', 'order', 'total_profit', 'orders'));
    }

    public function customer()
    {
        $customers = User::where('role_id', 2)
            ->orderBy('name', 'asc') // Mengurutkan berdasarkan kolom 'name' secara ascending (A-Z)
            ->get();
        return view('admin.customer.index', compact('customers'));
    }

    public function customerStore(Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email',
            'password'=>'required|string',
            'no_telp'=>'required|string',
        ]);

        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role_id' => '2',
            'no_telp'=>$request->no_telp
        ]);

        return Redirect()->back()->with('success', 'Users add successfully!');
    }

    public function customerUpdate(Request $request, User $user)
    {
        $request->validate([
            'name'=>'required|string',
            'no_telp'=>'required|string',
        ]);

        $user->update([
            'name'=>$request->name,
            'no_telp'=>$request->no_telp
        ]);

        return Redirect()->route('admin.customer')->with('success', 'Users updated successfully!');
    }

    public function customerDeleted(User $user)
    {
        $user->delete();

        return Redirect()->back()->with('success', 'Users deleted successfully!');
    }

    public function customer_order()
    {
        $orders = Order::with([
            'users' => function ($query) {
                $query->orderBy('name', 'asc');
            },
            'product',
            'status',
            'driver'
        ])->get();
        $statuses = OrderStatus::all();
        return view('admin.customer_order.index', compact('orders', 'statuses'));
    }

    public function exportProfit()
    {
        return Excel::download(new ProfitExport, 'data_profit.xlsx');
    }

    public function customer_order_update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->status_id = $request->status_id;
        $order->installation_date = $request->installation_date;
        $order->save();

        return redirect()->back()->with('success', 'Order updated successfully');
    }

    public function profit(Request $request)
    {
        $query = Order::with(['users', 'product']);

        if ($request->filled('selected_month') && $request->filled('selected_year')) {
            $query->whereYear('order_date', $request->selected_year)
                ->whereMonth('order_date', $request->selected_month);
        }

        $orders = $query->get();

        $total_profit = $orders->sum(function ($order) {
            return $order->product->price;
        });

        $selected_month = $request->selected_month;
        $selected_year = $request->selected_year;

        return view('admin.profit.index', compact('orders', 'total_profit', 'selected_month', 'selected_year'));
    }

    public function product(Request $request)
    {
        $products = Product::with('category')
            ->when($request->search, function ($query) use ($request) {
                $query->where('product_name', 'like', '%' . $request->search . '%');
            })
            ->paginate(4);

        $categories = Category::all();

        $categories = Category::all();

        return view('admin.product.index', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'categories_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string'
        ]);

        $filePath = $request->file('image')->move('products_image', time() . '_' . $request->file('image')->getClientOriginalName());

        Product::create([
            'product_name' => $request->product_name,
            'categories_id' => $request->categories_id,
            'price' => $request->price,
            'image' => $filePath,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->route('admin.product')->with('success', 'Product added successfully!');
    }

    public function edit(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'categories_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string'
        ]);


        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            $filePath = $request->file('image')->move('products_image', time() . '_' . $request->file('image')->getClientOriginalName());
            $product->image = $filePath;
        }

        $product->update([
            'product_name' => $request->product_name,
            'categories_id' => $request->categories_id,
            'price' => $request->price,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->route('admin.product')->with('success', 'Product update successfully!');
    }

    public function product_delete(Product $product)
    {
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        $product->delete();

        return redirect()->route('admin.product')->with('success', 'Product remove successfully!');
    }

    public function category()
    {
        $categories = Category::all();
        return view('admin.category.index', compact('categories'));
    }

    public function category_store(Request $request)
    {
        $request->validate([
            'categories_name' => 'required|string'
        ]);

        Category::create([
            'categories_name' => $request->categories_name
        ]);

        return redirect()->route('admin.category')->with('success', 'Categories added successfully!');
    }

    public function category_delete(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.category')->with('success', 'Categories remove successfully!');
    }

    public function driver()
    {
        $drivers = Driver::all();
        return view('admin.driver.index', compact('drivers'));
    }

    public function driver_store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        Driver::create([
            'name' => $request->name
        ]);

        return redirect()->route('admin.driver')->with('success', 'Driver addedd successfully!');
    }

    public function driver_edit(Request $request, Driver $driver)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $driver->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.driver')->with('success', 'Driver updated successfully!');
    }

    public function driver_delete(Driver $driver)
    {
        $driver->delete();

        return redirect()->route('admin.driver')->with('success', 'Driver remove successfully!');
    }
}
