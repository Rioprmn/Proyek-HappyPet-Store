@extends('layouts.admin')

@section('content')
<div class="dashboard-header">
    <div class="header-content">
        <div>
            <h1 class="dashboard-title">Dashboard Overview</h1>
            <p class="dashboard-subtitle">Ringkasan aktivitas toko HappyPet hari ini</p>
        </div>
        <div class="header-date">
            📅 {{ date('d M Y') }}
        </div>
    </div>
</div>

{{-- Statistik Utama (Top Cards) --}}
<div class="stats-grid">
    <div class="stat-card revenue-card" style="animation-delay: 0.1s">
        <div class="card-header">
            <span class="card-label">Total Pendapatan</span>
            <span class="card-icon">💰</span>
        </div>
        <h2 class="card-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
        <p class="card-subtitle">Dari semua transaksi</p>
    </div>

    <div class="stat-card orders-card" style="animation-delay: 0.2s">
        <div class="card-header">
            <span class="card-label">Pesanan Berhasil</span>
            <span class="card-badge">Total</span>
        </div>
        <h2 class="card-value">{{ $totalOrders }}</h2>
        <p class="card-subtitle">Orders selesai</p>
    </div>

    <div class="stat-card stock-card" style="animation-delay: 0.3s">
        <div class="card-header">
            <span class="card-label">Produk & Stok</span>
            <span class="card-icon">📦</span>
        </div>
        <h2 class="card-value">{{ $totalStock }}</h2>
        <p class="card-subtitle">Unit tersedia</p>
    </div>

    <div class="stat-card products-card" style="animation-delay: 0.4s">
        <div class="card-header">
            <span class="card-label">Jenis Produk</span>
            <span class="card-icon">🏷️</span>
        </div>
        <h2 class="card-value">{{ $totalProducts }}</h2>
        <p class="card-subtitle">Produk aktif</p>
    </div>
</div>

{{-- Main Charts Area --}}
<div class="charts-grid">
    <div class="chart-card" style="animation-delay: 0.5s">
        <div class="chart-header">
            <h3 class="chart-title">📈 Tren Penjualan (7 Hari Terakhir)</h3>
        </div>
        <div class="chart-container">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <div class="chart-card low-stock-card" style="animation-delay: 0.6s">
        <div class="chart-header">
            <h3 class="chart-title">⚠️ Stok Menipis</h3>
        </div>
        <div class="low-stock-list">
            @forelse($lowStockProducts as $low)
                <div class="stock-item">
                    <div class="stock-info">
                        <span class="stock-name">{{ $low->name }}</span>
                        <span class="stock-category">{{ $low->category }}</span>
                    </div>
                    <span class="stock-badge">{{ $low->stock }}</span>
                </div>
            @empty
                <div class="empty-state">
                    @if(\App\Models\Product::count() == 0)
                        <span class="empty-icon">📦</span>
                        <p>Belum ada produk terdaftar</p>
                    @else
                        <span class="empty-icon">✅</span>
                        <p>Semua stok aman!</p>
                    @endif
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Lower Section --}}
<div class="lower-grid">
    <div class="chart-card" style="animation-delay: 0.7s">
        <div class="chart-header">
            <h3 class="chart-title">📊 Produk per Kategori</h3>
        </div>
        <div class="chart-container">
            <canvas id="categoryChart"></canvas>
        </div>
    </div>

    <div class="info-card" style="animation-delay: 0.8s">
        <div class="chart-header">
            <h3 class="chart-title">ℹ️ Informasi Cepat</h3>
        </div>
        <div class="info-list">
            <div class="info-item">
                <span class="info-label">Jenis Produk</span>
                <strong class="info-value">{{ $totalProducts }}</strong>
            </div>
            <div class="info-item">
                <span class="info-label">Total Kategori</span>
                <strong class="info-value">{{ \App\Models\Category::count() }}</strong>
            </div>
            <div class="info-item">
                <span class="info-label">Total Pesanan</span>
                <strong class="info-value">{{ $totalOrders }}</strong>
            </div>
            <a href="{{ route('admin.product.list') }}" class="btn-manage">
                Kelola Semua Produk →
            </a>
        </div>
    </div>
</div>

<style>
    .dashboard-header {
        margin-bottom: 40px;
        animation: slideInDown 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
    }

    .dashboard-title {
        font-size: 2.2rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 8px;
        background: linear-gradient(135deg, #1e293b 0%, #2c9a94 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .dashboard-subtitle {
        color: #64748b;
        font-size: 1rem;
    }

    .header-date {
        background: white;
        padding: 12px 24px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        font-weight: 700;
        color: #2c9a94;
        border: 2px solid #e2e8f0;
        white-space: nowrap;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: white;
        padding: 28px;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        border: 2px solid #e2e8f0;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        animation: fadeInUp 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        opacity: 0;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #2c9a94, #1a7a75);
    }

    .stat-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 40px rgba(44, 154, 148, 0.15);
        border-color: #2c9a94;
    }

    .revenue-card::before {
        background: linear-gradient(90deg, #2c9a94, #1a7a75);
    }

    .orders-card::before {
        background: linear-gradient(90deg, #f59e0b, #d97706);
    }

    .stock-card::before {
        background: linear-gradient(90deg, #3b82f6, #1d4ed8);
    }

    .products-card::before {
        background: linear-gradient(90deg, #8b5cf6, #6d28d9);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .card-label {
        font-size: 0.9rem;
        color: #64748b;
        font-weight: 600;
    }

    .card-icon {
        font-size: 1.5rem;
    }

    .card-badge {
        background: #fffbeb;
        color: #f59e0b;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .card-value {
        font-size: 1.8rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .card-subtitle {
        font-size: 0.85rem;
        color: #94a3b8;
        margin: 0;
    }

    /* Charts Grid */
    .charts-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 25px;
        margin-bottom: 40px;
    }

    .chart-card {
        background: white;
        padding: 28px;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        border: 2px solid #e2e8f0;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        animation: fadeInUp 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        opacity: 0;
    }

    .chart-card:hover {
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        transform: translateY(-8px);
    }

    .chart-header {
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid #e2e8f0;
    }

    .chart-title {
        font-size: 1.1rem;
        color: #1e293b;
        font-weight: 700;
        margin: 0;
    }

    .chart-container {
        height: 320px;
        position: relative;
    }

    .low-stock-card {
        grid-column: auto;
    }

    .low-stock-list {
        max-height: 320px;
        overflow-y: auto;
        padding-right: 8px;
    }

    .stock-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 0;
        border-bottom: 1px solid #f1f5f9;
        animation: fadeInUp 0.6s ease-out;
    }

    .stock-item:last-child {
        border-bottom: none;
    }

    .stock-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .stock-name {
        font-weight: 600;
        color: #334155;
        font-size: 0.9rem;
    }

    .stock-category {
        color: #94a3b8;
        font-size: 0.8rem;
    }

    .stock-badge {
        background: #fef2f2;
        color: #ef4444;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #94a3b8;
    }

    .empty-icon {
        font-size: 2.5rem;
        display: block;
        margin-bottom: 10px;
    }

    /* Lower Grid */
    .lower-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 25px;
    }

    .info-card {
        background: white;
        padding: 28px;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        border: 2px solid #e2e8f0;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        animation: fadeInUp 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        opacity: 0;
    }

    .info-card:hover {
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        transform: translateY(-8px);
    }

    .info-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px;
        background: #f8fafc;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .info-item:hover {
        background: #f0f4f8;
        transform: translateX(4px);
    }

    .info-label {
        color: #64748b;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .info-value {
        font-size: 1.2rem;
        color: #2c9a94;
    }

    .btn-manage {
        display: block;
        text-align: center;
        padding: 12px;
        background: linear-gradient(135deg, #2c9a94 0%, #1a7a75 100%);
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 700;
        transition: all 0.3s ease;
        margin-top: 8px;
        box-shadow: 0 4px 12px rgba(44, 154, 148, 0.2);
    }

    .btn-manage:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(44, 154, 148, 0.3);
    }

    /* Animations */
    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .charts-grid {
            grid-template-columns: 1fr;
        }

        .lower-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-title {
            font-size: 1.8rem;
        }
    }

    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
        }

        .header-date {
            width: 100%;
            text-align: center;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .stat-card {
            padding: 20px;
        }

        .card-value {
            font-size: 1.5rem;
        }

        .dashboard-title {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .stat-card {
            padding: 16px;
        }

        .card-value {
            font-size: 1.3rem;
        }

        .chart-container {
            height: 250px;
        }

        .dashboard-title {
            font-size: 1.3rem;
        }

        .dashboard-subtitle {
            font-size: 0.9rem;
        }
    }
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
    Chart.defaults.color = '#64748b';

    // Category Chart
    new Chart(document.getElementById('categoryChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [{
                data: {!! json_encode($chartData['counts']) !!},
                backgroundColor: [
                    '#2c9a94',
                    '#3b82f6',
                    '#f59e0b',
                    '#8b5cf6',
                    '#ef4444',
                    '#10b981'
                ],
                borderRadius: 8,
                barThickness: 30,
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

    // Sales Chart
    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData['salesLabels']) !!},
            datasets: [{
                label: 'Omzet',
                data: {!! json_encode($chartData['salesData']) !!},
                borderColor: '#2c9a94',
                backgroundColor: 'rgba(44, 154, 148, 0.08)',
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointHoverRadius: 8,
                pointBackgroundColor: '#2c9a94',
                pointBorderColor: 'white',
                pointBorderWidth: 2,
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
