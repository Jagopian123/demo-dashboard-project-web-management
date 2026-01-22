<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestProjects extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Project::query()
                    ->with(['client'])
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('code')->searchable(),
                Tables\Columns\TextColumn::make('name')->searchable()->limit(30),
                Tables\Columns\TextColumn::make('client.name')->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'quotation',
                        'primary' => 'in_progress',
                        'info' => 'review',
                        'success' => 'completed',
                        'secondary' => 'on_hold',
                        'danger' => 'cancelled',
                    ]),
                Tables\Columns\TextColumn::make('progress')->suffix('%'),
                Tables\Columns\TextColumn::make('deadline')->date(),
            ]);
    }
}