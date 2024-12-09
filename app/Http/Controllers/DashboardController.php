<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Charts\DashboardChart;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DashboardController extends Controller
{

	public function index()
	{

		// Retrieve the authenticated user
		$user = auth()->user();

		$incomes = Income::where('user_id', $user->id)
						->select(['id', 'source', 'amount', 'description', 'user_id'])
						->get();
	
		$expenses = Expense::where('user_id', $user->id)
						->select(['id', 'title', 'amount', 'description', 'user_id'])
						->get();
	
		return view('dashboard', compact( 'expenses','incomes'));
	} 
}


