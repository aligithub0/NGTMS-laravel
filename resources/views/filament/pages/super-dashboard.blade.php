<x-filament::page>
<style>
        /* Basic container padding */
        .dashboard-container {
            padding: 20px 15px;
        }
        /* Banner styles */
        .top-banner {
            background: #f3f4f6;
            border-radius: 12px;
            padding: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        .banner-text {
            max-width: 60%;
        }
        .banner-text h2 {
            color: #2563eb;
            font-weight: 600;
            margin-bottom: 8px;
        }
        .banner-text p {
            color: #4b5563;
            font-size: 14px;
        }
        .banner-btn {
            border: 1px solid #2563eb;
            padding: 6px 15px;
            border-radius: 6px;
            color: #2563eb;
            font-weight: 500;
            cursor: pointer;
            background: white;
            transition: background 0.3s ease;
        }
        .banner-btn:hover {
            background: #2563eb;
            color: white;
        }
        .banner-img img {
            max-height: 120px;
        }

        /* KPI small cards on right */
        .kpi-container {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    margin-bottom: 45px;
}

.kpi-card {
    flex: 1 1 200px;
    border-radius: 12px;
    color: white;
    padding: 20px 25px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-height: 120px;
    box-shadow: 0 8px 20px rgb(0 0 0 / 0.12);
    position: relative;
    overflow: hidden;
    cursor: default;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.kpi-label {
    font-weight: 600;
    font-size: 1rem;
    opacity: 0.9;
    margin-bottom: 8px;
}

.kpi-value {
    font-size: 2.8rem;
    font-weight: 700;
    line-height: 1;
}

.kpi-subtext {
    font-weight: 500;
    font-size: 0.875rem;
    opacity: 0.8;
    margin-top: 6px;
}

/* Dropdown for Bounce Rate card */
.kpi-dropdown {
    margin-top: 8px;
    background: rgba(255 255 255 / 0.3);
    border: none;
    border-radius: 6px;
    padding: 4px 10px;
    font-weight: 600;
    color: white;
    width: 100px;
    cursor: pointer;
}

/* Color variations */
.pink {
    background: linear-gradient(135deg, #f72585, #b5179e);
}

.purple {
    background: linear-gradient(135deg, #720026, #141E30);
}

.blue {
    background: linear-gradient(135deg, #00B4DB, #0083B0);
}

.orange {
    background: linear-gradient(135deg, #f7971e, #ffd200);
}


        /* Main content grid */
        .content-grid {
            display: grid;
            grid-template-columns: 2.5fr 1fr;
            gap: 20px;
            width: 100%;
            min-width: 0;
        }

        /* Important: Fix to ensure child divs get full width inside grid */
        .content-grid > div {
            width: 100%;
            min-width: 0; /* avoid flexbox/grid shrinking issues */
        }

        /* Card styles for main charts and stats */
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgb(0 0 0 / 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .card-header {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 15px;
        }

    .recent-tickets-journey-card {
        max-height: 404px;
        overflow-y: auto;
        padding-right: 10px;
        }

        .ticket-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
        }

        .ticket-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding-bottom: 6px;
        border-bottom: 1px solid #eee;
        }

        .status-dot {
        width: 15px;
        height: 15px;
        border-radius: 50%;
        margin-top: 6px;
        flex-shrink: 0;
        }

        .ticket-info {
        flex-grow: 1;
        min-width: 0;
        }

        .ticket-id {
        font-weight: 600;
        font-size: 1rem;
        color: #111827;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        }

        .ticket-desc {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 3px;
        white-space: normal;
        word-break: break-word;
        }

        .ticket-status {
        font-weight: 700;
        font-size: 0.875rem;
        min-width: 80px;
        text-align: right;
        white-space: nowrap;
        flex-shrink: 0;
        line-height: 1.2;
        }

        /* Status Colors */
        .ticket-item.open .status-dot,
        .ticket-item.open .ticket-status {
        background-color: #2563eb;
        color: #2563eb;
        }

        .ticket-item.in-progress .status-dot,
        .ticket-item.in-progress .ticket-status {
        background-color: #f59e0b;
        color: #f59e0b;
        }

        .ticket-item.closed .status-dot,
        .ticket-item.closed .ticket-status {
        background-color: #22c55e;
        color: #22c55e;
        }

        .ticket-item.overdue .status-dot,
        .ticket-item.overdue .ticket-status {
        background-color: #ef4444;
        color: #ef4444;
        }

        .ticket-item.on-hold .status-dot,
        .ticket-item.on-hold .ticket-status {
        background-color: #3b82f6;
        color: #3b82f6;
        }


</style>

<div class="dashboard-container">
    <!-- Top Banner -->
    <div class="top-banner">
        <div class="banner-text">
            <h2>Congratulations John! 🎉</h2>
            <p>You have handled 128 tickets today.<br>Keep up the great work in supporting users.</p>
            <button class="banner-btn">View Tickets</button>
        </div>
        <div class="banner-img">
            <img src="https://cdn-icons-png.flaticon.com/512/4305/4305529.png" alt="Person working">
        </div>
    </div>

    <!-- Main Grid -->
    <div class="content-grid">
        <!-- Left: Charts & stats -->
        <div>
            <div class="card">
                <div class="card-header">Tickets Overview</div>
                <div id="totalRevenueChart" style="height: 260px; width: 100%;"></div>
            </div>

            <div class="card" style="display: flex; gap: 20px;">
                <div style="flex: 1; width: 100%;">
                    <div id="growthGauge" style="height: 160px; width: 100%;"></div>
                    <div style="text-align: center; font-weight: 600; margin-top: -10px;">
                        62% SLA Compliance
                    </div>
                    <div style="display:flex; justify-content: center; gap: 15px; margin-top: 10px;">
                        <div style="background:#eef2ff; padding: 6px 10px; border-radius: 6px; font-weight: 600; font-size: 13px;">
                            5 SLAs
                        </div>
                        <div style="background:#e0f2fe; padding: 6px 10px; border-radius: 6px; font-weight: 600; font-size: 13px;">
                            4 Priorities
                        </div>
                    </div>
                </div>
                <div style="flex: 1; margin-left: 10px; width: 100%;">
                    <div class="card-header" style="font-size: 1rem;">Ticket Stats</div>
                    <div id="orderStatsDonut" style="height: 140px; width: 100%;"></div>
                </div>
            </div>

            <div class="card" style="margin-top: 10px;">
                <div class="card-header">User & Ticket Activity (ApexCharts)</div>
                <div id="incomeChart" style="height: 180px; width: 100%;"></div>

                <div style="font-weight: 700; font-size: 1.3rem; margin-top: 15px;">Current Stats</div>
                <div style="color:#22c55e; font-weight: 600;">
                    42 Users, 7 Designations, 9 Ticket Journeys
                </div>
                <div style="font-size: 13px; margin-top: 10px;">Active ticket handling and user management ongoing.</div>
            </div>

           

            <!-- New ECharts Pie Chart -->
            <div class="card" style="margin-top: 10px;">
                <div class="card-header">Ticket Status Breakdown</div>
                <div id="echartsPie" style="width: 100%; height: 260px;"></div>
            </div>
        </div>

        <!-- Right: KPI cards and Tickets Journey -->
        <div>
        <div class="kpi-container">
    <div class="kpi-card pink">
        <div class="kpi-label">Total Tickets</div>
        <div class="kpi-value">128 </div>
    </div>
    <div class="kpi-card purple">
        <div class="kpi-label">Users</div>
        <div class="kpi-value">42 </div>
    </div>
    <div class="kpi-card blue">
        <div class="kpi-label">Companies</div>
        <div class="kpi-value">18</div>
    </div>
    <div class="kpi-card orange">
        <div class="kpi-label">Departments</div>
        <div class="kpi-value">6</div>
    </div>
    <!-- <div class="kpi-card teal">
        <div class="kpi-label">Projects</div>
        <div class="kpi-value">11 </div>
    </div> -->
</div>


            <div class="card recent-tickets-journey-card">
                <div class="card-header">Recent Tickets Journey</div>
                <div class="ticket-list">
                    <div class="ticket-item open">
                        <div class="status-dot"></div>
                        <div class="ticket-info">
                            <div class="ticket-id">Ticket #128</div>
                            <div class="ticket-desc">New - Assigned to John</div>
                        </div>
                        <div class="ticket-status">Open</div>
                    </div>
                    <div class="ticket-item in-progress">
                        <div class="status-dot"></div>
                        <div class="ticket-info">
                            <div class="ticket-id">Ticket #122</div>
                            <div class="ticket-desc">In Progress - Assigned to Alice</div>
                        </div>
                        <div class="ticket-status">In Progress</div>
                    </div>
                    <div class="ticket-item closed">
                        <div class="status-dot"></div>
                        <div class="ticket-info">
                            <div class="ticket-id">Ticket #110</div>
                            <div class="ticket-desc">Closed - Resolved by Mark</div>
                        </div>
                        <div class="ticket-status">Closed</div>
                    </div>
                    <div class="ticket-item overdue">
                        <div class="status-dot"></div>
                        <div class="ticket-info">
                            <div class="ticket-id">Ticket #99</div>
                            <div class="ticket-desc">Overdue - Pending response</div>
                        </div>
                        <div class="ticket-status">Overdue</div>
                    </div>
                    <div class="ticket-item on-hold">
                        <div class="status-dot"></div>
                        <div class="ticket-info">
                            <div class="ticket-id">Ticket #85</div>
                            <div class="ticket-desc">On Hold - Waiting for info</div>
                        </div>
                        <div class="ticket-status">On Hold</div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- ECharts -->
<script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
<script src="https://kit.fontawesome.com/a11f41f0d2.js" crossorigin="anonymous"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(() => {
            // ApexCharts - Tickets Overview Bar Chart
            new ApexCharts(document.querySelector("#totalRevenueChart"), {
                chart: { height: 260, width: '100%', type: 'bar', stacked: true },
                series: [
                    { name: 'Open Tickets', data: [50, 40, 55, 45, 60, 48, 52] },
                    { name: 'Closed Tickets', data: [30, 28, 40, 35, 45, 40, 38] }
                ],
                colors: ['#2563eb', '#22c55e'],
                plotOptions: { bar: { horizontal: false, columnWidth: '50%' } },
                xaxis: { categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] },
                yaxis: { min: 0 },
                tooltip: { shared: true, intersect: false }
            }).render();

            // ApexCharts - SLA Compliance Gauge
            new ApexCharts(document.querySelector("#growthGauge"), {
                chart: { type: 'radialBar', height: 160 },
                series: [62],
                colors: ['#6366f1'],
                plotOptions: {
                    radialBar: {
                        hollow: { size: '60%' },
                        dataLabels: { name: { show: false }, value: { fontSize: '28px', fontWeight: '600' } }
                    }
                },
                labels: ['SLA Compliance']
            }).render();

            // ApexCharts - Ticket Status Donut
            new ApexCharts(document.querySelector("#orderStatsDonut"), {
                chart: { type: 'donut', height: 140 },
                series: [55, 30, 15],
                labels: ['Open', 'In Progress', 'Closed'],
                colors: ['#2563eb', '#fbbf24', '#22c55e'],
                legend: { position: 'bottom' }
            }).render();

            // ApexCharts - User & Ticket Activity Line Chart
            new ApexCharts(document.querySelector("#incomeChart"), {
                chart: { type: 'area', height: 180 },
                series: [
                    { name: 'Users', data: [35, 38, 42, 40, 41, 42, 42] },
                    { name: 'Tickets Created', data: [25, 30, 28, 32, 35, 40, 45] }
                ],
                stroke: { curve: 'smooth' },
                fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.6, opacityTo: 0.1 } },
                colors: ['#2563eb', '#22c55e'],
                xaxis: { categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] }
            }).render();

           
            // ECharts - Ticket Status Breakdown Pie Chart
            var chartDom = document.getElementById('echartsPie');
            var myChart = echarts.init(chartDom);
            var option;

            option = {
                tooltip: { trigger: 'item' },
                legend: { bottom: '5%', left: 'center' },
                series: [
                    {
                        name: 'Ticket Status',
                        type: 'pie',
                        radius: ['40%', '70%'],
                        avoidLabelOverlap: false,
                        label: {
                            show: true,
                            position: 'outside',
                            formatter: '{b}: {d}%',
                            fontWeight: '600',
                        },
                        labelLine: {
                            show: true,
                            length: 15,
                            length2: 10,
                        },
                        data: [
                            { value: 55, name: 'Open', itemStyle: { color: '#2563eb' } },
                            { value: 30, name: 'In Progress', itemStyle: { color: '#fbbf24' } },
                            { value: 15, name: 'Closed', itemStyle: { color: '#22c55e' } }
                        ]
                    }
                ]
            };

            myChart.setOption(option);

        }, 50);
    });
</script>
@endpush

</x-filament::page>
