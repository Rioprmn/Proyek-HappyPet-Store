<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    // --- 1. DASHBOARD ---
    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalStock = Product::sum('stock');
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');
        
        $categories = Category::all();
        $chartLabels = [];
        $chartCounts = [];
        foreach($categories as $cat) {
            $chartLabels[] = $cat->name;
            $chartCounts[] = Product::where('category', $cat->name)->count();
        }

        $salesLabels = [];
        $salesData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $salesLabels[] = $date->format('d M');
            $salesData[] = Order::where('status', 'completed')
                            ->whereDate('created_at', $date)
                            ->sum('total_price');
        }

        $chartData = [
            'labels' => $chartLabels,
            'counts' => $chartCounts,
            'salesLabels' => $salesLabels,
            'salesData' => $salesData
        ];
        
        return view('admin.dashboard', compact('totalProducts', 'totalStock', 'totalOrders', 'totalRevenue', 'chartData'));
    }

    // --- 2. PRODUK ---
    public function productList(Request $request)
    {
        $categories = Category::all();
        $query = Product::query();
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }
        $products = $query->latest()->get();
        return view('admin.product-list', compact('products', 'categories'));
    }

    public function create() {
        $categories = Category::all(); 
        return view('admin.product-add', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required', 'price' => 'required|numeric',
            'category' => 'required', 'stock' => 'required|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $request->image->extension();
            $request->image->move(public_path('assets/img/products'), $imageName);
        }

        Product::create([
            'name' => $request->name, 'price' => $request->price,
            'category' => $request->category, 'stock' => $request->stock,
            'description' => $request->description, 'image' => $imageName,
        ]);

        return redirect()->route('admin.product.list')->with('success', 'Produk Berhasil Ditambahkan!');
    }

    public function edit($id) {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.product-edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id) {
        $product = Product::findOrFail($id);
        if ($request->hasFile('image')) {
            if ($product->image && File::exists(public_path('assets/img/products/' . $product->image))) {
                File::delete(public_path('assets/img/products/' . $product->image));
            }
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $request->image->extension();
            $request->image->move(public_path('assets/img/products'), $imageName);
            $product->image = $imageName;
        }

        $product->update([
            'name' => $request->name, 'price' => $request->price,
            'category' => $request->category, 'stock' => $request->stock,
            'description' => $request->description, 'image' => $product->image
        ]);

        return redirect()->route('admin.product.list')->with('success', 'Produk Berhasil Diupdate!');
    }

    public function destroy($id) {
        $product = Product::findOrFail($id);
        if ($product->image && File::exists(public_path('assets/img/products/' . $product->image))) {
            File::delete(public_path('assets/img/products/' . $product->image));
        }
        $product->delete();
        return redirect()->route('admin.product.list')->with('success', 'Produk Dihapus!');
    }

    // --- 3. KATEGORI ---
    public function categoryList() {
        $categories = Category::all();
        return view('admin.category-list', compact('categories'));
    }

    public function categoryStore(Request $request) {
        $request->validate(['name' => 'required|unique:categories,name']);
        Category::create(['name' => $request->name, 'slug' => Str::slug($request->name)]);
        return redirect()->back()->with('success', 'Kategori baru ditambahkan!');
    }

    public function categoryDelete($id) {
        Category::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Kategori dihapus!');
    }

    // --- 4. PESANAN (LOGIC BARU) ---
    public function orderList() {
        $orders = Order::latest()->get();
        return view('admin.order-list', compact('orders'));
    }

    public function orderUpdateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Logic Potong Stok Otomatis saat status berubah jadi COMPLETED
        if ($newStatus == 'completed' && $oldStatus != 'completed') {
            $items = $order->items; // Karena sudah di-cast array di Model
            foreach ($items as $item) {
                $product = Product::where('name', $item['name'])->first();
                if ($product) {
                    $product->decrement('stock', $item['quantity']);
                }
            }
        }

        $order->update(['status' => $newStatus]);
        return redirect()->back()->with('success', 'Status Berhasil diperbarui!');
    }

    public function orderDelete($id) {
        Order::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Pesanan dihapus.');
    }
}