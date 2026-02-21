@extends('layouts.admin')

@section('content')
<div class="header-section" style="margin-bottom: 30px;">
    <h1 style="margin: 0; color: #1e293b;">Dashboard Overview</h1>
    <p style="color: #64748b;">Ringkasan data HappyPet Store hari ini.</p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px;">
    <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-left: 5px solid #2c9a94;">
        <span style="color: #64748b; font-size: 0.9rem;">Total Produk</span>
        <h2 style="margin: 10px 0 0 0; color: #1e293b;">{{ $totalProducts }}</h2>
    </div>
    <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-left: 5px solid #3b82f6;">
        <span style="color: #64748b; font-size: 0.9rem;">Total Stok</span>
        <h2 style="margin: 10px 0 0 0; color: #1e293b;">{{ $totalStock }} <small style="font-size: 0.8rem; color: #94a3b8;">pcs</small></h2>
    </div>
    <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-left: 5px solid #f59e0b;">
        <span style="color: #64748b; font-size: 0.9rem;">Kategori</span>
        <h2 style="margin: 10px 0 0 0; color: #1e293b;">{{ \App\Models\Category::count() }}</h2>
    </div>
</div>

<div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
    <h3 style="margin-top: 0; margin-bottom: 20px; color: #1e293b;">Produk per Kategori</h3>
    <div style="max-height: 400px;">
        <canvas id="categoryChart"></canvas>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('categoryChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [{
                label: 'Jumlah Produk',
                data: {!! json_encode($chartData['counts']) !!},
                backgroundColor: '#2c9a94',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
</script>
@endpush
@endsection