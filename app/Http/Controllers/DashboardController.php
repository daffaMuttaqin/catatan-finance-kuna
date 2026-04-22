<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $month = now()->month;
        $year = now()->year;

        // TOTAL INCOME
        $totalIncome = Income::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum(DB::raw('price * COALESCE(quantity,1)'));

        // TOTAL EXPENSE
        $totalExpense = Expense::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('price');

        $netProfit = $totalIncome - $totalExpense;

        // BEST PRODUCT
        $bestProduct = Income::select('name', DB::raw('SUM(quantity) as total'))
            ->groupBy('name')
            ->orderByDesc('total')
            ->first();

        // LINE CHART
        $incomeChart = Income::select(
            DB::raw('DATE(date) as date'),
            DB::raw('SUM(price * COALESCE(quantity,1)) as total')
        )
            ->whereMonth('date', $month)
            ->groupBy('date')
            ->pluck('total', 'date');

        $expenseChart = Expense::select(
            DB::raw('DATE(date) as date'),
            DB::raw('SUM(price) as total')
        )
            ->whereMonth('date', $month)
            ->groupBy('date')
            ->pluck('total', 'date');

        $dates = collect($incomeChart->keys())
            ->merge($expenseChart->keys())
            ->unique()
            ->sort();

        $lineChart = [
            'labels' => $dates->values(),
            'income' => $dates->map(fn($d) => $incomeChart[$d] ?? 0),
            'expense' => $dates->map(fn($d) => $expenseChart[$d] ?? 0),
        ];

        // PIE CHART
        $incomeByCategory = Income::select(
            'category',
            DB::raw('SUM(price * COALESCE(quantity,1)) as total')
        )
            ->whereMonth('date', $month)
            ->groupBy('category')
            ->pluck('total', 'category');

        return view('dashboard', compact(
            'totalIncome',
            'totalExpense',
            'netProfit',
            'bestProduct',
            'lineChart',
            'incomeByCategory'
        ));
    }
}
