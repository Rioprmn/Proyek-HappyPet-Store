<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File; // Tambahkan ini untuk hapus file gambar

class AdminController extends Controller
{
    // --- 1. DASHBOARD ---
    public function dashboard()
{
    $totalProducts = Product::count();
    $totalStock = Product::sum('stock');
    
    // Data untuk Chart: Menghitung jumlah produk tiap kategori
    $categories = Category::all();
    $chartLabels = [];
    $chartCounts = [];
    
    foreach($categories as $cat) {
        $chartLabels[] = $cat->name;
        $chartCounts[] = Product::where('category', $cat->name)->count();
    }

    $chartData = [
        'labels' => $chartLabels,
        'counts' => $chartCounts
    ];
    
    return view('admin.dashboard', compact('totalProducts', 'totalStock', 'chartData'));
}

    // --- 2. PRODUK (PRODUCT) ---

    public function productList()
    {
        $products = Product::latest()->get(); 
        return view('admin.product-list', compact('products'));
    }

    public function create()
    {
        $categories = Category::all(); 
        return view('admin.product-add', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric',
            'category' => 'required',
            'stock'    => 'required|integer',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $request->image->extension();
            $request->image->move(public_path('assets/img/products'), $imageName);
        }

        Product::create([
            'name'        => $request->name,
            'price'       => $request->price,
            'category'    => $request->category,
            'stock'       => $request->stock,
            'description' => $request->description,
            'image'       => $imageName,
        ]);

        return redirect()->route('admin.product.list')->with('success', 'Produk Berhasil Ditambahkan! 🐾');
    }

    // --- FITUR BARU: EDIT & UPDATE ---
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.product-edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category' => 'required',
            'stock' => 'required|integer',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image && File::exists(public_path('assets/img/products/' . $product->image))) {
                File::delete(public_path('assets/img/products/' . $product->image));
            }
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $request->image->extension();
            $request->image->move(public_path('assets/img/products'), $imageName);
            $product->image = $imageName;
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'category' => $request->category,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $product->image
        ]);

        return redirect()->route('admin.product.list')->with('success', 'Produk Berhasil Diupdate!');
    }

    // --- FITUR BARU: DELETE ---
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image && File::exists(public_path('assets/img/products/' . $product->image))) {
            File::delete(public_path('assets/img/products/' . $product->image));
        }
        $product->delete();
        return redirect()->route('admin.product.list')->with('success', 'Produk Berhasil Dihapus!');
    }

    // --- 3. KATEGORI (CATEGORY) ---
    public function categoryList() 
    {
        $categories = Category::all();
        return view('admin.category-list', compact('categories'));
    }

    public function categoryStore(Request $request) 
    {
        $request->validate(['name' => 'required|unique:categories,name|max:100']);
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);
        return redirect()->back()->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function categoryDelete($id) 
    {
        Category::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Kategori telah dihapus!');
    }

    public function orderList()
{
    $orders = Order::latest()->get();
    return view('admin.order-list', compact('orders'));
}

public function orderDelete($id)
{
    $order = Order::findOrFail($id);
    $order->delete();
    return redirect()->back()->with('success', 'Data pesanan berhasil dihapus.');
}
}