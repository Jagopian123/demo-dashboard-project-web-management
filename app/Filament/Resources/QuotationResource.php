<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuotationResource\Pages;
use App\Models\Quotation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Services\PdfService;

class QuotationResource extends Resource
{
    protected static ?string $model = Quotation::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Finance';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Quotation Information')->schema([
                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')->required()->searchable()->preload(),
                Forms\Components\TextInput::make('quotation_number')
                    ->disabled()->dehydrated(false),
                Forms\Components\Select::make('package_type')
                    ->options([
                        'basic' => 'Basic',
                        'professional' => 'Professional',
                        'premium' => 'Premium',
                        'custom' => 'Custom',
                    ])->default('custom')->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'sent' => 'Sent',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                        'expired' => 'Expired',
                    ])->default('draft')->required(),
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
            ])->columns(2),
            Forms\Components\Section::make('Dates')->schema([
                Forms\Components\DatePicker::make('valid_until'),
                Forms\Components\DatePicker::make('sent_date'),
                Forms\Components\DatePicker::make('accepted_date'),
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
                Tables\Columns\TextColumn::make('quotation_number')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('client.name')->searchable()->sortable(),
                Tables\Columns\BadgeColumn::make('package_type')
                    ->colors([
                        'secondary' => 'basic',
                        'info' => 'professional',
                        'success' => 'premium',
                        'warning' => 'custom',
                    ]),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'draft',
                        'info' => 'sent',
                        'success' => 'accepted',
                        'danger' => 'rejected',
                        'warning' => 'expired',
                    ]),
                Tables\Columns\TextColumn::make('total')->money('IDR')->sortable(),
                Tables\Columns\TextColumn::make('valid_until')->date()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'sent' => 'Sent',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                        'expired' => 'Expired',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('download_pdf')
                    ->label('Download PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (Quotation $record) {
                        $pdf = app(\App\Services\PdfService::class)
                            ->generateQuotation($record);

                        return response()->streamDownload(
                            fn () => print($pdf->output()),
                            'quotation-' . $record->quotation_number . '.pdf'
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
            'index' => Pages\ListQuotations::route('/'),
            'create' => Pages\CreateQuotation::route('/create'),
            'edit' => Pages\EditQuotation::route('/{record}/edit'),
        ];
    }
}