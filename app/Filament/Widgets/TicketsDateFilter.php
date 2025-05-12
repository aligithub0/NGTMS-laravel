<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms; // Add this
use Filament\Forms\Form;
use Illuminate\Support\Carbon;

class TicketsDateFilter extends Widget implements HasForms // Implement the interface
{
    use \Filament\Forms\Concerns\InteractsWithForms; // Add this trait

    protected static string $view = 'filament.widgets.tickets-date-filter';
    
    protected int|string|array $columnSpan = 'full';
    
    public function mount(): void
    {
        $this->form->fill([
            'date_range' => 'month',
            'start_date' => now()->startOfMonth()->toDateString(),
            'end_date' => now()->endOfMonth()->toDateString(),
        ]);
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('date_range')
                    ->label('Date Range')
                    ->options([
                        'today' => 'Today',
                        'yesterday' => 'Yesterday',
                        'week' => 'This Week',
                        'month' => 'This Month',
                        'quarter' => 'This Quarter',
                        'year' => 'This Year',
                        'custom' => 'Custom Range',
                    ])
                    ->live()
                    ->afterStateUpdated(function ($state, $set) {
                        $dates = $this->getDateRange($state);
                        
                        $set('start_date', $dates['start']->toDateString());
                        $set('end_date', $dates['end']->toDateString());
                    }),
                
                DatePicker::make('start_date')
                    ->label('From')
                    ->native(false)
                    ->displayFormat('M d, Y')
                    ->maxDate(function (callable $get) {
                        return $get('end_date') ?: now();
                    }),
                
                DatePicker::make('end_date')
                    ->label('To')
                    ->native(false)
                    ->displayFormat('M d, Y')
                    ->minDate(function (callable $get) {
                        return $get('start_date') ?: now();
                    })
                    ->maxDate(now()),
            ])
            ->statePath('data')
            ->columns(3);
    }
    
    protected function getDateRange(string $range): array
    {
        return match ($range) {
            'today' => [
                'start' => now()->startOfDay(),
                'end' => now()->endOfDay(),
            ],
            'yesterday' => [
                'start' => now()->subDay()->startOfDay(),
                'end' => now()->subDay()->endOfDay(),
            ],
            'week' => [
                'start' => now()->startOfWeek(),
                'end' => now()->endOfWeek(),
            ],
            'month' => [
                'start' => now()->startOfMonth(),
                'end' => now()->endOfMonth(),
            ],
            'quarter' => [
                'start' => now()->startOfQuarter(),
                'end' => now()->endOfQuarter(),
            ],
            'year' => [
                'start' => now()->startOfYear(),
                'end' => now()->endOfYear(),
            ],
            default => [
                'start' => now()->startOfMonth(),
                'end' => now()->endOfMonth(),
            ],
        };
    }
    
    public function getFilters(): array
    {
        return [
            'start_date' => Carbon::parse($this->form->getState()['start_date'])->startOfDay(),
            'end_date' => Carbon::parse($this->form->getState()['end_date'])->endOfDay(),
        ];
    }
}