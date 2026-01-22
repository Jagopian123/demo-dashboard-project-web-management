<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class RevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Monthly Revenue';
    protected static ?int $sort = 2;
    protected static ?string $maxHeight = '250px';

    protected function getData(): array
    {
        $data = Invoice::where('status', 'paid')
            ->whereYear('paid_date', now()->year)
            ->select(
                DB::raw('MONTH(paid_date) as month'),
                DB::raw('SUM(total) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $revenues = array_fill(0, 12, 0);

        foreach ($data as $item) {
            $revenues[$item->month - 1] = $item->total;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Revenue (IDR)',
                    'data' => $revenues,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                    'borderColor' => 'rgb(59, 130, 246)',
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}