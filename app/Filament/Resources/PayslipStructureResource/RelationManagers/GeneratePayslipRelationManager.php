<?php

namespace App\Filament\Resources\PayslipStructureResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GeneratePayslipRelationManager extends RelationManager
{
    protected static string $relationship = 'generatePayslip';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('payslip_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('payslip_id')
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
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
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
}
