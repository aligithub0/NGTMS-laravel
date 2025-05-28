<x-filament::page>
    <div>
<style>
            /* Basic container padding */
            .dashboard-container {
                /* padding: 20px 15px; */
            }

            /* KPI small cards on right */
            .kpi-container {
                display: flex;
                gap: 6px;
                flex-wrap: wrap;
                margin-bottom: 0px;
                width: 406px;
                margin-left: 111px;
                    }

            .kpi-card {
                flex: 1 1 200px;
            border-radius: 12px;
            color: white;
            padding: 18px 24px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            box-shadow: 0 8px 20px rgb(0 0 0 / 0.12);
            position: relative;
            overflow: hidden;
            cursor: default;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 165px !important;
            }

            .kpi-label {
                font-weight: 500;
            font-size: 1rem;
            margin-bottom: 8px;
            }

            .kpi-value {
                font-size: 1.9rem;
                font-weight: 600;
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

            .orange-card {
                background: linear-gradient(135deg, #f7971e, #ffd200);
            }

                .green {
                background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            }

            .red-card {
                background: linear-gradient(135deg, #ff5858 0%, #f09819 100%);
            }

            .aqua {
                background: linear-gradient(135deg, #13547a 0%, #80d0c7 100%);
            }

            .indigo {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .gray {
                background: linear-gradient(135deg, #a7a7a7 0%, #e0e0e0 100%);
            }


        /* Main content grid */
        .content-grid {
            display: grid;
            grid-template-columns: 2.5fr 1fr;
            gap: 20px;
            width: 100%;
            min-width: 0;
            margin-top: -15px;
        }

        /* Important: Fix to ensure child divs get full width inside grid */
        .content-grid > div {
            width: 110%;
            min-width: 0; /* avoid flexbox/grid shrinking issues */
        }

        /* Card styles for main charts and stats */
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgb(0 0 0 / 0.1);
            padding: 20px;
            margin-bottom: 7px;
        }

        .card-header {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 15px;
        }

        /* Info Graph chart */

        .dot-grid {
            display: grid;
            grid-template-columns: repeat(11, 13px);
            grid-gap: 10px 8px;
            margin-left: 11px;
            margin-top: 37px;
        }
        .dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
        }
        .dot.orange {
            background-color: #f97316; 
        }
        .dot.red {
            background-color: #dc2626; 
        }
        .info-text {
            display: flex;
            gap: 10px;
            margin-left: 37px;
            flex-direction: column;
            flex-wrap: nowrap;
            align-content: stretch;
            justify-content: space-evenly;
            align-items: flex-end;
            margin-top: -166px !important;
            margin-right: 5px;
        }
        .info-item {
            font-weight: 700;
            font-size: 1.6rem;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        .info-item span.number {
            font-size: 1.9rem;
            color: inherit;
        }
        .info-item.orange {
            color: #f97316;
        }
        .info-item.red {
            color: #dc2626;
        }
        .info-item .label {
            font-weight: 400;
            font-size: 0.9rem;
            margin-top: 2px;
            color: #6b7280;
        }
        .number-orange{
            color: #f97316 !important;

        }

        .number-red{
            color: #dc2626 !important;
            
        }

        .progress-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 16px rgb(82 90 255 / 0.07);
            width: 331px;
            padding: 28px 20px 21px 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            margin-left: 3px;
            margin-top: 8px;
    }
            .progress-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 2px;
            color: #22223b;
            }
            .progress-subtitle {
            color: #8c94c7;
            font-size: 0.95rem;
            margin-bottom: 16px;
            }
            #circularProgress {
            width: 130px !important;
            height: 130px !important;
            margin: 0 auto 12px auto;
            }
            .progress-desc {
            color: #7c7e97;
            font-size: 1rem;
            margin: 7px 0 17px 0;
            font-weight: 400;
            min-height: 36px;
            }
            .progress-btn {
            background: #f97316;
            border: none;
            color: #fff;
            font-size: 1.06rem;
            font-family: inherit;
            font-weight: 500;
            border-radius: 18px;
            padding: 8px 0 9px 0;
            width: 75%;
            letter-spacing: 0.03em;
            cursor: pointer;
            margin: 0 auto;
            box-shadow: 0 2px 8px #c7d2fe40;
            transition: background 0.25s;
            margin-top: 58px;
            margin-bottom: 25px;
            }
            .progress-btn:hover {
            background:rgb(218, 101, 18);
            }


</style>

<div class="dashboard-container">

    <!-- Main Grid -->
    <div class="content-grid">
        <!-- Left: Charts & stats -->
        <div>
                            <!-- Row 1 Graphs  -->

                    <div style="display: flex; gap: 5px; width: 100%;">
                        <div class="card" style="flex: 1; height: 260px;">
                        <div class="card-header" style="font-size:16px; margin-bottom:-10px;">Tickets Status By Department</div>
                            <div style="width: 100%; height: 60px;" id="totalRevenueChart"></div>
                        </div>
                        <div class="card" style="flex: 1; height: 260px;">
                        <div class="card-header" style="font-size:16px; margin-bottom:-10px;">Tickets Status By Parent Purposes</div>
                            <div style="width: 100%; height: 60px;" id="incomeChart"></div>
                        </div>
                        <div class="card" style="flex: 1; height: 260px;">
                        <div class="card-header" style="font-size:16px; margin-bottom:-10px;">SLA Compliance Rate</div>
                            <div style="width: 100%; height: 60px;" id="growthGauge"></div>
                            <div style="text-align: center; font-weight: 600; margin-top: -10px;">
                                {{ $slaCompliance }}% SLA Compliance
                            </div>
                            <div style="display:flex; justify-content: center; gap: 15px; margin-top: 10px;">
                                <div style="background:#eef2ff; padding: 6px 10px; border-radius: 6px; font-weight: 600; font-size: 13px;">
                                    {{ $totalSLAs }} SLAs
                                </div>
                                <div style="background:#e0f2fe; padding: 6px 10px; border-radius: 6px; font-weight: 600; font-size: 13px;">
                                    {{ $totalPriorities }} Priorities
                                </div>
                            </div>
                        </div>
                    </div>
                                <!-- Row 2 Graphs  -->
                    <div style="display: flex; gap: 5px; width: 100%;">
                        <div class="card" style="flex: 1; height: 260px;">
                        <div class="card-header" style="font-size:16px; margin-bottom:-10px;">Tickets Status By Purpose Group</div>
                            <div style="width: 100%; height: 60px;" id="barChart1"></div>
                        </div>
                        <div class="card" style="flex: 1; height: 260px;">
                        <div class="card-header" style="font-size:16px; margin-bottom:-10px;">Tickets Status By Agents</div>
                            <div style="width: 100%; height: 60px;" id="lineChart1"></div>
                        </div>
                        <div class="card" style="flex: 1; height: 260px;">
                        <div class="card-header" style="font-size:16px; margin-bottom:-10px;">Tickets Status By SLA</div>
                            <div style="width: 100%; height: 60px;" id="barRangeChart"></div>
                        </div>
                    </div>


                    <!-- Row 3 Graphs  -->
                    <div style="display: flex; gap: 5px; width: 100%;">
                    <div class="card" style="flex: 1; height: 260px; display: flex; align-items: center; ">
                    <div style="flex: 1; height: 180px; position: relative; margin-right: -48px; margin-left: -38px;">
                    <div class="card-header" style="font-size:16px; margin-top:-22px; margin-left:40px; ">Tickets Status By Sources</div>
                        <div id="doughnutChart" style="width: 100%; height: 100%;"></div>
                    </div>
                    <div style="flex-shrink: 0; display: flex; flex-direction: column; gap: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 16px; height: 16px; background: #f97316; border-radius: 4px;"></div>
                        <div>
                            <div style="font-weight: 700; font-size: 20px; color: #f97316;">256</div>
                            <div style="color: #6b7280; font-size: 14px;">Lorem</div>
                        </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 16px; height: 16px; background: #dc2626; border-radius: 4px;"></div>
                        <div>
                            <div style="font-weight: 700; font-size: 20px; color: #dc2626;">128</div>
                            <div style="color: #6b7280; font-size: 14px;">ipsum</div>
                        </div>
                        </div>
                    </div>
                    </div>

                    <div class="card" style="flex: 1; height: 260px; ">
                    <div class="card-header" style="font-size:16px; margin-left:12px; margin-bottom: -10px;">Tickets Status By Category</div>

                        <div class="dot-grid"  id="dotGrid"></div>
                        <div class="info-text">
                            <div class="info-item">
                            <span class="number number-orange">56%</span>
                            <span class="label">Lorem</span>
                            </div>
                            <div class="info-item ">
                            <span class="number number-red">34%</span>
                            <span class="label">ipsum</span>
                            </div>
                        </div>
                        </div>

                    <div class="card" style="flex: 1; height: 260px;">
                    <div class="card-header" style="font-size:16px; margin-bottom:-10px;">Tickets Status By Designation</div>
                        <div style="width: 100%; height: 60px;" id="horizontalBarChart"></div>
                    </div>
        </div>
           
        </div>

            <!-- Right: KPI cards and Tickets Journey -->
    <div>
    <div class="kpi-container">
            <div class="kpi-card pink">
                <div class="kpi-label">Total Tickets</div>
                <div class="kpi-value">{{$totalTickets}} </div>
            </div>
            <div class="kpi-card purple">
                <div class="kpi-label">New Tickets</div>
                <div class="kpi-value">{{$openTickets}} </div>
            </div>
            <div class="kpi-card blue">
                <div class="kpi-label">Open Tickets</div>
                <div class="kpi-value">{{$assignedTickets}}</div>
            </div>
            <div class="kpi-card orange-card">
                <div class="kpi-label">Assigned to Me</div>
                <div class="kpi-value">{{$newTickets}}</div>
            </div>

            <div class="kpi-card indigo  ">
                <div class="kpi-label">Overdue Tickets</div>
                <div class="kpi-value">{{$overdueTickets}}</div>
            </div>

            <div class="kpi-card red-card">
                <div class="kpi-label">In Progress</div>
                <div class="kpi-value">{{$inProgressTickets}}</div>
            </div>

            <div class="kpi-card green">
                <div class="kpi-label">On Hold</div>
                <div class="kpi-value">{{$onHoldTickets}}</div>
            </div>

            <div class="kpi-card aqua">
                <div class="kpi-label">Reopened</div>
                <div class="kpi-value">{{$reopenedTickets}}</div>
            </div>

            <div class="progress-card">
    <div class="progress-title">Agents Performance Efficiency<br> Completion Rate</div>
    <!-- <div class="progress-subtitle">Duis autem vel eum iriure</div> -->
    <div id="circularProgress"></div>
    <!-- <div class="progress-desc">
      Lorem ipsum dolor sit amet,<br>consectetuer adipiscing
    </div> -->
    <button class="progress-btn">View Details</button>
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
    window.statuses = @json($statuses ?? []);
    window.departments = @json($departments ?? []);
    window.ticketsData = @json($ticketsData ?? []);
    window.slaCompliance = @json($slaCompliance ?? 0);
    window.purposeNames = @json($purposeNames ?? []);
    window.ticketsByPurposeStatus = @json($ticketsByPurposeStatus ?? []);
    window.agentNames = @json($agentNames ?? []);
    window.ticketsByAgentStatus = @json($ticketsByAgentStatus ?? []);

    </script>

    <script>    
        
        document.addEventListener('DOMContentLoaded', function () {
        setTimeout(() => {

              //  Chart 1: Tickets Status By Department Bar Chart (Dynamic)
         new ApexCharts(document.querySelector("#totalRevenueChart"), {
            chart: { height: 220, width: '100%', type: 'bar', stacked: true },
            series: window.ticketsData,
            colors: ['#f97316', '#5c8cb6', '#22c55e', '#dc2626', '#43e97b', '#a7a7a7', '#13547a'],
            plotOptions: { bar: {borderRadius: 4, horizontal: false, columnWidth: '20%' } },
            xaxis: {
                categories: window.statuses,
            },
            yaxis: {
                categories: window.departments,
                labels: { show: false },
            },
            tooltip: { shared: true, intersect: false },
            legend: {
                show: true,
                position: 'left',
                fontSize: '10px',
                itemMargin: { vertical: 4, horizontal: 0 },
                markers: { width: 14, height: 14, radius: 3 },
                labels: { colors: '#333' },
                width: 'auto',
            },
        }).render();


            //  // Chart 2: Ticket Status By Purpose
        new ApexCharts(document.querySelector("#incomeChart"), {
            chart: { 
                type: 'bar', 
                height: 220,   // Increase if you have many purposes
                stacked: true  // Make it stacked like your previous department chart
                    },
                grid: {
            padding: {
                left: 5, // You can increase this number as needed
                right: 15
            }
            },
                series: window.ticketsByPurposeStatus,  // Each status (New, In Progress...) is a series
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '35%'
                    }
                },
                colors: [
                    '#2563eb', '#fbbf24', '#22c55e', '#ff5858', '#43e97b', 
                    '#a7a7a7', '#13547a', '#4f8a8b', '#e17055', '#0984e3', '#00b894'
                ],
                xaxis: {
                    categories: window.purposeNames,
                    labels: {
                        rotate: -45,
                        style: { fontSize: '10px' }
                    }
                    
                },
                yaxis: {
                    min: 0,
                    max: 5,
                    forceNiceScale: true,
            labels: { show: false },

                },
                tooltip: { shared: true, intersect: false },
                legend: {
            show: true,
            position: 'left',
            fontSize: '10px',
            itemMargin: { vertical: 2, horizontal: 0 },
            markers: { width: 14, height: 14, radius: 3 },
            labels: { colors: '#333' },
            width: 'auto',
            },
        }).render();

           // Chart 3: SLA Compliance Gauge
           new ApexCharts(document.querySelector("#growthGauge"), {
                chart: { type: 'radialBar', height: 160 },
                series: [window.slaCompliance], // Now dynamic!
                colors: ['#f97316'],
                plotOptions: {
                    radialBar: {
                        hollow: { size: '60%' },
                        dataLabels: { name: { show: false }, value: { fontSize: '28px', fontWeight: '600' } }
                    }
                },
                labels: ['SLA Compliance']
            }).render();


            // Chart 4: Vertical Bar Chart
        var options1 = {
            chart: {
                height: 220,
                type: 'bar',
                stacked: false,
                toolbar: { show: false },
            },
            series: [{
                name: 'Dataset',
                data: [5, 10, 20, 30, 35, 40, 50, 45]
            }],
            colors: ['#f97316'],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '20%',
                    borderRadius: 4,  // Rounded corners on bars
                    startingShape: 'rounded',  // rounded shape at bottom start
                    endingShape: 'rounded',    // rounded shape at top end
                }
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    style: {
                        colors: '#64748b',
                        fontWeight: 500,
                        fontSize: '10px',
                    }
                }
            },
            yaxis: {
                max: 60,
                labels: {
                    style: {
                        colors: '#64748b',
                        fontWeight: 500,
                        fontSize: '10px',
                    }
                },
                axisBorder: { show: false },
                axisTicks: { show: false },
                tickAmount: 6,  // Number of ticks on y axis
            },
            grid: {
                borderColor: '#e2e8f0',
                strokeDashArray: 4,
                yaxis: {
                    lines: { show: true }
                },
                xaxis: {
                    lines: { show: false }
                },
            },
            tooltip: {
                shared: true,
                intersect: false,
                style: { fontSize: '14px' }
            },
            legend: { show: false }
        };

        var chart1 = new ApexCharts(document.querySelector("#barChart1"), options1);
        chart1.render();


            // Chart 5: Line Chart
        var options2 = {
                chart: {
                    height: 220,
                    type: 'line',
                    zoom: { enabled: false },
                    toolbar: { show: false }
                },
                series: [{
                    name: 'Data',
                    data: [20, 25, 40, 35, 45, 35, 50, 60]
                }],
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                markers: {
                    size: 5,
                    colors: ['#f97316'],  // Use a similar orange/yellow color (#f59e0b)
                    strokeColors: '#fff',
                    strokeWidth: 2,
                    hover: {
                        size: 7,
                    }
                },
                colors: ['#f97316'],  // Same orange/yellow line color
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
                    labels: {
                        style: {
                            colors: '#6b7280',  // muted grayish color for labels
                            fontWeight: 500,
                            fontSize: '10px'
                        }
                    },
                    axisTicks: { show: false },
                    axisBorder: { show: false }
                },
                yaxis: {
                    max: 80,
                    labels: {
                        show: false  // Hide y axis labels for minimalist look
                    },
                    axisTicks: { show: false },
                    axisBorder: { show: false },
                    crosshairs: { show: false }
                },
                grid: {
                    borderColor: '#e5e7eb',
                    strokeDashArray: 5,
                    yaxis: {
                        lines: {
                            show: true
                        }
                    },
                    xaxis: {
                        lines: {
                            show: false
                        }
                    }
                },
                tooltip: {
                    enabled: true,
                    shared: true,
                    theme: 'dark',
                    marker: { show: false },
                    style: { fontSize: '14px' }
                },
                legend: {
                    show: false
                }
            };

            var chart2 = new ApexCharts(document.querySelector("#lineChart1"), options2);
            chart2.render();

         // Chart 6: Bar Range Chart
            
                var options = {
            chart: {
                height: 220,
                type: 'bar',
                stacked: true,
                toolbar: { show: false }
            },
            series: [
                {
                    name: 'High',
                    data: [20, 25, 30, 35, 25, 20, 30, 15],
                    color: '#f97316'
                },
                {
                    name: 'Low',
                    data: [15, 25, 30, 18, 25, 22, 30, 28],
                    color: '#dc2626'
                }
            ],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '40%',
                    borderRadius: 4,
                    borderRadiusApplication: 'around',
                    borderRadiusWhenStacked: 'all'
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 8,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
                labels: {
                    style: {
                        colors: '#6b7280',
                        fontWeight: 500,
                        fontSize: '10px'
                    }
                },
                axisTicks: { show: false },
                axisBorder: { show: false }
            },
            yaxis: {
                max: 70,
                labels: { show: false },
                axisTicks: { show: false },
                axisBorder: { show: false }
            },
            grid: {
                borderColor: '#e5e7eb',
                strokeDashArray: 5,
                yaxis: { lines: { show: true } },
                xaxis: { lines: { show: false } }
            },
            tooltip: {
                shared: true,
                intersect: false,
                theme: 'dark',
                style: { fontSize: '14px' }
            },
            legend: { show: false },
            fill: {
                opacity: 1
            }
        };

        var chart = new ApexCharts(document.querySelector("#barRangeChart"), options);
        chart.render();


         // Chart 7: Pie Chart
        var options4 = {
            chart: {
                height: 170,
                type: 'donut',
                animations: { enabled: true }
            },
            series: [
                384,       // Total (big arc in light gray)
                256,       // Orange arc
                2,         // Spacer (small transparent gap)
                128,       // Red arc
                2          // Spacer (small transparent gap)
            ],
            labels: ['Total', 'Lorem ipsum', '', 'Dolor sit amet', ''],
            colors: [
                '#d1d5db',  // Gray for total arc
                '#f97316',  // Orange
                'transparent',  // Spacer gap
                '#dc2626',  // Red
                'transparent'   // Spacer gap
            ],
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: false
                        }
                    }
                }
            },
            stroke: {
                colors: ['transparent'],
                lineCap: 'round'  // Rounded ends for arcs
            },
            legend: { show: false },
            tooltip: { enabled: false },
        };

     var chart4 = new ApexCharts(document.querySelector("#doughnutChart"), options4);
        chart4.render();
        
        const donutChart = document.getElementById('doughnutChart');
        const centerText = document.createElement('div');
        centerText.style.position = 'absolute';
        centerText.style.top = '50%';
        centerText.style.left = '50%';
        centerText.style.transform = 'translate(-50%, -50%)';
        centerText.style.fontSize = '30px';
        centerText.style.fontWeight = '700';
        centerText.style.color = '#4b5563';
        centerText.innerHTML = '384';
        donutChart.style.position = 'relative';
        donutChart.appendChild(centerText);

    
        // Chart 8: Dotted infographic chart

        const dotGrid = document.getElementById('dotGrid');
            const rows = 7;
            const cols = 14;

            // Total dots: rows * cols = 98 dots (like screenshot)

            // Dot count per color, roughly matching screenshot
            const orangeDotsCount = 46; // top 4 rows, partial 5th
            const redDotsCount = 34;    // below orange dots

            for(let i = 0; i < rows * cols; i++) {
                const dot = document.createElement('div');
                dot.classList.add('dot');

                if(i < orangeDotsCount) {
                dot.classList.add('orange');
                } else if(i < orangeDotsCount + redDotsCount) {
                dot.classList.add('red');
                } else {
                // empty space, make transparent or light color if needed
                dot.style.backgroundColor = 'transparent';
                }

                dotGrid.appendChild(dot);
            }

           // Chart 9: Horizontal Bar Chart

        var options = {
                chart: {
                    type: 'bar',
                    height: 220,
                    stacked: false,
                    toolbar: { show: false }
                },
                series: [
                    {
                        name: 'Dataset 1',
                        data: [30, 200, 300, 450],
                        color: '#dc2626' // Red
                    },
                    {
                        name: 'Dataset 2',
                        data: [60, 150, 400, 600],
                        color: '#f97316' // Orange
                    }
                ],
                plotOptions: {
                    bar: {
                        horizontal: true,
                        barHeight: '60%',
                        borderRadius: 3,
                        borderRadiusApplication: 'end',
                        borderRadiusWhenStacked: 'all'
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 8,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: ['JAN', 'FEB', 'MAR', 'APR'],
                    labels: {
                        style: {
                            colors: '#6b7280',
                            fontWeight: 500,
                            fontSize: '10px'
                        }
                    },
                    axisTicks: { show: false },
                    axisBorder: { show: false }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#6b7280',
                            fontWeight: 500,
                            fontSize: '10px'
                        }
                    },
                    axisTicks: { show: false },
                    axisBorder: { show: false }
                },
                grid: {
                    borderColor: '#e5e7eb',
                    strokeDashArray: 5,
                    xaxis: { lines: { show: true } },
                    yaxis: { lines: { show: false } }
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    theme: 'dark',
                    style: { fontSize: '14px' }
                },
                legend: { show: false },
                fill: {
                    opacity: 1
                }
            };

            var chart = new ApexCharts(document.querySelector("#horizontalBarChart"), options);
            chart.render();


            // Chart 9: Circular Progress Chart
        var options = {
            chart: {
                type: 'radialBar',
                height: 150,
                width: 130,
                sparkline: { enabled: true }
            },
            series: [75],
            plotOptions: {
                radialBar: {
                hollow: {
                    margin: 0,
                    size: '70%',
                    background: '#f7f7fd',
                    dropShadow: { enabled: false }
                },
                track: {
                    background: '#e6e8fa',
                    strokeWidth: '87%',
                    margin: 0,
                    dropShadow: { enabled: false }
                },
                dataLabels: {
                    show: true,
                    value: {
                    fontSize: '2.5rem',
                    color: '#393e69',
                    fontWeight: 600,
                    show: true,
                    offsetY: 6,
                    formatter: val => `${val}%`
                    },
                    name: { show: false }
                }
                }
            },
            colors: ['#f97316'],
            stroke: {
                lineCap: 'round'
            },
            grid: { padding: { top: 0, right: 0, bottom: 0, left: 0 } }
            };

           var chart = new ApexCharts(document.querySelector("#circularProgress"), options);
            chart.render();

                  
        }, 50);
    });
</script>
@endpush

</div>
</x-filament::page>
