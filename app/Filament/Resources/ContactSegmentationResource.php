<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactSegmentationResource\Pages;
use App\Filament\Resources\ContactSegmentationResource\RelationManagers;
use App\Models\ContactSegmentation;
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
use Filament\Forms\Components\RichEditor;

class ContactSegmentationResource extends Resource
{
    protected static ?string $model = ContactSegmentation::class;

    protected static ?string $navigationIcon = 'heroicon-s-phone';

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

                RichEditor::make('description')
                ->required()
                ->columnSpanFull(),

                Toggle::make('is_default')
                ->label('Is Default?')
                ->default(false)
                ->inline(false),

                Toggle::make('status')
                ->label('Status')
                ->default(true)
                ->inline(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->label('Name'),
                TextColumn::make('description')
                ->markdown()
                ->limit(100)
                ->label('Description'),                
                IconColumn::make('is_default')->boolean()->label('Is Default?'),
                IconColumn::make('status')->boolean()->label('Status'),
                
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
            'index' => Pages\ListContactSegmentations::route('/'),
            'create' => Pages\CreateContactSegmentation::route('/create'),
            'edit' => Pages\EditContactSegmentation::route('/{record}/edit'),
        ];
    }
}
