<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactsPhoneNumbersResource\Pages;
use App\Filament\Resources\ContactsPhoneNumbersResource\RelationManagers;
use App\Models\ContactsPhoneNumbers;
use App\Models\Contacts;
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

class ContactsPhoneNumbersResource extends Resource
{
    protected static ?string $model = ContactsPhoneNumbers::class;

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
                Select::make('contact_id')
                ->label('Contact')
                ->options(Contacts::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->required(),

                Select::make('phone_type')
                ->label('Phone Type')
                ->required()
                ->options([
                    'Mobile' => 'Mobile',
                    'Home' => 'Home',
                    'Business' => 'Business',
                    'Office' => 'Office',
                ]),

                TextInput::make('phone_number')
                ->label('Phone Number')
                ->required()
                ->tel()
                ->maxLength(20),

                Toggle::make('is_whatsapp')
                ->label('Is WhatsApp?')
                ->default(true)
                ->inline(false),

                Toggle::make('is_preferred')
                ->label('Is Preferred?')
                ->default(true)
                ->inline(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('contact.name')->searchable()->label('Contact'),
                TextColumn::make('phone_type')->searchable()->label('Phone Type'),
                TextColumn::make('phone_number')->searchable()->label('Phone Number'),
                IconColumn::make('is_whatsapp')->boolean()->label('WhatsApp'),
                IconColumn::make('is_preferred')->boolean()->label('Preferred'),
                
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
            'index' => Pages\ListContactsPhoneNumbers::route('/'),
            'create' => Pages\CreateContactsPhoneNumbers::route('/create'),
            'edit' => Pages\EditContactsPhoneNumbers::route('/{record}/edit'),
        ];
    }
}
