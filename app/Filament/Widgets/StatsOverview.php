<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    use InteractsWithPageFilters;
    protected function getStats(): array
    {

        $startDate = ! is_null($this->filters['startDate'] ?? null) ?
            Carbon::parse($this->filters['startDate']) :
            null;

        $endDate = ! is_null($this->filters['endDate'] ?? null) ?
            Carbon::parse($this->filters['endDate']) :
            now();

        $totalIncome = Transaction::income()->whereBetween('transaction_date', [$startDate, $endDate])->sum('amount');

        $totalExpense = Transaction::expense()->whereBetween('transaction_date', [$startDate, $endDate])->sum('amount');


        return [
            Stat::make('Total Income', 'Rp. ' . number_format($totalIncome, 0, ',', '.',)),
            Stat::make('Total Expense', 'Rp. ' . number_format($totalExpense, 0, ',', '.')),
            Stat::make('Total Profit', 'Rp. ' . number_format($totalIncome - $totalExpense,     0, ',', '.'),),
        ];
    }
}
