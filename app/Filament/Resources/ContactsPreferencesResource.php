<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactsPreferencesResource\Pages;
use App\Filament\Resources\ContactsPreferencesResource\RelationManagers;
use App\Models\ContactsPreferences;
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

class ContactsPreferencesResource extends Resource
{
    protected static ?string $model = ContactsPreferences::class;

    protected static ?string $navigationIcon = 'heroicon-s-phone';

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

                Select::make('whatsapp_pref')
                ->label('WhatsApp Preference')
                ->options([
                    'Personal' => 'Personal',
                    'Business' => 'Business',
                ])
                ->required(),

                Select::make('mailing_address_pref')
                ->label('Mailing Address Preference')
                ->options([
                    'Home' => 'Home',
                    'Business' => 'Business',
                    'Other' => 'Other',
                ])
                ->required(),

                TextInput::make('language_pref')
                ->label('Preferred Language')
                ->maxLength(50),

                Toggle::make('email_opt_in')
                ->label('Email Opt-In')
                ->default(true)
                ->inline(false),

                Toggle::make('whatsapp_opt_in')
                ->label('WhatsApp Opt-In')
                ->default(true)
                ->inline(false),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('contact.name')->searchable()->label('Contact'),
                TextColumn::make('whatsapp_pref')->searchable()->label('WhatsApp Pref'),
                TextColumn::make('mailing_address_pref')->searchable()->label('Mailing Addr Pref'),
                TextColumn::make('language_pref')->searchable()->label('Language'),
                IconColumn::make('email_opt_in')->boolean()->label('Email Opt-In'),
                IconColumn::make('whatsapp_opt_in')->boolean()->label('WhatsApp Opt-In'),

                
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
            'index' => Pages\ListContactsPreferences::route('/'),
            'create' => Pages\CreateContactsPreferences::route('/create'),
            'edit' => Pages\EditContactsPreferences::route('/{record}/edit'),
        ];
    }
}
