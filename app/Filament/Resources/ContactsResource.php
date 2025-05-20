<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactsResource\Pages;
use App\Filament\Resources\ContactsResource\RelationManagers;
use App\Models\Contacts;
use App\Models\ContactType;
use App\Models\Designations;
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

class ContactsResource extends Resource
{
    protected static ?string $model = Contacts::class;

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

                Select::make('contact_segmentation_id')
                ->label('Contact Segmentation')
                ->options(ContactSegmentation::all()->pluck('name', 'id'))
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
                TextColumn::make('name')->searchable()->label('Name'),
                TextColumn::make('email')->searchable()->label('Email'),
                TextColumn::make('status')->searchable()->label('Status'),
                TextColumn::make('contactType.name')->searchable()->label('Contact Type'),
                TextColumn::make('designation.name')->searchable()->label('Designation'),
                TextColumn::make('contactSegmentation.name')->searchable()->label('Contact Segmentation'),
                TextColumn::make('preferred_contact_method')->searchable()->label('Preferred Contact Method'),
                TextColumn::make('contact_priority')->searchable()->label('Contact Priority'),
                TextColumn::make('time_zone')->searchable()->label('Time Zone'),
                IconColumn::make('is_active')->boolean()->label('Is Active'),
                TextColumn::make('country')->searchable()->label('Country'),                
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
