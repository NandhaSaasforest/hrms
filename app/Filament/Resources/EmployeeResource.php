<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Personal Information')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->required()
                            ->label('First Name')
                            ->helperText('Enter the employee\'s first name.')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('last_name')
                            ->required()
                            ->label('Last Name')
                            ->helperText('Enter the employee\'s last name.')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->label('Email')
                            ->helperText('Enter a unique and valid email address.')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->label('Phone')
                            ->helperText('Enter the employee\'s contact number.')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('address')
                            ->label('Address')
                            ->maxLength(65534)
                            ->helperText('Optional: Provide the employee\'s address.'),
                    ]),
                Forms\Components\Section::make('Employment Information')
                    ->schema([
                        Forms\Components\Select::make('department_id')
                            ->required()
                            ->relationship('department', 'name')
                            ->label('Department')
                            ->helperText('Select the department for the employee.'),
                        Forms\Components\Toggle::make('is_manager')
                            ->label('Manager')
                            ->helperText('Are you the manager?'),
                        Forms\Components\Select::make('shift_id')
                            ->relationship('shift', 'name')
                            ->nullable()
                            ->label('Shift')
                            ->helperText('Optional: Select the shift for the employee.'),
                        Forms\Components\DatePicker::make('employment_date')
                            ->required()
                            ->label('Employment Date')
                            ->helperText('Enter the employee\'s date of joining.'),
                    ]),

                Forms\Components\Section::make('Salary Information')
                    ->schema([
                        Forms\Components\TextInput::make('salary')
                            ->required()
                            ->numeric()
                            ->label('Base Salary')
                            ->helperText('Enter the employee\'s base salary.'),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->label('First Name')
                    ->color(fn ($record) => $record->is_manager ? 'highlight' : 'default')
                    ->extraAttributes(fn ($record) => $record->is_manager ? ['class' => 'font-bold'] : [])
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->label('Last Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('address')
                //     ->label('Address')
                //     ->toggleable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->label('Department')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('shift.name')
                    ->label('Shift')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('salary')
                    ->label('Salary')
                    ->money('USD')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('employment_date')
                    ->label('Joined Date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            // ->rowClasses(fn ($record) => $record->is_manager ? 'bg-green-100' : '')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->defaultSort('is_manager', 'desc');
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
