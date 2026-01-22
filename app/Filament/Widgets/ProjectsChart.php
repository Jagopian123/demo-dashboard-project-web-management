<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Widgets\ChartWidget;

class ProjectsChart extends ChartWidget
{
    protected static ?string $heading = 'Projects by Status';
    protected static ?int $sort = 3;
    protected static ?string $maxHeight = '250px';

    protected function getData(): array
    {
        $statuses = [
            'quotation' => 'Quotation',
            'in_progress' => 'In Progress',
            'review' => 'Review',
            'completed' => 'Completed',
            'on_hold' => 'On Hold',
            'cancelled' => 'Cancelled',
        ];

        $data = [];
        $labels = [];
        $colors = [
            'rgba(251, 191, 36, 0.7)',
            'rgba(59, 130, 246, 0.7)',
            'rgba(14, 165, 233, 0.7)',
            'rgba(34, 197, 94, 0.7)',
            'rgba(156, 163, 175, 0.7)',
            'rgba(239, 68, 68, 0.7)',
        ];

        foreach ($statuses as $key => $label) {
            $count = Project::where('status', $key)->count();
            if ($count > 0) {
                $data[] = $count;
                $labels[] = $label;
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Projects',
                    'data' => $data,
                    'backgroundColor' => $colors,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}