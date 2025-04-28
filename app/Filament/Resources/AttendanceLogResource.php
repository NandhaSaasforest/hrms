<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceLogResource\Pages;
use App\Filament\Resources\AttendanceLogResource\RelationManagers;
use App\Models\AttendanceLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceLogResource extends Resource
{
    protected static ?string $navigationGroup = 'Attendance';

    protected static ?string $model = AttendanceLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employee_id')
                    ->label('Employee id')
                    ->relationship('employee', 'first_name')
                    ->required(),
                Forms\Components\DatePicker::make('date')
                ->label('Date')
                ->required(),
                Forms\Components\TimePicker::make('login_time')
                    ->required(),
                Forms\Components\TimePicker::make('logout_time'),
                // Forms\Components\Toggle::make('status')
                //     ->label('Status (In / Out)')
                //     ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.first_name')
                    ->numeric()
                    ->label('Employee Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')->sortable()->date(),
                Tables\Columns\TextColumn::make('login_time'),
                Tables\Columns\TextColumn::make('logout_time'),
                // Tables\Columns\IconColumn::make('status')->boolean(),
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
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListAttendanceLogs::route('/'),
            // 'create' => Pages\CreateAttendanceLog::route('/create'),
            // 'edit' => Pages\EditAttendanceLog::route('/{record}/edit'),
        ];
    }
}
