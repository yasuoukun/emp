<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-chart-pie text-indigo-600"></i>
                {{ __('แผงควบคุมหลักและวิเคราะห์ยอดขาย') }}
            </span>
            <span class="text-xs bg-red-100 text-red-800 px-3 py-1 rounded-full font-bold">Super Admin</span>
        </h2>
    </x-slot>

    <!-- Include Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-8 bg-gray-50/50 min-h-screen fade-in">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Alert Session Messages -->
            @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-lg shadow-sm flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-500 text-xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            @endif


            <!-- Sales Financial Performance Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total Revenue -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition-all">
                    <div>
                        <p class="text-sm text-gray-500 font-semibold tracking-wider uppercase">รายได้ทั้งหมด (โอนสำเร็จ)</p>
                        <h3 class="text-2xl font-extrabold text-slate-800 mt-1">฿{{ number_format($totalRevenue, 2) }}</h3>
                    </div>
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                </div>

                <!-- Monthly Revenue -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition-all">
                    <div>
                        <p class="text-sm text-gray-500 font-semibold tracking-wider uppercase">รายได้เดือนนี้</p>
                        <h3 class="text-2xl font-extrabold text-indigo-600 mt-1">฿{{ number_format($monthlyRevenue, 2) }}</h3>
                    </div>
                    <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                </div>

                <!-- Total Orders -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition-all">
                    <div>
                        <p class="text-sm text-gray-500 font-semibold tracking-wider uppercase">จำนวนออเดอร์ทั้งหมด</p>
                        <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ number_format($orderCount) }}</h3>
                    </div>
                    <div class="w-14 h-14 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>
                </div>

                <!-- Total Products -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition-all">
                    <div>
                        <p class="text-sm text-gray-500 font-semibold tracking-wider uppercase">จำนวนสินค้าในระบบ</p>
                        <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ number_format($productCount) }}</h3>
                    </div>
                    <div class="w-14 h-14 bg-sky-50 text-sky-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                    </div>
                </div>
            </div>

            <!-- System Statistics Card Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Categories -->
                <div class="bg-white px-5 py-4 rounded-xl border border-gray-100 flex items-center gap-4 hover:shadow-sm transition-all">
                    <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center text-lg">
                        <i class="fa-solid fa-folder-open"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase">จำนวนหมวดหมู่</p>
                        <h4 class="text-lg font-bold text-slate-800">{{ number_format($categoryCount) }} หมวดหมู่</h4>
                    </div>
                </div>
                <!-- Brands -->
                <div class="bg-white px-5 py-4 rounded-xl border border-gray-100 flex items-center gap-4 hover:shadow-sm transition-all">
                    <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center text-lg">
                        <i class="fa-solid fa-tags"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase">จำนวนแบรนด์สินค้า</p>
                        <h4 class="text-lg font-bold text-slate-800">{{ number_format($brandCount) }} แบรนด์</h4>
                    </div>
                </div>
                <!-- Security Indicator -->
                <div class="bg-white px-5 py-4 rounded-xl border border-gray-100 flex items-center gap-4 hover:shadow-sm transition-all">
                    <div class="w-10 h-10 bg-rose-50 text-rose-500 rounded-lg flex items-center justify-center text-lg animate-pulse">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase">สิทธิ์การควบคุมสูงสุด</p>
                        <h4 class="text-sm font-bold text-rose-600">Super Admin Active</h4>
                    </div>
                </div>
            </div>

            <!-- Charts Grid Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Sales Statistics Line Chart -->
                <div class="lg:col-span-2 bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-chart-line text-indigo-500"></i> สถิติยอดขายในรอบ 7 วันที่ผ่านมา (บาท)
                    </h3>
                    <div style="position: relative; height: 320px; width: 100%;">
                        <canvas id="salesLineChart"></canvas>
                    </div>
                </div>

                <!-- Order Status Doughnut Chart -->
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-chart-pie text-rose-500"></i> สัดส่วนสถานะใบสั่งซื้อ
                        </h3>
                        <div style="position: relative; height: 240px; width: 100%;">
                            <canvas id="statusPieChart"></canvas>
                        </div>
                    </div>
                    <div class="text-xs text-gray-400 text-center mt-4">
                        แผงวิเคราะห์สถิติสรุปงานของ Super Admin
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart Initializer Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Line Chart (7 Days Sales)
            const salesCtx = document.getElementById('salesLineChart').getContext('2d');
            const salesChart = new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($labelsLast7Days) !!},
                    datasets: [{
                        label: 'ยอดโอนสำเร็จ (บาท)',
                        data: {!! json_encode($salesLast7Days) !!},
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79, 70, 229, 0.05)',
                        borderWidth: 3,
                        pointBackgroundColor: '#4f46e5',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        tension: 0.35,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.04)'
                            },
                            ticks: {
                                font: {
                                    size: 11
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });

            // 2. Pie Chart (Order Statuses)
            const statusCtx = document.getElementById('statusPieChart').getContext('2d');
            const orderStatusesData = {!! json_encode($orderStatuses) !!};
            
            const statusChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(orderStatusesData),
                    datasets: [{
                        data: Object.values(orderStatusesData),
                        backgroundColor: [
                            '#e2e8f0', // pending
                            '#f87171', // pending_verification
                            '#34d399', // confirmed
                            '#60a5fa', // shipped
                            '#818cf8', // delivered
                            '#cbd5e1'  // cancelled
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 12,
                                font: {
                                    size: 11
                                }
                            }
                        }
                    },
                    cutout: '65%'
                }
            });
        });
    </script>
</x-app-layout>
