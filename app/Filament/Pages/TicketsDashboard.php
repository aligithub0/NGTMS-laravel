<?php

namespace App\Filament\Pages;

use App\Filament\Resources\TicketsResource;
use App\Filament\Widgets\TicketsOverview;
use App\Filament\Widgets\TicketsByStatusChart;
use App\Filament\Widgets\TicketsByPriorityChart;
use App\Filament\Widgets\RecentTicketsTable;
use App\Filament\Widgets\TicketsDateFilter;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Pages\Page;
use Filament\Actions\Action;
use App\Models\User;
use App\Models\Tickets;
use App\Models\TicketSource;
use App\Models\SlaConfiguration;
use Filament\Forms\Components\Hidden;
use Filament\Notifications\Notification;
use App\Filament\Pages\CreateTicket;



class TicketsDashboard extends Page
{
    protected static string $resource = TicketsResource::class;
    protected static string $view = 'filament.pages.tickets-dashboard';
    protected static ?string $navigationIcon = 'heroicon-s-chart-bar';
    protected static ?string $navigationLabel = 'Tickets Dashboard';
    protected static ?string $title = 'Tickets Overview';
    protected static ?string $navigationGroup = 'Reports';


    // public $title;
    public $description;
    public $priority; // Add other fields you need

 protected function getHeaderActions(): array
{
    return [
        Action::make('create')
            ->label('Create Ticket')
            ->url(CreateTicket::getUrl()) // Changed from form() to url()
            ->icon('heroicon-o-plus')
    ];
}

    protected function getHeaderWidgets(): array
    {
        return [
            
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
          
        ];
    }
    
    public function getFilters(): array
    {
        foreach ($this->getHeaderWidgets() as $widget) {
            if (is_a($widget, TicketsDateFilter::class, true)) {
                return $this->getWidget($widget)->getFilters();
            }
        }
        
        return [
            'start_date' => now()->startOfMonth(),
            'end_date' => now()->endOfMonth(),
        ];
    }
}