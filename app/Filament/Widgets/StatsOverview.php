<?php

namespace App\Filament\Widgets;

use App\Models\Client;
use App\Models\Project;
use App\Models\Invoice;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalRevenue = Invoice::where('status', 'paid')->sum('total');
        $pendingRevenue = Invoice::whereIn('status', ['unpaid', 'partial'])->sum('total');
        $monthRevenue = Invoice::where('status', 'paid')
            ->whereMonth('paid_date', now()->month)
            ->whereYear('paid_date', now()->year)
            ->sum('total');

        return [
            Stat::make('Total Clients', Client::where('status', 'active')->count())
                ->description('Active clients')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            
            Stat::make('Active Projects', Project::whereIn('status', ['in_progress', 'review'])->count())
                ->description(Project::where('status', 'completed')->count() . ' completed')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('primary'),
            
            Stat::make('Revenue This Month', 'Rp ' . number_format($monthRevenue, 0, ',', '.'))
                ->description('Total: Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),
            
            Stat::make('Pending Invoices', Invoice::whereIn('status', ['unpaid', 'partial'])->count())
                ->description('Rp ' . number_format($pendingRevenue, 0, ',', '.'))
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}