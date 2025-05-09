<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use App\Models\Meneus;
use App\Models\Designations;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use App\Models\Role;
use App\Models\Department;
use App\Models\UserStatus;



class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?int $navigationSort = 7; 

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

                TextInput::make('password')
                ->label('Password')
                ->password()
                ->dehydrateStateUsing(fn ($state) => bcrypt($state))
                ->required(fn ($livewire) => $livewire instanceof \App\Filament\Resources\UserResource\Pages\CreateUser)
                ->rules(['required_with:password_confirmation', 'string', 'min:8', 'confirmed'])
                ->required(),

            TextInput::make('password_confirmation')
                ->label('Confirm Password')
                ->password()
                ->required(fn ($livewire) => $livewire instanceof \App\Filament\Resources\UserResource\Pages\CreateUser)
                ->dehydrated(false)
                ->required(),

                Select::make('role_id')
                ->label('Role')
                ->options(Role::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),


                Select::make('department_id')
                ->label('Department')
                ->options(Department::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->required(),

                Select::make('manager_id')
                ->label('Manager')
                ->options(User::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),


                Select::make('status_id')
                    ->label('Status')
                    ->options(UserStatus::all()->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->required(),

                
                Select::make('designation_id')
                ->label('Designation')
                ->options(Designations::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->required(),

                Select::make('company_id')
                ->label('Company')
                ->options(Company::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->required()
                ->live()
                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                    if ($state) {
                        $company = \App\Models\Company::find($state);
                        $set('company_code', $company->company_code);  
                        if ($get('emp_ref_no')) {
                            $set('emp_no', $company->company_code . '-' . $get('emp_ref_no'));
                        }
                    }
                }),
            
            TextInput::make('emp_ref_no')
                ->label('Employee Reference No')
                ->required()
                ->live()
                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                    if ($state && $get('company_id')) {
                        $company = \App\Models\Company::find($get('company_id'));
                        $set('emp_no', $company->company_code . '-' . $state);
                    }
                }),
            
            TextInput::make('emp_no')
                ->label('Employee Number')
                ->disabled()
                ->dehydrated(),

            
    
                    TextInput::make('max_ticket_threshold')
                    ->numeric()
                    ->rules(['required', 'integer', 'min:1']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('email'),
                TextColumn::make('role.name')->label('Role'),
                TextColumn::make('department.name')->label('Department'),
                TextColumn::make('manager.name')->label('Manager'),
                TextColumn::make('designation.name')->label('Designation'),
                TextColumn::make('company.name')->label('Company'),
                TextColumn::make('emp_no')->label('Employee No'),
                TextColumn::make('status.name')->label('Status'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
