<!-- resources/views/user/dashboard.blade.php -->

@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6">User Dashboard</h1>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
        <div class="bg-white shadow rounded-2xl p-4 flex items-center">
            <div class="text-blue-600 mr-4">
                <i class="fas fa-ticket-alt text-3xl"></i>
            </div>
            <div>
                <div class="text-sm text-gray-500">Total Tickets</div>
                <div class="text-xl font-bold">34</div>
            </div>
        </div>
        <div class="bg-white shadow rounded-2xl p-4 flex items-center">
            <div class="text-yellow-500 mr-4">
                <i class="fas fa-exclamation-circle text-3xl"></i>
            </div>
            <div>
                <div class="text-sm text-gray-500">Open Tickets</div>
                <div class="text-xl font-bold">12</div>
            </div>
        </div>
        <div class="bg-white shadow rounded-2xl p-4 flex items-center">
            <div class="text-red-500 mr-4">
                <i class="fas fa-clock text-3xl"></i>
            </div>
            <div>
                <div class="text-sm text-gray-500">Overdue Tickets</div>
                <div class="text-xl font-bold">3</div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white shadow rounded-2xl p-6">
            <h2 class="text-lg font-semibold mb-4">Tickets by Status</h2>
            <div id="statusChart"></div>
        </div>

        <div class="bg-white shadow rounded-2xl p-6">
            <h2 class="text-lg font-semibold mb-4">Tickets by Priority</h2>
            <div id="priorityChart"></div>
        </div>
    </div>

    <div class="bg-white shadow rounded-2xl p-6 mt-6">
        <h2 class="text-lg font-semibold mb-4">Monthly Ticket Trends</h2>
        <div id="trendChart"></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Status Donut Chart
    var statusChart = new ApexCharts(document.querySelector("#statusChart"), {
        chart: { type: 'donut' },
        series: [10, 12, 5, 7],
        labels: ['Open', 'In Progress', 'Resolved', 'Closed'],
        colors: ['#facc15', '#3b82f6', '#10b981', '#6b7280']
    });
    statusChart.render();

    // Priority Bar Chart
    var priorityChart = new ApexCharts(document.querySelector("#priorityChart"), {
        chart: { type: 'bar' },
        series: [{
            name: 'Tickets',
            data: [8, 14, 12]
        }],
        xaxis: {
            categories: ['Normal', 'High', 'Critical']
        },
        colors: ['#10b981', '#f97316', '#ef4444']
    });
    priorityChart.render();

    // Monthly Trend Line Chart
    var trendChart = new ApexCharts(document.querySelector("#trendChart"), {
        chart: { type: 'line' },
        series: [
            {
                name: 'Created',
                data: [5, 10, 15, 20, 25, 30]
            },
            {
                name: 'Resolved',
                data: [3, 8, 12, 18, 20, 28]
            }
        ],
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
        },
        colors: ['#3b82f6', '#10b981']
    });
    trendChart.render();
</script>
@endpush
