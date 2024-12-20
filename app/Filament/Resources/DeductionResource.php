<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeductionResource\Pages;
use App\Filament\Resources\DeductionResource\RelationManagers;
use App\Models\Deduction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeductionResource extends Resource
{
    protected static ?string $navigationGroup = 'Payslips';

    protected static ?string $model = Deduction::class;

    protected static ?string $navigationIcon = 'heroicon-o-minus-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employees')
                    ->preload()
                    ->multiple()
                    ->relationship(titleAttribute: 'first_name')
                    ->searchable(['first_name'])
                    // ->relationship('employee', 'name')
                    ->label('Employee Name')
                    ->helperText('Select the employee name.')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->unique()
                    ->label('Deduction Name')
                    ->helperText('Enter the name of the deduction.')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('deduction')
                    ->label('Deduction Amount')
                    ->helperText('Enter the Deduction Amount')
                    ->required()
                    ->numeric()
                    ->default(0.00),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deduction')
                    ->formatStateUsing(callback: fn($state): string => '₹' . $state)
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
            'index' => Pages\ListDeductions::route('/'),
            'create' => Pages\CreateDeduction::route('/create'),
            // 'edit' => Pages\EditDeduction::route('/{record}/edit'),
        ];
    }
}
