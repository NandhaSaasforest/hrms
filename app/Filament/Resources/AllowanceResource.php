<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AllowanceResource\Pages;
use App\Filament\Resources\AllowanceResource\RelationManagers;
use App\Models\Allowance;
use Dotenv\Util\Regex;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AllowanceResource extends Resource
{
    protected static ?string $navigationGroup = 'Payslips';

    protected static ?string $model = Allowance::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-rupee';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employees')
                    ->preload()
                    ->multiple()
                    ->relationship(titleAttribute:'first_name')
                    ->searchable(['first_name'])
                    ->required()
                    ->label('Employee Name')
                    ->helperText('Select the employee.'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->rule('regex:/^[a-zA-Z\s]+$/')
                    ->unique(ignoreRecord: true)
                    ->label('Allowance Name')
                    ->helperText('The name must contain only letters and spaces.')
                    ->maxLength(255),
                Forms\Components\TextInput::make('allowance')
                    ->required()
                    ->label('Allowance Amount')
                    ->helperText('Enter the allowance amount.')
                    ->numeric()
                    ->default(0.00),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Allowance Name'),
                Tables\Columns\TextColumn::make('allowance')
                    ->formatStateUsing(callback: fn($state): string => '₹' . $state)
                    ->searchable()
                    ->label('Allowance Amount'),
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
            'index' => Pages\ListAllowances::route('/'),
            'create' => Pages\CreateAllowance::route('/create'),
            // 'edit' => Pages\EditAllowance::route('/{record}/edit'),
        ];
    }
}
