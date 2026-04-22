<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<h1>Dashboard</h1>

<h3>Total Income: Rp {{ number_format($totalIncome) }}</h3>
<h3>Total Expense: Rp {{ number_format($totalExpense) }}</h3>
<h3>Net Profit: Rp {{ number_format($netProfit) }}</h3>

<h3>Best Product: 
    {{ $bestProduct->name ?? '-' }} ({{ $bestProduct->total ?? 0 }})
</h3>

<hr>

<h2>Income vs Expense</h2>
<canvas id="lineChart"></canvas>

<hr>

<h2>Income by Category</h2>
<canvas id="pieChart"></canvas>

<script>
    // DATA DARI LARAVEL
    const lineLabels = @json($lineChart['labels']);
    const incomeData = @json($lineChart['income']);
    const expenseData = @json($lineChart['expense']);

    const categoryLabels = @json(array_keys($incomeByCategory->toArray()));
    const categoryData = @json(array_values($incomeByCategory->toArray()));

    // LINE CHART
    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: lineLabels,
            datasets: [
                {
                    label: 'Income',
                    data: incomeData,
                    borderWidth: 2
                },
                {
                    label: 'Expense',
                    data: expenseData,
                    borderWidth: 2
                }
            ]
        }
    });

    // PIE CHART
    new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: {
            labels: categoryLabels,
            datasets: [{
                data: categoryData
            }]
        }
    });
</script>

</body>
</html>