@extends('layouts.admin')

@section('content')
<div class="header-section" style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 style="margin: 0; color: #1e293b; font-weight: 700;">Dashboard Overview</h1>
        <p style="color: #64748b; margin-top: 5px;">Ringkasan aktivitas toko HappyPet hari ini.</p>
    </div>
    <div style="background: white; padding: 10px 20px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); font-weight: 600; color: #2c9a94;">
        📅 {{ date('d M Y') }}
    </div>
</div>

{{-- Statistik Utama --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 25px; margin-bottom: 40px;">
    
    <div style="background: linear-gradient(135deg, #2c9a94 0%, #1a7a75 100%); padding: 25px; border-radius: 16px; color: white; box-shadow: 0 10px 15px -3px rgba(44, 154, 148, 0.3);">
        <div style="display: flex; justify-content: space-between; align-items: center; opacity: 0.9;">
            <span style="font-size: 0.9rem; font-weight: 500;">Total Pendapatan</span>
            <span style="font-size: 1.5rem;">💰</span>
        </div>
        <h2 style="margin: 15px 0 0 0; font-size: 1.8rem;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
    </div>

    <div style="background: white; padding: 25px; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-bottom: 4px solid #f59e0b;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span style="color: #64748b; font-size: 0.9rem; font-weight: 600;">Pesanan Baru</span>
            <span style="background: #fffbeb; color: #f59e0b; padding: 5px 10px; border-radius: 8px; font-size: 0.8rem;">+{{ $totalOrders }}</span>
        </div>
        <h2 style="margin: 15px 0 0 0; color: #1e293b; font-size: 1.8rem;">{{ $totalOrders }} <small style="font-size: 0.9rem; font-weight: 400; color: #94a3b8;">Orders</small></h2>
    </div>

    <div style="background: white; padding: 25px; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-bottom: 4px solid #3b82f6;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span style="color: #64748b; font-size: 0.9rem; font-weight: 600;">Stok Tersedia</span>
            <span style="font-size: 1.2rem;">📦</span>
        </div>
        <h2 style="margin: 15px 0 0 0; color: #1e293b; font-size: 1.8rem;">{{ $totalStock }} <small style="font-size: 0.9rem; font-weight: 400; color: #94a3b8;">Unit</small></h2>
    </div>

</div>

{{-- Baris Grafik Penjualan (Mingguan) --}}
<div style="margin-bottom: 30px; background: white; padding: 30px; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
    <h3 style="margin-top: 0; margin-bottom: 25px; color: #1e293b; font-size: 1.1rem; border-left: 4px solid #3b82f6; padding-left: 15px;">Tren Penjualan (7 Hari Terakhir)</h3>
    <div style="height: 300px;">
        <canvas id="salesChart"></canvas>
    </div>
</div>

{{-- Baris Kedua: Chart Kategori & Statistik Cepat --}}
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
    
    <div style="background: white; padding: 30px; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <h3 style="margin-top: 0; margin-bottom: 25px; color: #1e293b; font-size: 1.1rem; border-left: 4px solid #2c9a94; padding-left: 15px;">Sebaran Produk per Kategori</h3>
        <div style="height: 300px;">
            <canvas id="categoryChart"></canvas>
        </div>
    </div>

    <div style="background: white; padding: 30px; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <h3 style="margin-top: 0; margin-bottom: 20px; color: #1e293b; font-size: 1.1rem;">Statistik Cepat</h3>
        <ul style="list-style: none; padding: 0;">
            <li style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f1f5f9;">
                <span style="color: #64748b;">Total Jenis Produk</span>
                <strong style="color: #1e293b;">{{ $totalProducts }}</strong>
            </li>
            <li style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f1f5f9;">
                <span style="color: #64748b;">Total Kategori</span>
                <strong style="color: #1e293b;">{{ \App\Models\Category::count() }}</strong>
            </li>
        </ul>
        <a href="{{ route('admin.product.list') }}" style="display: block; text-align: center; margin-top: 20px; color: #2c9a94; text-decoration: none; font-weight: 600; font-size: 0.9rem;">Kelola Produk →</a>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 1. Chart Kategori (Bar)
    const ctxCat = document.getElementById('categoryChart').getContext('2d');
    new Chart(ctxCat, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [{
                label: 'Jumlah Produk',
                data: {!! json_encode($chartData['counts']) !!},
                backgroundColor: 'rgba(44, 154, 148, 0.8)',
                hoverBackgroundColor: '#2c9a94',
                borderRadius: 8,
                barThickness: 30,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { display: false }, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            }
        }
    });

    // 2. Chart Penjualan (Line)
    const ctxSales = document.getElementById('salesChart').getContext('2d');
    new Chart(ctxSales, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData['salesLabels']) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($chartData['salesData']) !!},
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#3b82f6'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { 
                    beginAtZero: true,
                    ticks: { callback: function(value) { return 'Rp ' + value.toLocaleString(); } }
                },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endpush
@endsection