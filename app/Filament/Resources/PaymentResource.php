<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Finance';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Payment Information')->schema([
                Forms\Components\Select::make('invoice_id')
                    ->relationship('invoice', 'invoice_number')->required()->searchable()->preload(),
                Forms\Components\TextInput::make('payment_number')
                    ->disabled()->dehydrated(false),
                Forms\Components\TextInput::make('amount')
                    ->numeric()->prefix('Rp')->required(),
                Forms\Components\Select::make('payment_method')
                    ->options([
                        'bank_transfer' => 'Bank Transfer',
                        'cash' => 'Cash',
                        'credit_card' => 'Credit Card',
                        'e_wallet' => 'E-Wallet',
                        'other' => 'Other',
                    ])->default('bank_transfer')->required(),
                Forms\Components\DatePicker::make('payment_date')->required(),
                Forms\Components\TextInput::make('reference_number')->maxLength(255),
            ])->columns(2),
            Forms\Components\Section::make('Notes')->schema([
                Forms\Components\Textarea::make('notes')->rows(4)->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('payment_number')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('invoice.invoice_number')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('amount')->money('IDR')->sortable(),
                Tables\Columns\BadgeColumn::make('payment_method')
                    ->colors([
                        'primary' => 'bank_transfer',
                        'success' => 'cash',
                        'info' => 'credit_card',
                        'warning' => 'e_wallet',
                        'secondary' => 'other',
                    ]),
                Tables\Columns\TextColumn::make('payment_date')->date()->sortable(),
                Tables\Columns\TextColumn::make('reference_number')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_method')
                    ->options([
                        'bank_transfer' => 'Bank Transfer',
                        'cash' => 'Cash',
                        'credit_card' => 'Credit Card',
                        'e_wallet' => 'E-Wallet',
                        'other' => 'Other',
                    ]),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}