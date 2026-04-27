@extends('layouts.app')

@section('content')
<div class="dashboard-header mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $title_page }}</h1>
    <p class="text-muted">Ringkasan data kunjungan dan pembayaran asuransi.</p>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="fas fa-users text-primary fs-4"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle text-muted mb-1">Total Kunjungan</h6>
                        <h3 class="card-title mb-0 fw-bold">{{ number_format($stats['total_transactions']) }}</h3>
                    </div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-primary" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0 bg-success bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="fas fa-wallet text-success fs-4"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle text-muted mb-1">Total Pembayaran</h6>
                        <h3 class="card-title mb-0 fw-bold">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
                    </div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-success" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0 bg-info bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="fas fa-handshake text-info fs-4"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle text-muted mb-1">Mitra Asuransi</h6>
                        <h3 class="card-title mb-0 fw-bold">{{ number_format($stats['total_insurance_partners']) }}</h3>
                    </div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-info" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0 bg-warning bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="fas fa-check-circle text-warning fs-4"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle text-muted mb-1">Status Lunas</h6>
                        <h3 class="card-title mb-0 fw-bold">{{ number_format($stats['paid_transactions']) }}</h3>
                    </div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-warning" style="width: {{ $stats['total_transactions'] > 0 ? ($stats['paid_transactions'] / $stats['total_transactions'] * 100) : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Visits Chart -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-transparent border-0 p-4">
                <h5 class="card-title mb-0">Top 5 Asuransi (Kunjungan Terbanyak)</h5>
            </div>
            <div class="card-body p-4">
                <canvas id="visitsChart" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Payments Chart -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-transparent border-0 p-4">
                <h5 class="card-title mb-0">Top 5 Asuransi (Pembayaran Tertinggi)</h5>
            </div>
            <div class="card-body p-4">
                <canvas id="paymentsChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Monthly Revenue Chart -->
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-transparent border-0 p-4">
                <h5 class="card-title mb-0">Tren Pendapatan Bulanan ({{ date('Y') }})</h5>
            </div>
            <div class="card-body p-4">
                <canvas id="revenueChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Config for Charts
    const colors = [
        'rgba(13, 110, 253, 0.8)',
        'rgba(25, 135, 84, 0.8)',
        'rgba(13, 202, 240, 0.8)',
        'rgba(255, 193, 7, 0.8)',
        'rgba(220, 53, 69, 0.8)'
    ];

    // Insurance Visits Chart (Pie)
    const visitsData = @json($insurance_visits);
    new Chart(document.getElementById('visitsChart'), {
        type: 'doughnut',
        data: {
            labels: visitsData.map(d => d.insurance_name || 'Umum'),
            datasets: [{
                data: visitsData.map(d => d.total_visits),
                backgroundColor: colors,
                borderWidth: 0
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            cutout: '70%'
        }
    });

    // Insurance Payments Chart (Bar)
    const paymentsData = @json($insurance_payments);
    new Chart(document.getElementById('paymentsChart'), {
        type: 'bar',
        data: {
            labels: paymentsData.map(d => d.insurance_name || 'Umum'),
            datasets: [{
                label: 'Total Pembayaran',
                data: paymentsData.map(d => d.total_payments),
                backgroundColor: 'rgba(13, 110, 253, 0.6)',
                borderColor: 'rgb(13, 110, 253)',
                borderWidth: 1,
                borderRadius: 8
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Total: Rp ' + context.raw.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

    // Monthly Revenue Chart (Line)
    const revenueData = @json($monthly_revenue);
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    
    // Map data to all months
    const monthlyValues = new Array(12).fill(0);
    revenueData.forEach(d => {
        monthlyValues[d.month - 1] = d.total_revenue;
    });

    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Pendapatan',
                data: monthlyValues,
                fill: true,
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                borderColor: 'rgb(13, 110, 253)',
                tension: 0.4,
                pointBackgroundColor: 'rgb(13, 110, 253)',
                pointRadius: 4
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Pendapatan: Rp ' + context.raw.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>
@endpush

<style>
    .card {
        transition: transform 0.2s ease-in-out;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .progress-sm {
        height: 4px;
    }
    canvas {
        max-width: 100%;
    }
</style>
@endsection
