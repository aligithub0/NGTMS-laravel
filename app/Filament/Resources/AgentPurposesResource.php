<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgentPurposesResource\Pages;
use App\Filament\Resources\AgentPurposesResource\RelationManagers;
use App\Models\AgentPurposes;
use App\Models\User;
use App\Models\Purpose;
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

class AgentPurposesResource extends Resource
{
    protected static ?string $model = AgentPurposes::class;

    protected static ?int $navigationSort = 9; 

    public static function getNavigationLabel(): string
    {
        return 'Agent Purpose'; 
    
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                ->label('User')
                ->options(User::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),


                Select::make('purpose_id')
                ->label('Purpose')
                ->options(Purpose::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('User'),
                TextColumn::make('purpose.name')->label('Purpose'),
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
            'index' => Pages\ListAgentPurposes::route('/'),
            'create' => Pages\CreateAgentPurposes::route('/create'),
            'edit' => Pages\EditAgentPurposes::route('/{record}/edit'),
        ];
    }
}
