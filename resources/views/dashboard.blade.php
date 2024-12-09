@extends('layouts.app')

@section('js')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


<script>
    $(function() {
        var expenses = {!! $expenses !!};
        var incomes = {!! $incomes !!};

		const incomeTitles = [];
        const incomeAmounts = [];
        incomes.forEach(income => {
            incomeTitles.push(income.source);
            incomeAmounts.push(income.amount);
        });

        const expenseTitles = [];
        const expenseAmounts = [];
        expenses.forEach(expense => {
            expenseTitles.push(expense.title);
            expenseAmounts.push(expense.amount);
        });

		const incomeData = {
            labels: incomeTitles,
            datasets: [{
                label: 'Income Amount',
                data: incomeAmounts,
                backgroundColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)'],
                hoverOffset: 4
            }]
        };

        const expenseData = {
            labels: expenseTitles,
            datasets: [{
                label: 'Expense Amount',
                data: expenseAmounts,
                backgroundColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)'],
                hoverOffset: 4
            }]
        };


		const incomeConfig = {
            type: 'pie',
            data: incomeData,
            options: {
                plugins: {
                    datalabels: {
                        color: 'white',
                        formatter: (value, context) => {
                            const datapoints = context.chart.data.datasets[0].data.map(parseFloat);
							const totalValue = datapoints.reduce((total, datapoint) => total + datapoint, 0);
                            const percentageValue = (value / totalValue * 100).toFixed(1);
							const display = [`${percentageValue}%`]

							return display;
                        }
                    }
                }
            },
			plugins: [ChartDataLabels]
        };


        const expenseConfig = {
            type: 'pie',
            data: expenseData,
            options: {
                plugins: {
                    datalabels: {
                        color: 'white',
                        formatter: (value, context) => {
							const datapoints = context.chart.data.datasets[0].data.map(parseFloat);
							const totalValue = datapoints.reduce((total, datapoint) => total + datapoint, 0);
                            const percentageValue = (value / totalValue * 100).toFixed(1);
							const display = [`${percentageValue}%`]

							return display;
                        }
                    }
                }
            },
			plugins: [ChartDataLabels]
        };

        
        new Chart(document.getElementById('expenseChart'), expenseConfig);
        new Chart(document.getElementById('incomeChart'), incomeConfig);
    });	
</script>
@endsection

@section('content')

@php
    $totalIncome = 0;
    foreach ($incomes as $income) {
        $totalIncome += $income->amount;
    }

    $totalExpense = 0;
    foreach ($expenses as $expense) {
        $totalExpense += $expense->amount;
    }
@endphp

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2">
            <!-- Sidebar -->
            @include('layouts.sidebar')
            <!-- End of Sidebar -->
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Dashboard ') }}</div>

				<div class="d-flex justify-content-center">
					<div class="card col-5 mx-2 my-2 text-center">
						<div class="card-header"><strong>{{ __('Total Balance') }}</strong></div>
						<div class="card-body">
							<p style="color: blue"><strong>RM{{ number_format($totalIncome - $totalExpense, 2) }}</strong></p>
						</div>
					</div>
				</div>

                <div class="d-flex justify-content-between card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

					<div class="card col-5 mx-2 text-center">
						<div class="card-header">{{ __('Total Income ') }}</div>
						<div class="card-body">
							<p style="color: greenyellow;"><strong>+RM{{ number_format($totalIncome, 2) }}</strong></p>
						</div>
					</div>

					<div class="card col-5 mx-2 text-center">
						<div class="card-header"><strong>{{ __('Total Expense ') }}</strong></div>
						<div class="card-body">
							<p style="color: red;"><strong>-RM{{ number_format($totalExpense, 2) }}</strong></p>
						</div>
					</div>

                </div>
				@if($incomes->isNotEmpty() || $expenses->isNotEmpty())
					<div class="d-flex justify-content-between card-body">
						@if($incomes->isNotEmpty())
							<div class="chart-container mx-3 col-5">
								<div class="bg-white rounded shadow">
									<canvas id="incomeChart"></canvas>
								</div>
							</div>
						@endif

						@if($expenses->isNotEmpty())
							<div class="chart-container mx-3 col-5">
								<div class="bg-white rounded shadow">
									<canvas id="expenseChart"></canvas>
								</div>
							</div>
						@endif
					</div>
				@endif
				
            </div>
        </div>
    </div>
</div>

@endsection
