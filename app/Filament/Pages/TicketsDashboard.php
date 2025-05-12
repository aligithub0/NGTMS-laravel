<?php

namespace App\Filament\Pages;

use App\Filament\Resources\TicketsResource;
use App\Filament\Widgets\TicketsOverview;
use App\Filament\Widgets\TicketsByStatusChart;
use App\Filament\Widgets\TicketsByPriorityChart;
use App\Filament\Widgets\RecentTicketsTable;
use App\Filament\Widgets\TicketsDateFilter;
use Filament\Pages\Page;
use Filament\Actions\Action;

class TicketsDashboard extends Page
{
    protected static string $resource = TicketsResource::class;
    protected static string $view = 'filament.pages.tickets-dashboard';
    protected static ?string $navigationIcon = 'heroicon-s-chart-bar';
    protected static ?string $navigationLabel = 'Tickets Dashboard';
    protected static ?string $title = 'Tickets Overview';
    protected static ?string $navigationGroup = 'Reports';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create')
                ->label('Create Ticket')
                ->url(TicketsResource::getUrl('create'))
                ->icon('heroicon-o-plus')
                ->button(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            TicketsDateFilter::class,
            TicketsOverview::class,
            TicketsByStatusChart::class,
            TicketsByPriorityChart::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            RecentTicketsTable::class,
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