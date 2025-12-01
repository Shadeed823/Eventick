@extends('shared.app_user')

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(10, 73, 127, 0.1); color: var(--primary-color);">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <div class="stat-value">{{ $ticketsSold }}</div>
            <div class="stat-label">Total Tickets Sold</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(255, 107, 53, 0.1); color: var(--accent-color);">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-value">SAR {{ number_format($revenue, 2) }}</div>
            <div class="stat-label">Revenue</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(40, 167, 69, 0.1); color: #28a745;">
                <i class="fas fa-layer-group"></i>
            </div>
            <div class="stat-value">{{ $activeListings }}</div>
            <div class="stat-label">Active Listings</div>
        </div>
    </div>

    <div class="chart-container mt-4">
        <div class="chart-header d-flex justify-content-between align-items-center">
            <h2 class="chart-title">Monthly Revenue</h2>
        </div>
        <canvas id="revenueChart" height="100"></canvas>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('revenueChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Revenue (SAR)',
                        data: @json($chartData),
                        backgroundColor: 'rgba(10, 73, 127, 0.1)',
                        borderColor: '#0a497f',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(0, 0, 0, 0.05)' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        });
    </script>
@endpush
