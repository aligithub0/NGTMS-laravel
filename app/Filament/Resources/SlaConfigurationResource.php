<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SlaConfigurationResource\Pages;
use App\Filament\Resources\SlaConfigurationResource\RelationManagers;
use App\Models\SlaConfiguration;
use App\Models\Department;
use App\Models\Purpose;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\Select;
use Carbon\CarbonInterval;
use Filament\Forms\Components\Textarea;



class SlaConfigurationResource extends Resource
{
    protected static ?string $model = SlaConfiguration::class;


    protected static ?string $navigationIcon = 'heroicon-s-cog-8-tooth';

    public static function getNavigationSort(): int
    {
        $currentFile = basename((new \ReflectionClass(static::class))->getFileName());
        return NavigationOrder::getSortOrderByFilename($currentFile) ?? parent::getNavigationSort();
    }

    public static function getNavigationGroup(): ?string
    {
        $currentFile = basename((new \ReflectionClass(static::class))->getFileName());
        return NavigationOrder::getNavigationGroupByFilename($currentFile);
    }

    public static function getNavigationLabel(): string
    {
        return 'SLA Configurations'; 
    
    }

    public static function canViewAny(): bool
{
    return auth()->user()?->role?->name === 'Admin';
}

public static function canCreate(): bool
{
    return auth()->user()?->role?->name === 'Admin';
}

public static function canEdit($record): bool
{
    return auth()->user()?->role?->name === 'Admin';
}

public static function canDelete($record): bool
{
    return auth()->user()?->role?->name === 'Admin';
}


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->required()
                ->rules([
                    'required',

                    'regex:/^[A-Za-z\s]+$/',
                    'max:255',
                ])
                ->helperText('Only letters and spaces are allowed.'),

                
                
                Select::make('department_id')
                ->label('Department')
                ->options(Department::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable(),


                Textarea::make('description')->required()->rows(2),

                Select::make('purpose_id')
                ->label('Purpose')
                ->options(Purpose::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable(),


                TextInput::make('response_time')
                ->label('Response Time')
                ->required(),            
                // ->formatStateUsing(function ($state) {
                //     if (!$state) return null;
            
                //     [$hours, $minutes, $seconds] = explode(':', $state);
            
                //     $parts = [];
            
                //     if ((int) $hours > 0) {
                //         $parts[] = (int) $hours . ' hour' . ((int) $hours > 1 ? 's' : '');
                //     }
            
                //     if ((int) $minutes > 0) {
                //         $parts[] = (int) $minutes . ' minute' . ((int) $minutes > 1 ? 's' : '');
                //     }
            
                //     if ((int) $hours === 0 && (int) $minutes === 0 && (int) $seconds > 0) {
                //         $parts[] = (int) $seconds . ' second' . ((int) $seconds > 1 ? 's' : '');
                //     }
            
                //     return implode(' ', $parts);
                // })
                // ->dehydrateStateUsing(function ($state) {
                //     try {
                //         $interval = CarbonInterval::make($state);
                //         return $interval ? gmdate('H:i:s', $interval->totalSeconds) : null;
                //     } catch (\Exception $e) {
                //         return null;
                //     }
                // }),
            
                TextInput::make('resolution_time')
                ->label('Resolution Time')
                ->required(),            
                // ->formatStateUsing(function ($state) {
                //     if (!$state) return null;
            
                //     [$hours, $minutes, $seconds] = explode(':', $state);
            
                //     $parts = [];
            
                //     if ((int) $hours > 0) {
                //         $parts[] = (int) $hours . ' hour' . ((int) $hours > 1 ? 's' : '');
                //     }
            
                //     if ((int) $minutes > 0) {
                //         $parts[] = (int) $minutes . ' minute' . ((int) $minutes > 1 ? 's' : '');
                //     }
            
                //     if ((int) $hours === 0 && (int) $minutes === 0 && (int) $seconds > 0) {
                //         $parts[] = (int) $seconds . ' second' . ((int) $seconds > 1 ? 's' : '');
                //     }
            
                //     return implode(' ', $parts);
                // })
                // ->dehydrateStateUsing(function ($state) {
                //     try {
                //         $interval = CarbonInterval::make($state);
                //         return $interval ? gmdate('H:i:s', $interval->totalSeconds) : null;
                //     } catch (\Exception $e) {
                //         return null;
                //     }
                // }),

                Select::make('escalated_to_user_id')
                ->label('Escalated to')
                ->options(User::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),

                Toggle::make('is_default')
                ->label('Is Default ?')
                ->default(false)
                ->inline(false),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('description')->searchable()->label('Ticket Issue'),
                TextColumn::make('department.name')->label('Department'),
                TextColumn::make('purpose.name')->label('Purpose'),

                TextColumn::make('response_time')
                    ->label('Response Time'),
                    // ->formatStateUsing(function ($state) {
                    //     if (!$state) {
                    //         return '-';
                    //     }
                
                    //     [$hours, $minutes, $seconds] = explode(':', $state);
                
                    //     $parts = [];
                
                    //     if ((int) $hours > 0) {
                    //         $parts[] = (int) $hours . ' hour' . ((int) $hours > 1 ? 's' : '');
                    //     }
                
                    //     if ((int) $minutes > 0) {
                    //         $parts[] = (int) $minutes . ' minute' . ((int) $minutes > 1 ? 's' : '');
                    //     }
                
                    //     if ((int) $hours === 0 && (int) $minutes === 0 && (int) $seconds > 0) {
                    //         $parts[] = (int) $seconds . ' second' . ((int) $seconds > 1 ? 's' : '');
                    //     }
                
                    //     return implode(' ', $parts);
                    // }),
                    
                    TextColumn::make('resolution_time')
                    ->label('Resolution Time'),
                    // ->formatStateUsing(function ($state) {
                    //     if (!$state) {
                    //         return '-';
                    //     }
                
                    //     [$hours, $minutes, $seconds] = explode(':', $state);
                
                    //     $parts = [];
                
                    //     if ((int) $hours > 0) {
                    //         $parts[] = (int) $hours . ' hour' . ((int) $hours > 1 ? 's' : '');
                    //     }
                
                    //     if ((int) $minutes > 0) {
                    //         $parts[] = (int) $minutes . ' minute' . ((int) $minutes > 1 ? 's' : '');
                    //     }
                
                    //     if ((int) $hours === 0 && (int) $minutes === 0 && (int) $seconds > 0) {
                    //         $parts[] = (int) $seconds . ' second' . ((int) $seconds > 1 ? 's' : '');
                    //     }
                
                    //     return implode(' ', $parts);
                    // }),

                TextColumn::make('escalated.name')->label('Escalated To'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSlaConfigurations::route('/'),
            'create' => Pages\CreateSlaConfiguration::route('/create'),
            'edit' => Pages\EditSlaConfiguration::route('/{record}/edit'),
        ];
    }
}
