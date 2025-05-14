<div>
    <!-- Stats -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        @foreach($stats as $stat)
            <x-stat-card 
                :name="$stat['name']" 
                :value="$stat['value']" 
                :change="$stat['change']" 
                :icon="$stat['icon']" 
                :trend="$stat['trend'] ?? 'up'"
            />
        @endforeach
    </div>
    
    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Activity Overview</h3>
            <div class="h-80">
                <canvas id="activityChart" wire:ignore></canvas>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Users</h3>
            <div class="space-y-4">
                @foreach($recentUsers as $user)
                    <div class="flex items-center">
                        <img class="h-10 w-10 rounded-full" src="{{ $user['avatar'] }}" alt="">
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">{{ $user['name'] }}</p>
                            <p class="text-sm text-gray-500">{{ $user['email'] }}</p>
                        </div>
                        <div class="ml-auto text-sm text-gray-500">
                            {{ $user['joined'] }}
                        </div>
                    </div>
                @endforeach
                <a href="{{ route('users.index') }}" class="block text-center text-sm font-medium text-primary-600 hover:text-primary-500">
                    View all users
                </a>
            </div>
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Recent Activity</h3>
        </div>
        <div class="divide-y divide-gray-200">
            <!-- Activity items would go here -->
            <div class="px-6 py-4">
                <p class="text-sm text-gray-500">No recent activity</p>
            </div>
        </div>
    </div>
    
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('livewire:load', function () {
                const ctx = document.getElementById('activityChart').getContext('2d');
                
                const chart = new Chart(ctx, {
                    type: 'line',
                    data: @json($chartData),
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
                
                Livewire.on('updateChart', (data) => {
                    chart.data = data;
                    chart.update();
                });
            });
        </script>
    @endpush
</div>