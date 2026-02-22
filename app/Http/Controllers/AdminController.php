<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Post;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    // --- 1. DASHBOARD ---
    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalStock = Product::sum('stock');
        $totalOrders = Order::count();
        $lowStockProducts = Product::where('stock', '<=', 5)->get();
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
        
        return view('admin.dashboard', compact('totalProducts', 'totalStock', 'totalOrders', 'totalRevenue', 'chartData','lowStockProducts'));
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

    // --- 3. KATEGORI PRODUK ---
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

    // --- 4. PESANAN ---
    public function orderList() {
        $orders = Order::latest()->get();
        return view('admin.order-list', compact('orders'));
    }

    public function orderUpdateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $request->status;

        if ($oldStatus !== 'completed' && $newStatus === 'completed') {
            foreach ($order->items as $item) {
                $product = Product::where('name', $item['name'])->first();
                if ($product) {
                    $product->decrement('stock', $item['quantity']);
                }
            }
        }
        
        if ($oldStatus === 'completed' && $newStatus === 'cancelled') {
            foreach ($order->items as $item) {
                $product = Product::where('name', $item['name'])->first();
                if ($product) {
                    $product->increment('stock', $item['quantity']);
                }
            }
        }

        $order->update(['status' => $newStatus]);
        return redirect()->back()->with('success', 'Status pesanan diperbarui!');
    }

    public function orderDelete($id) {
        Order::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Pesanan dihapus.');
    }

    public function printReceipt($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.print-receipt', compact('order'));
    }

    // --- 5. LAPORAN ---
    public function reportIndex()
    {
        $dailyRevenue = Order::where('status', 'completed')->whereDate('created_at', now())->sum('total_price');
        $weeklyRevenue = Order::where('status', 'completed')->whereBetween('created_at', [now()->subDays(7), now()])->sum('total_price');
        $monthlyRevenue = Order::where('status', 'completed')->whereMonth('created_at', now()->month)->sum('total_price');

        $dailyLabels = []; $dailyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dailyLabels[] = $date->format('d/m');
            $dailyData[] = Order::where('status', 'completed')->whereDate('created_at', $date)->sum('total_price');
        }

        $monthlyLabels = []; $monthlyData = [];
        for ($i = 4; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyLabels[] = $date->format('M');
            $monthlyData[] = Order::where('status', 'completed')->whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->sum('total_price');
        }

        return view('admin.report-index', compact('dailyRevenue', 'weeklyRevenue', 'monthlyRevenue', 'dailyLabels', 'dailyData', 'monthlyLabels', 'monthlyData'));
    }

    public function downloadReport($period)
    {
        $query = Order::where('status', 'completed');
        if ($period == 'daily') {
            $query->whereDate('created_at', now());
            $title = "Harian (" . now()->format('d M Y') . ")";
        } elseif ($period == 'weekly') {
            $query->whereBetween('created_at', [now()->subDays(7), now()]);
            $title = "Mingguan (7 Hari Terakhir)";
        } else {
            $query->whereMonth('created_at', now()->month);
            $title = "Bulanan (" . now()->format('F Y') . ")";
        }

        $orders = $query->get();
        $totalRevenue = $orders->sum('total_price');
        $totalOrders = $orders->count();

        $pdf = Pdf::loadView('admin.report-pdf', compact('orders', 'totalRevenue', 'totalOrders', 'title'));
        return $pdf->download('Laporan_HappyPet_' . $period . '_' . now()->format('d_M_Y') . '.pdf');
    }

    // --- 6. BLOG & EDUKASI ---
    public function blogList() {
        $posts = Post::with('category')->latest()->get();
        return view('admin.blog-list', compact('posts'));
    }

    public function blogCreate() {
        $categories = BlogCategory::all();
        return view('admin.blog-add', compact('categories'));
    }

    public function blogStore(Request $request) {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'blog_category_id' => 'required',
            'image' => 'required|image|max:2048'
        ]);

        $imageName = null;
        if($request->hasFile('image')){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('assets/img/blog'), $imageName);
        }

        Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'blog_category_id' => $request->blog_category_id,
            'content' => $request->input('content'),
            'image' => $imageName
        ]);

        return redirect()->route('admin.blog.list')->with('success', 'Artikel berhasil diterbitkan!');
    }

    public function blogEdit($id) {
        $post = Post::findOrFail($id);
        $categories = BlogCategory::all();
        return view('admin.blog-edit', compact('post', 'categories'));
    }

    public function blogUpdate(Request $request, $id) {
        $post = Post::findOrFail($id);
        
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'blog_category_id' => 'required',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($post->image && File::exists(public_path('assets/img/blog/' . $post->image))) {
                File::delete(public_path('assets/img/blog/' . $post->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('assets/img/blog'), $imageName);
            $post->image = $imageName;
        }

        $post->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'blog_category_id' => $request->blog_category_id,
            'content' => $request->input('content'),
            'image' => $post->image
        ]);

        return redirect()->route('admin.blog.list')->with('success', 'Artikel berhasil diupdate!');
    }

    public function blogDestroy($id) {
        $post = Post::findOrFail($id);
        if ($post->image && File::exists(public_path('assets/img/blog/' . $post->image))) {
            File::delete(public_path('assets/img/blog/' . $post->image));
        }
        $post->delete();
        return redirect()->back()->with('success', 'Artikel berhasil dihapus!');
    }

    // --- 7. KATEGORI BLOG ---
    public function blogCategoryList() {
        $categories = BlogCategory::all();
        return view('admin.blog-category-list', compact('categories'));
    }

    public function blogCategoryStore(Request $request) {
        $request->validate(['name' => 'required|unique:blog_categories,name']);
        
        BlogCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return redirect()->back()->with('success', 'Kategori blog berhasil ditambah!');
    }

    public function blogCategoryDestroy($id) {
        BlogCategory::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Kategori blog berhasil dihapus!');
    }
}