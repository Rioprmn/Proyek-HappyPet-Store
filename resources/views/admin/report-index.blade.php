@extends('layouts.admin')

@section('content')
<h1 style="color: #1e293b; font-weight: 700;">Pusat Laporan HappyPet</h1>
<p style="color: #64748b; margin-bottom: 30px;">Analisis performa toko Anda secara visual.</p>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 25px;">
    
    {{-- Card Harian --}}
    <div style="background: white; padding: 25px; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <span style="font-size: 1.5rem;">📅</span>
            <span style="background: #f1f5f9; padding: 4px 10px; border-radius: 8px; font-size: 0.75rem; font-weight: bold; color: #64748b;">HARIAN</span>
        </div>
        <h3 style="margin: 0; color: #1e293b;">Rp {{ number_format($dailyRevenue, 0, ',', '.') }}</h3>
        <p style="color: #94a3b8; font-size: 0.85rem; margin-bottom: 20px;">Pendapatan hari ini</p>
        <div style="height: 100px; margin-bottom: 20px;">
            <canvas id="miniDailyChart"></canvas>
        </div>
        <a href="{{ route('admin.report.download', 'daily') }}" style="display: block; text-align: center; padding: 12px; background: #ef4444; color: white; text-decoration: none; border-radius: 12px; font-weight: 600;">Download PDF</a>
    </div>

    {{-- Card Bulanan --}}
    <div style="background: white; padding: 25px; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <span style="font-size: 1.5rem;">📊</span>
            <span style="background: #f1f5f9; padding: 4px 10px; border-radius: 8px; font-size: 0.75rem; font-weight: bold; color: #64748b;">BULANAN</span>
        </div>
        <h3 style="margin: 0; color: #1e293b;">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</h3>
        <p style="color: #94a3b8; font-size: 0.85rem; margin-bottom: 20px;">Pendapatan bulan ini</p>
        <div style="height: 100px; margin-bottom: 20px;">
            <canvas id="miniMonthlyChart"></canvas>
        </div>
        <a href="{{ route('admin.report.download', 'monthly') }}" style="display: block; text-align: center; padding: 12px; background: #ef4444; color: white; text-decoration: none; border-radius: 12px; font-weight: 600;">Download PDF</a>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: { x: { display: false }, y: { display: false } },
        elements: { point: { radius: 0 } }
    };

    // Grafik Mini Harian
    new Chart(document.getElementById('miniDailyChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($dailyLabels) !!},
            datasets: [{
                data: {!! json_encode($dailyData) !!},
                borderColor: '#2c9a94',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                backgroundColor: 'rgba(44, 154, 148, 0.1)'
            }]
        },
        options: chartOptions
    });

    // Grafik Mini Bulanan
    new Chart(document.getElementById('miniMonthlyChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($monthlyLabels) !!},
            datasets: [{
                data: {!! json_encode($monthlyData) !!},
                backgroundColor: '#3b82f6',
                borderRadius: 4
            }]
        },
        options: chartOptions
    });
</script>
@endpush
@endsection