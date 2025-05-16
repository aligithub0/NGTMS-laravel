<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactsSocialLinksResource\Pages;
use App\Filament\Resources\ContactsSocialLinksResource\RelationManagers;
use App\Models\ContactsSocialLinks;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactsSocialLinksResource extends Resource
{
    protected static ?string $model = ContactsSocialLinks::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListContactsSocialLinks::route('/'),
            'create' => Pages\CreateContactsSocialLinks::route('/create'),
            'edit' => Pages\EditContactsSocialLinks::route('/{record}/edit'),
        ];
    }
}
