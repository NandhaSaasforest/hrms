<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeaveRequestResource\Pages;
use App\Filament\Resources\LeaveRequestResource\RelationManagers;
use App\Models\Employee;
use App\Models\Holiday;
use App\Models\LeaveRequest;
use Closure;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Psy\Command\WhereamiCommand;

class LeaveRequestResource extends Resource
{
    protected static ?string $model = LeaveRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employee_id')
                    ->label('Employee')
                    ->relationship('employee', 'first_name')
                    ->required()
                    ->helperText('Select the employee requesting leave.'),
                Forms\Components\DatePicker::make('leave_date')
                    ->label('Leave Date')
                    ->required()
                    ->helperText('Select the date for the leave request. Leave dates cannot overlap with holidays.')
                    ->rules([
                        fn(Get $get, $operation): Closure => function (string $attribute, $value, Closure $fail) use ($get, $operation) {
                            // Check if the leave date is a holiday
                            if (Holiday::whereDate('holiday_date', $value)->exists()) {
                                $fail("Leave cannot be requested on a holiday: {$value}.");
                            }

                            // Additional validation for duplicate leave requests for the same employee
                            $employeeId = $get('employee_id');
                            if ($employeeId && LeaveRequest::where('employee_id', $employeeId)
                                ->whereDate('leave_date', $value)
                                ->when($operation === 'edit', function ($query) use ($get) {
                                    $query->where('id', '!=', $get('id')); // Exclude the current record when editing
                                })->exists()
                            ) {
                                $fail("The employee already has a leave request for this date: {$value}.");
                            }
                        }
                    ]),
                Forms\Components\Textarea::make('reason')
                    ->label('Reason')
                    ->nullable()
                    ->maxLength(65534)
                    ->helperText('Provide a reason for the leave request (optional).'),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->visible(fn() =>  Employee::where('email', Auth::user()->email)
                        ->where('is_manager', 1)
                        ->exists())
                    ->options([
                        'Pending' => 'Pending',
                        'Approved' => 'Approved',
                        'Rejected' => 'Rejected',
                    ])
                    ->default('Pending')
                    ->helperText('Set the current status of the leave request.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.first_name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('leave_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
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
            'index' => Pages\ListLeaveRequests::route('/'),
            'create' => Pages\CreateLeaveRequest::route('/create'),
            // 'edit' => Pages\EditLeaveRequest::route('/{record}/edit'),
        ];
    }
}
