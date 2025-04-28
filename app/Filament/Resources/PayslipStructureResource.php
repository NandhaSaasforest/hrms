<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PayslipStructureResource\Pages;
use App\Filament\Resources\PayslipStructureResource\RelationManagers;
use App\Filament\Resources\PayslipStructureResource\RelationManagers\GeneratePayslipRelationManager;
use App\Models\PayslipStructure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PayslipStructureResource extends Resource
{
    protected static ?string $navigationGroup = 'Payslips';
    protected static ?string $navigationLabel = 'Generate Payslip';

    protected static ?string $model = PayslipStructure::class;

    protected static ?string $navigationIcon = 'heroicon-s-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Payslip Details')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('payslip_name')
                                    ->maxLength(225)
                                    ->rule('regex:/^[a-zA-Z\s]+$/')
                                    ->label('Payslip Name')
                                    ->helperText('The name must contain only letters and spaces')
                                    ->required(),

                                Forms\Components\DatePicker::make('start_date')
                                    ->label('Start Date')
                                    ->required(),

                                Forms\Components\DatePicker::make('end_date')
                                    ->label('End Date')
                                    ->rule(function ($get) {
                                        return function ($attribute, $value, $fail) use ($get) {
                                            $startDate = $get('start_date');
                                            if ($startDate && $value <= $startDate) {
                                                $fail('The End Date must be after the Start Date.');
                                            }
                                        };
                                    })
                                    ->required(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('payslip_name')->label('Payslip Name'),
                Tables\Columns\TextColumn::make('start_date')->label('Start Date')->money(),
                Tables\Columns\TextColumn::make('end_date')->label('End Date')->money(),
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
            GeneratePayslipRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayslipStructures::route('/'),
            'create' => Pages\CreatePayslipStructure::route('/create'),
            'edit' => Pages\EditPayslipStructure::route('/{record}/edit'),
        ];
    }
}
