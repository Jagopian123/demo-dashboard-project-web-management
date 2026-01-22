<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UpcomingDeadlines extends BaseWidget
{
    protected static ?string $heading = 'Upcoming Deadlines';
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Project::query()
                    ->with(['client'])
                    ->whereIn('status', ['in_progress', 'review'])
                    ->whereNotNull('deadline')
                    ->where('deadline', '>=', now())
                    ->orderBy('deadline')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('code')->searchable(),
                Tables\Columns\TextColumn::make('name')->searchable()->limit(30),
                Tables\Columns\TextColumn::make('client.name')->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'primary' => 'in_progress',
                        'info' => 'review',
                    ]),
                Tables\Columns\TextColumn::make('deadline')
                    ->date()
                    ->description(fn (Project $record): string => 
                        now()->diffInDays($record->deadline) . ' days left'
                    )
                    ->color(fn (Project $record): string => 
                        now()->diffInDays($record->deadline) <= 7 ? 'danger' : 'success'
                    ),
                Tables\Columns\TextColumn::make('progress')->suffix('%'),
            ]);
    }
}