<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceResource\Pages;
use App\Filament\Resources\AttendanceResource\RelationManagers;
use App\Filament\Resources\AttendanceResource\RelationManagers\AttendancelogRelationManager;
use App\Models\Attendance;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceResource extends Resource
{
    protected static ?string $navigationGroup = 'Attendance';
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employee_id')
                    ->label('Employee Name')
                    ->relationship('employee', 'first_name')
                    ->required()
                    // ->rules(['unique:attendances,employee_id,date'])
                    ->rules([
                        fn(Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                            $date = $get('date'); // Assume 'date' is also part of the form
                            $recordId = $get('id');
                            $duplicateQuery = Attendance::where('employee_id', $value)->whereDate('date', $date);
                            if ($recordId) {
                                $duplicateQuery->where('id', '!=', $recordId);
                            }

                            if ($duplicateQuery->exists()) {
                                $fail('The selected employee already has an attendance record for this date.');
                            }
                        },
                    ])
                    ->validationMessages([
                        'unique' => 'The :attribute has already been registered for this date.',
                    ]),
                Forms\Components\DatePicker::make('date')
                    ->label('Date')
                    ->required(),
                Forms\Components\TimePicker::make('login_time')
                    ->required(),
                Forms\Components\TimePicker::make('logout_time')->after('login_time')->validationMessages([
                    'after' => 'Logout Later.',
                ]),
                // Forms\Components\Toggle::make('status')->label('Status'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.first_name')
                    ->label('Employee Name')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Date')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('late_login')
                    ->label('Late Login')
                    ->boolean(),
                Tables\Columns\IconColumn::make('early_checkout')
                    ->label('Early Checkout')
                    ->boolean(),
                Tables\Columns\TextColumn::make('total_working_hours')->label('Total Worked Hours')->formatStateUsing(fn($state): string => $state . 'hrs'),
                Tables\Columns\TextColumn::make('overtime_hours')->formatStateUsing(fn($state): string => $state . 'hrs'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            AttendancelogRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}
