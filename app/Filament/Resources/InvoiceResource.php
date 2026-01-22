<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Services\PdfService;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Finance';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Invoice Information')->schema([
                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')->required()->searchable()->preload(),
                Forms\Components\Select::make('project_id')
                    ->relationship('project', 'name')->required()->searchable()->preload(),
                Forms\Components\TextInput::make('invoice_number')
                    ->disabled()->dehydrated(false),
                Forms\Components\Select::make('status')
                    ->options([
                        'unpaid' => 'Unpaid',
                        'partial' => 'Partial',
                        'paid' => 'Paid',
                        'overdue' => 'Overdue',
                        'cancelled' => 'Cancelled',
                    ])->default('unpaid')->required(),
            ])->columns(2),
            Forms\Components\Section::make('Items')->schema([
                Forms\Components\Repeater::make('items')
                    ->schema([
                        Forms\Components\TextInput::make('description')->required(),
                        Forms\Components\TextInput::make('quantity')->numeric()->default(1)->required(),
                        Forms\Components\TextInput::make('price')->numeric()->prefix('Rp')->required(),
                    ])->columns(3)->columnSpanFull(),
            ]),
            Forms\Components\Section::make('Financial Details')->schema([
                Forms\Components\TextInput::make('subtotal')->numeric()->prefix('Rp')->default(0),
                Forms\Components\TextInput::make('discount')->numeric()->prefix('Rp')->default(0),
                Forms\Components\TextInput::make('tax')->numeric()->prefix('Rp')->default(0),
                Forms\Components\TextInput::make('total')->numeric()->prefix('Rp')->default(0)->required(),
                Forms\Components\TextInput::make('paid_amount')->numeric()->prefix('Rp')->default(0)->disabled(),
            ])->columns(2),
            Forms\Components\Section::make('Dates')->schema([
                Forms\Components\DatePicker::make('issue_date')->required(),
                Forms\Components\DatePicker::make('due_date')->required(),
                Forms\Components\DatePicker::make('paid_date'),
            ])->columns(3),
            Forms\Components\Section::make('Notes')->schema([
                Forms\Components\Textarea::make('notes')->rows(4)->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('client.name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('project.name')->searchable()->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'unpaid',
                        'info' => 'partial',
                        'success' => 'paid',
                        'danger' => 'overdue',
                        'secondary' => 'cancelled',
                    ]),
                Tables\Columns\TextColumn::make('total')->money('IDR')->sortable(),
                Tables\Columns\TextColumn::make('paid_amount')->money('IDR')->sortable(),
                Tables\Columns\TextColumn::make('due_date')->date()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'unpaid' => 'Unpaid',
                        'partial' => 'Partial',
                        'paid' => 'Paid',
                        'overdue' => 'Overdue',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('download_pdf')
                    ->label('Download PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (Invoice $record) {
                        $pdf = app(\App\Services\PdfService::class)
                            ->generateInvoice($record);

                        return response()->streamDownload(
                            fn () => print($pdf->output()),
                            'invoice-' . $record->invoice_number . '.pdf'
                        );
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}