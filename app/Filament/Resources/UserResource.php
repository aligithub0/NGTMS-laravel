<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use App\Models\Meneus;
use App\Models\UserType;
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
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Facades\Storage;




class UserResource extends Resource
{
    protected static ?string $model = User::class;

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


    protected static ?string $navigationIcon = 'heroicon-s-user';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->required()
                ->rules([
                    'required',
                    
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
            ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
            ->rules(['nullable', 'string', 'min:8', 'confirmed'])
            ->afterStateHydrated(fn ($component, $state) => $component->state('')) 
            ->required(fn ($livewire) => $livewire instanceof CreateUser)
            ->helperText(fn ($livewire) => $livewire instanceof CreateUser ? null : 'Leave blank to keep the current password'),

        TextInput::make('password_confirmation')
            ->label('Confirm Password')
            ->password()
            ->dehydrated(false)
            ->rules(['nullable'])
            ->required(fn ($livewire) => $livewire instanceof CreateUser),
            
            

                Select::make('role_id')
                ->label('Role')
                ->options(Role::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
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

                Select::make('user_type_id')
                ->label('User Type')
                ->options(UserType::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),

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


                Select::make('department_id')
                ->label('Department')
                ->options(Department::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->required(),

                TextInput::make('emp_no')
                ->label('Employee Number')
                ->disabled()
                ->dehydrated(),

                Select::make('designation_id')
                ->label('Designation')
                ->options(Designations::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->required(),

                Select::make('status_id')
                ->label('Status')
                ->options(UserStatus::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->required(),



                Select::make('manager_id')
                ->label('Manager')
                ->options(User::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable(),

                Toggle::make('assigned_to_others')
                ->label('Assigned to Others')
                ->default(false)
                ->inline(false),

                FileUpload::make('picture')
                ->label('Profile Picture')
                ->image()
                ->imageEditor()
                ->directory('images')
                ->visibility('public')
                ->preserveFilenames()
                ->enableDownload()
                ->enableOpen()
                ,
    
                    TextInput::make('max_ticket_threshold')
                    ->numeric()
                    ->rules(['required', 'integer', 'min:1']),

                    Toggle::make('is_first_time')
                    ->label('Is First Time')
                    ->default(true)
                    ->inline(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->label('Name')
                ->formatStateUsing(function ($state, $record) {
                    $url = $record->picture
                        ? Storage::disk('public')->url($record->picture)
                        : 'https://ui-avatars.com/api/?name=' . urlencode($record->name);
                
                    return '<div class="flex items-center gap-2">
                                <img src="' . $url . '" class="h-8 w-8 rounded-full object-cover" />
                                <span>' . e($record->name) . '</span>
                            </div>';
                })
                ->html()
                ->searchable(),


                            TextColumn::make('email'),
                TextColumn::make('role.name')->label('Role'),
                TextColumn::make('userType.name')->label('User Type'),
                TextColumn::make('company.name')->label('Company'),
                TextColumn::make('emp_no')->label('Employee No'),
                TextColumn::make('department.name')->label('Department'),
                TextColumn::make('designation.name')->label('Designation'),
                TextColumn::make('manager.name')->label('Manager'),
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
