<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GeneratedPayslipsResource\Pages;
use App\Filament\Resources\GeneratedPayslipsResource\RelationManagers;
use App\Models\GeneratedPayslips;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GeneratedPayslipsResource extends Resource
{
    protected static ?string $navigationGroup = "Payslips";
    protected static ?string $model = GeneratedPayslips::class;

    protected static ?string $navigationIcon = 'heroicon-s-clipboard-document-list';
    
    public static function isDiscovered(): bool
    {
        return false;
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('employee_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('payslip_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('attendance_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('total_working_hours')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('total_overtime_hours')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('allowance_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('deduction_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('pf_contribution')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('net_salary')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('payslip_name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee_name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('base_salary')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_working_hours')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_overtime_hours')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('allowance')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deduction')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pf_contribution')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('net_salary')
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
            'index' => Pages\ListGeneratedPayslips::route('/'),
            'create' => Pages\CreateGeneratedPayslips::route('/create'),
            // 'edit' => Pages\EditGeneratedPayslips::route('/{record}/edit'),
        ];
    }
}
