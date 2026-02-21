@extends('layouts.admin')

@section('content')
{{-- Header --}}
<div class="header-section" style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 style="margin: 0; color: #1e293b; font-weight: 700; font-size: 1.75rem;">Dashboard Overview</h1>
        <p style="color: #64748b; margin-top: 5px;">Ringkasan aktivitas toko HappyPet hari ini.</p>
    </div>
    <div style="background: white; padding: 12px 24px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); font-weight: 700; color: #2c9a94; border: 1px solid #f1f5f9;">
        📅 {{ date('d M Y') }}
    </div>
</div>

{{-- Statistik Utama (Top Cards) --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px; margin-bottom: 30px;">
    
    <div style="background: linear-gradient(135deg, #2c9a94 0%, #1a7a75 100%); padding: 25px; border-radius: 16px; color: white; box-shadow: 0 10px 15px -3px rgba(44, 154, 148, 0.3);">
        <div style="display: flex; justify-content: space-between; align-items: center; opacity: 0.9;">
            <span style="font-size: 0.9rem; font-weight: 500;">Total Pendapatan</span>
            <span style="font-size: 1.5rem;">💰</span>
        </div>
        <h2 style="margin: 15px 0 0 0; font-size: 1.8rem; font-weight: 700;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
    </div>

    <div style="background: white; padding: 25px; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-left: 6px solid #f59e0b;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span style="color: #64748b; font-size: 0.9rem; font-weight: 600;">Pesanan Berhasil</span>
            <span style="background: #fffbeb; color: #f59e0b; padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700;">Total</span>
        </div>
        <h2 style="margin: 15px 0 0 0; color: #1e293b; font-size: 1.8rem;">{{ $totalOrders }} <small style="font-size: 0.9rem; font-weight: 400; color: #94a3b8;">Orders</small></h2>
    </div>

    <div style="background: white; padding: 25px; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-left: 6px solid #3b82f6;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span style="color: #64748b; font-size: 0.9rem; font-weight: 600;">Produk & Stok</span>
            <span style="font-size: 1.2rem;">📦</span>
        </div>
        <h2 style="margin: 15px 0 0 0; color: #1e293b; font-size: 1.8rem;">{{ $totalStock }} <small style="font-size: 0.9rem; font-weight: 400; color: #94a3b8;">Unit</small></h2>
    </div>

</div>

{{-- Main Charts Area --}}
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 25px; margin-bottom: 30px;">
    
    {{-- Grafik Penjualan --}}
    <div style="background: white; padding: 25px; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <h3 style="margin: 0 0 25px 0; color: #1e293b; font-size: 1.1rem; display: flex; align-items: center; gap: 10px;">
            <span style="width: 4px; height: 20px; background: #3b82f6; border-radius: 10px;"></span>
            Tren Penjualan (7 Hari Terakhir)
        </h3>
        <div style="height: 320px;">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    {{-- Kolom Kanan: Stok Menipis --}}
    <div style="background: white; padding: 25px; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden;">
        <h3 style="margin: 0 0 20px 0; color: #1e293b; font-size: 1.1rem; display: flex; align-items: center; gap: 10px;">
            <span style="width: 4px; height: 20px; background: #ef4444; border-radius: 10px;"></span>
            Stok Menipis ⚠️
        </h3>
        <div style="max-height: 320px; overflow-y: auto; padding-right: 5px;">
            <table style="width: 100%; border-collapse: collapse;">
                @forelse($lowStockProducts as $low)
                <tr style="border-bottom: 1px solid #f8fafc;">
                    <td style="padding: 12px 0;">
                        <span style="display: block; font-weight: 600; color: #334155; font-size: 0.9rem;">{{ $low->name }}</span>
                        <small style="color: #94a3b8;">{{ $low->category }}</small>
                    </td>
                    <td style="text-align: right;">
                        <span style="background: #fef2f2; color: #ef4444; padding: 4px 10px; border-radius: 6px; font-weight: 700; font-size: 0.85rem;">{{ $low->stock }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" style="text-align: center; color: #94a3b8; padding: 40px 0;">
                        @if(\App\Models\Product::count() == 0)
                            <span style="font-size: 2rem; display: block; margin-bottom: 10px;">📦</span>
                            Belum ada produk terdaftar.
                        @else
                            <span style="font-size: 2rem; display: block; margin-bottom: 10px;">✅</span>
                            Semua stok aman!
                        @endif
                    </td>
                </tr>
                @endforelse
            </table>
        </div>
    </div>

</div>

{{-- Lower Section --}}
<div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 25px;">
    
    {{-- Sebaran Kategori --}}
    <div style="background: white; padding: 25px; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <h3 style="margin: 0 0 25px 0; color: #1e293b; font-size: 1.1rem; display: flex; align-items: center; gap: 10px;">
            <span style="width: 4px; height: 20px; background: #2c9a94; border-radius: 10px;"></span>
            Produk per Kategori
        </h3>
        <div style="height: 250px;">
            <canvas id="categoryChart"></canvas>
        </div>
    </div>

    {{-- Statistik Tambahan --}}
    <div style="background: white; padding: 25px; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <h3 style="margin: 0 0 20px 0; color: #1e293b; font-size: 1.1rem;">Informasi Cepat</h3>
        <div style="display: flex; flex-direction: column; gap: 15px;">
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: #f8fafc; border-radius: 12px;">
                <span style="color: #64748b; font-size: 0.9rem;">Jenis Produk</span>
                <strong style="font-size: 1.1rem; color: #1e293b;">{{ $totalProducts }}</strong>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: #f8fafc; border-radius: 12px;">
                <span style="color: #64748b; font-size: 0.9rem;">Total Kategori</span>
                <strong style="font-size: 1.1rem; color: #1e293b;">{{ \App\Models\Category::count() }}</strong>
            </div>
            <a href="{{ route('admin.product.list') }}" style="text-align: center; padding: 12px; background: #2c9a94; color: white; text-decoration: none; border-radius: 10px; font-weight: 600; margin-top: 10px; transition: 0.3s;">
                Kelola Semua Produk →
            </a>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Config Chart Default
    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
    Chart.defaults.color = '#64748b';

    // 1. Chart Kategori (Bar)
    new Chart(document.getElementById('categoryChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [{
                data: {!! json_encode($chartData['counts']) !!},
                backgroundColor: '#2c9a94',
                borderRadius: 6,
                barThickness: 25,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [5, 5] }, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            }
        }
    });

    // 2. Chart Penjualan (Line)
    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData['salesLabels']) !!},
            datasets: [{
                label: 'Omzet',
                data: {!! json_encode($chartData['salesData']) !!},
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.05)',
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 8,
                pointBackgroundColor: '#3b82f6',
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.raw.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    grid: { borderDash: [5, 5] },
                    ticks: { callback: function(value) { return 'Rp ' + (value/1000) + 'k'; } }
                },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endpush
@endsection