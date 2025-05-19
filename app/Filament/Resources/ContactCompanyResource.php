<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactCompanyResource\Pages;
use App\Filament\Resources\ContactCompanyResource\RelationManagers;
use App\Models\ContactCompany;
use App\Models\ContactType;
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

class ContactCompanyResource extends Resource
{
    protected static ?string $model = ContactCompany::class;

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

                
                Select::make('parent_comp_id')
                ->label('Parent Company')
                ->options(ContactCompany::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable(),

                Select::make('company_type_id')
                ->label('Contact Type')
                ->options(ContactType::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),

                Toggle::make('is_group')
                ->label('Is Group?')
                ->default(false)
                ->inline(false),

                TextInput::make('company_code')
                ->label('Contact Company Code')
                ->unique(ignoreRecord: true)
                ->rules([
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[a-zA-Z0-9]+$/', 
                ])
                ->extraAttributes(['inputmode' => 'text'])
                ->required(),
                

                Toggle::make('status')
                ->label('Active')
                ->default(true)
                ->inline(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company_code')->label('Contact Company Code'),
                TextColumn::make('name')->searchable(),
                TextColumn::make('contactType.name')->label('Contact Type'),
                TextColumn::make('parentCompany.name')->label('Parent Company'),
                TextColumn::make('is_group')->searchable(),
                IconColumn::make('status')->boolean(),      
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
            'index' => Pages\ListContactCompanies::route('/'),
            'create' => Pages\CreateContactCompany::route('/create'),
            'edit' => Pages\EditContactCompany::route('/{record}/edit'),
        ];
    }
}
