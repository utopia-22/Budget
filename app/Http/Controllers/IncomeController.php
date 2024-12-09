<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
	public function index() {

		// Retrieve the authenticated user
		$user = auth()->user();

		// Retrieve income records associated with the authenticated user
		$incomes = Income::where('user_id', $user->id)
						 ->select(['id', 'source', 'amount', 'description', 'user_id'])
						 ->paginate(12);
	
		return view('income', ['incomes' => $incomes]);
	}

	public function store(Request $request) {

		$validated_data = $request->validate([
			'source' => 'required|min:1|max:20',
			'amount' => 'required|numeric',
			'description' => 'required|min:1|max:10'
		]);
	
		$income = new Income($validated_data);
        $income->user_id = Auth::id();
        $income->save();
	
		return redirect()->route('income')->with('success', 'Your income has been added');
	}

	public function destroy($id) {
		$income = Income::findOrFail($id); 
		$income->delete(); 
	
		return redirect()->route('income')->with('success', 'Your transaction has been deleted');
	}
	
}
