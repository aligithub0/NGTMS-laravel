<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $stats = [];
    public $recentUsers = [];
    public $chartData = [];
    
    public function mount()
    {
        $this->loadStats();
        $this->loadRecentUsers();
        $this->prepareChartData();
    }
    
    protected function loadStats()
    {
        $this->stats = [
            [
                'name' => 'Total Users',
                'value' => User::count(),
                'change' => '+12%',
                'icon' => 'users',
                'trend' => 'up',
            ],
            [
                'name' => 'Revenue',
                'value' => '$24,300',
                'change' => '+8.2%',
                'icon' => 'currency-dollar',
                'trend' => 'up',
            ],
            [
                'name' => 'Pending Orders',
                'value' => Order::where('status', 'pending')->count(),
                'change' => '-3.4%',
                'icon' => 'shopping-bag',
                'trend' => 'down',
            ],
            [
                'name' => 'Active Now',
                'value' => User::where('last_active_at', '>=', now()->subMinutes(15))->count(),
                'change' => '+4.6%',
                'icon' => 'lightning-bolt',
                'trend' => 'up',
            ],
        ];
    }
    
    protected function loadRecentUsers()
    {
        $this->recentUsers = User::latest()
            ->take(5)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar' => 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&color=FFFFFF&background=14b8a6',
                    'joined' => $user->created_at->diffForHumans(),
                ];
            })
            ->toArray();
    }
    
    protected function prepareChartData()
    {
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();
        
        $dates = [];
        $currentDate = $startDate->copy();
        
        while ($currentDate <= $endDate) {
            $dates[] = $currentDate->format('M j');
            $currentDate->addDay();
        }
        
        $usersData = [];
        $ordersData = [];
        
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $usersCount = User::whereDate('created_at', $currentDate)->count();
            $ordersCount = Order::whereDate('created_at', $currentDate)->count();
            
            $usersData[] = $usersCount;
            $ordersData[] = $ordersCount;
            
            $currentDate->addDay();
        }
        
        $this->chartData = [
            'labels' => $dates,
            'datasets' => [
                [
                    'label' => 'Users',
                    'data' => $usersData,
                    'borderColor' => '#14b8a6',
                    'backgroundColor' => 'rgba(20, 184, 166, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Orders',
                    'data' => $ordersData,
                    'borderColor' => '#0ea5e9',
                    'backgroundColor' => 'rgba(14, 165, 233, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
        ];
    }
    
    public function render()
    {
        return view('livewire.dashboard')
            ->layout('layouts.dashboard', [
                'title' => 'Dashboard',
            ]);
    }
}