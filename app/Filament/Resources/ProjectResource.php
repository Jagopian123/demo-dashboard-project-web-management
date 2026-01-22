<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Management';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Project Information')->schema([
                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')->required()->searchable()->preload(),
                Forms\Components\TextInput::make('name')->required()->maxLength(255),
                Forms\Components\TextInput::make('code')->required()->unique(ignoreRecord: true)->maxLength(255),
                Forms\Components\Select::make('status')
                    ->options([
                        'quotation' => 'Quotation',
                        'in_progress' => 'In Progress',
                        'review' => 'Review',
                        'completed' => 'Completed',
                        'on_hold' => 'On Hold',
                        'cancelled' => 'Cancelled',
                    ])->default('quotation')->required(),
                Forms\Components\Select::make('priority')
                    ->options(['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'])
                    ->default('medium')->required(),
                Forms\Components\TextInput::make('price')
                    ->numeric()->prefix('Rp')->default(0),
            ])->columns(2),
            Forms\Components\Section::make('Timeline')->schema([
                Forms\Components\DatePicker::make('start_date'),
                Forms\Components\DatePicker::make('deadline'),
                Forms\Components\DatePicker::make('completed_date'),
                Forms\Components\TextInput::make('progress')
                    ->numeric()->suffix('%')->minValue(0)->maxValue(100)->default(0),
            ])->columns(2),
            Forms\Components\Section::make('Details')->schema([
                Forms\Components\Textarea::make('description')->rows(3)->columnSpanFull(),
                Forms\Components\TextInput::make('project_url')->url()->maxLength(255)->columnSpanFull(),
                Forms\Components\Textarea::make('notes')->rows(4)->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('client.name')->searchable()->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'quotation',
                        'primary' => 'in_progress',
                        'info' => 'review',
                        'success' => 'completed',
                        'secondary' => 'on_hold',
                        'danger' => 'cancelled',
                    ]),
                Tables\Columns\BadgeColumn::make('priority')
                    ->colors(['success' => 'low', 'warning' => 'medium', 'danger' => 'high']),
                Tables\Columns\TextColumn::make('price')->money('IDR')->sortable(),
                Tables\Columns\TextColumn::make('progress')->suffix('%')->sortable(),
                Tables\Columns\TextColumn::make('deadline')->date()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'quotation' => 'Quotation',
                        'in_progress' => 'In Progress',
                        'review' => 'Review',
                        'completed' => 'Completed',
                        'on_hold' => 'On Hold',
                        'cancelled' => 'Cancelled',
                    ]),
                Tables\Filters\SelectFilter::make('priority')
                    ->options(['low' => 'Low', 'medium' => 'Medium', 'high' => 'High']),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}