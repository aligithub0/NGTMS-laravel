<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResponseTemplatesResource\Pages;
use App\Filament\Resources\ResponseTemplatesResource\RelationManagers;
use App\Models\ResponseTemplates;
use App\Models\FieldVariables;
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
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\View;

    

class ResponseTemplatesResource extends Resource
{
    protected static ?string $model = ResponseTemplates::class;

    protected static ?string $navigationIcon = 'heroicon-s-ticket';

    public static function getNavigationSort(): int
    {
        $currentFile = basename((new \ReflectionClass(static::class))->getFileName());
        return NavigationOrder::getSortOrderByFilename($currentFile) ?? parent::getNavigationSort();
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

    public static function getNavigationGroup(): ?string
    {
        $currentFile = basename((new \ReflectionClass(static::class))->getFileName());
        return NavigationOrder::getNavigationGroupByFilename($currentFile);
    }

    public static function parseTemplate(string $template, array $variables): string
{
    foreach ($variables as $key => $value) {
        $template = str_replace('{' . $key . '}', $value, $template);
    }

    return $template;
}


   public static function form(Form $form): Form
{
    return $form
        ->schema([
            TextInput::make('title')
                ->label('Title')
                ->required()
                ->maxLength(255),

                Grid::make(2)->schema([
                    RichEditor::make('message')
                        ->required()
                        ->label('Message')
                        ->columnSpan(1)
                        ->reactive(),
                    View::make('filament.forms.components.variable-list')->columnSpan(1),
                ]),
                


        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->label('Title'),
                TextColumn::make('message')
                ->markdown()
                ->limit(100)
                ->label('Message'),
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
            'index' => Pages\ListResponseTemplates::route('/'),
            'create' => Pages\CreateResponseTemplates::route('/create'),
            'edit' => Pages\EditResponseTemplates::route('/{record}/edit'),
        ];
    }
}
