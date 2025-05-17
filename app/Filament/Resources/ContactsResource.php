<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactsResource\Pages;
use App\Filament\Resources\ContactsResource\RelationManagers;
use App\Models\Contacts;
use App\Models\ContactType;
use App\Models\Designations;
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

class ContactsResource extends Resource
{
    protected static ?string $model = Contacts::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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

                
                TextInput::make('email')
                ->required()
                ->email()
                ->unique(ignoreRecord: true) 
                ->rules(['email', 'required', 'max:255']),  

                Toggle::make('status')
                ->label('Active')
                ->default(true)
                ->inline(false),

                Select::make('contact_type_id')
                ->label('Contact Type')
                ->options(ContactType::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->required(),

                Select::make('designation_id')
                ->label('Designation')
                ->options(Designations::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->required(),

                TextInput::make('preferred_contact_method')
                ->label('Preferred Contact Method')
                ->maxLength(50),

                TextInput::make('contact_priority')
                ->label('Contact Priority')
                ->maxLength(50),

                TextInput::make('time_zone')
                ->label('Time Zone')
                ->maxLength(100),

                Toggle::make('is_active')
                ->label('Is Active')
                ->default(true)
                ->inline(false),

                TextInput::make('picture_url')
                ->label('Picture URL')
                ->maxLength(255)
                ->nullable(),

                TextInput::make('country')
                ->label('Country')
                ->maxLength(100)
                ->nullable(),

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
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContacts::route('/create'),
            'edit' => Pages\EditContacts::route('/{record}/edit'),
        ];
    }
}
