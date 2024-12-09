<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index() {

		$user = auth()->user();

		$expenses = Expense::where('user_id', $user->id)
						 ->select(['id', 'title', 'amount', 'description', 'user_id'])
						 ->paginate(9);
			
		return view('expense', [
			'expenses' => $expenses
		]);
	}

	public function store(Request $request) {

		$validated_data = $request->validate([
			'title' => 'required|min:1|max:20',
			'amount' => 'required|numeric',
			'description' => 'required|min:1|max:10'
		]);
	
		$expense = new Expense($validated_data);
        $expense->user_id = Auth::id();
        $expense->save();
	
		return redirect()->route('expense')->with('success', 'Your expense has been added');
	}

	public function destroy($id) {
		$expense = Expense::findOrFail($id); 
		$expense->delete(); 
	
		return redirect()->route('expense')->with('success', 'Your transaction has been deleted');
	}
}
