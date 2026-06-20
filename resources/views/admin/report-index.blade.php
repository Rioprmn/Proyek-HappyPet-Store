@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-report.css') }}">
@endpush

@section('content')
<div class="report-header">
    <div class="header-content">
        <div>
            <h1 class="report-title">📊 Pusat Laporan HappyPet</h1>
            <p class="report-subtitle">Analisis performa toko Anda secara visual</p>
        </div>
    </div>
</div>

<div class="report-grid">
    
    {{-- Card Harian --}}
    <div class="report-card daily-card" style="animation-delay: 0.1s">
        <div class="card-header">
            <span class="card-icon">📅</span>
            <span class="card-badge">HARIAN</span>
        </div>
        
        <div class="card-content">
            <h3 class="revenue-value">Rp {{ number_format($dailyRevenue, 0, ',', '.') }}</h3>
            <p class="revenue-label">Pendapatan hari ini</p>
        </div>

        <div class="chart-mini">
            <canvas id="miniDailyChart"></canvas>
        </div>

        <a href="{{ route('admin.report.download', 'daily') }}" class="btn-download">
        📥 PDF
        </a>
        <br>
        <a href="{{ route('admin.report.excel', 'daily') }}" class="btn-download">
            📊 Excel
        </a>
    </div>

    {{-- Card Bulanan --}}
    <div class="report-card monthly-card" style="animation-delay: 0.2s">
        <div class="card-header">
            <span class="card-icon">📊</span>
            <span class="card-badge">BULANAN</span>
        </div>
        
        <div class="card-content">
            <h3 class="revenue-value">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</h3>
            <p class="revenue-label">Pendapatan bulan ini</p>
        </div>

        <div class="chart-mini">
            <canvas id="miniMonthlyChart"></canvas>
        </div>

        <a href="{{ route('admin.report.download', 'monthly') }}" class="btn-download">
        📥 PDF
        </a>
        <br>
        <a href="{{ route('admin.report.excel', 'monthly') }}" class="btn-download">
            📊 Excel
        </a>
    </div>

    {{-- Card Tahunan --}}
    <div class="report-card yearly-card" style="animation-delay: 0.3s">
        <div class="card-header">
            <span class="card-icon">📈</span>
            <span class="card-badge">TAHUNAN</span>
        </div>
        
        <div class="card-content">
            <h3 class="revenue-value">Rp {{ number_format($monthlyRevenue * 12, 0, ',', '.') }}</h3>
            <p class="revenue-label">Proyeksi pendapatan tahun ini</p>
        </div>

        <div class="chart-mini">
            <canvas id="miniYearlyChart"></canvas>
        </div>

        <a href="{{ route('admin.report.download', 'yearly') }}" class="btn-download">
        📥 PDF
        </a>
        <br>
        <a href="{{ route('admin.report.excel', 'yearly') }}" class="btn-download">
            📊 Excel
        </a>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
    Chart.defaults.color = '#64748b';

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
                borderColor: '#ef4444',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                pointBackgroundColor: '#ef4444',
                pointBorderColor: 'white',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
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
                borderRadius: 6,
                borderSkipped: false
            }]
        },
        options: chartOptions
    });

    // Grafik Mini Tahunan
    new Chart(document.getElementById('miniYearlyChart'), {
        type: 'doughnut',
        data: {
            labels: ['Pendapatan', 'Target'],
            datasets: [{
                data: [{!! json_encode($monthlyRevenue * 12) !!}, 100000000],
                backgroundColor: ['#8b5cf6', '#e5e7eb'],
                borderColor: 'white',
                borderWidth: 2
            }]
        },
        options: chartOptions
    });
</script>
@endpush
@endsection
