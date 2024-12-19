<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceSettingResource\Pages;
use App\Filament\Resources\AttendanceSettingResource\RelationManagers;
use App\Models\AttendanceSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceSettingResource extends Resource
{
    protected static ?string $navigationGroup = 'Attendance';

    protected static ?string $model = AttendanceSetting::class;

    protected static ?string $navigationIcon = 'heroicon-c-cog-6-tooth';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TimePicker::make('total_working_hours')
                    ->required()
                    ->label('Total Working Hours')
                    ->helperText('Define the total working hours required per day.'),
                Forms\Components\TimePicker::make('lunch_hours')
                    ->required()
                    ->label('Lunch Hours')
                    ->helperText('Specify the allocated time for lunch.'),
                Forms\Components\TextInput::make('grace_time_minutes')
                    ->required()
                    ->numeric()
                    ->label('Grace Time (Minutes)')
                    ->helperText('Set grace period in minutes before marking late login.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('total_working_hours')->label('Total Working Hours'),
                Tables\Columns\TextColumn::make('lunch_hours')->label('Lunch Hours'),
                Tables\Columns\TextColumn::make('grace_time_minutes')->label('Grace Time (Minutes)')
                    ->numeric()
                    ->sortable(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttendanceSettings::route('/'),
            // 'create' => Pages\CreateAttendanceSetting::route('/create'),
            'edit' => Pages\EditAttendanceSetting::route('/{record}/edit'),
        ];
    }
}
