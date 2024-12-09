<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;

class ProfileController extends Controller
{
    public function index() {

		// Retrieve the authenticated user
		$user = auth()->user();
	
		return view('profile');
	}

	public function update(Request $request) {
		// Retrieve the authenticated user
		$user = auth()->user();
	
		// Validate the request data
		$validated_data = $request->validate([
			'name' => 'required|min:1|max:20',
		]);
	
		// Update the user's name
		$user->name = $validated_data['name'];
	
		// Save the updated user
		$user->save();
	
		// Flash a success message to the session
		session()->flash('success', 'Name updated successfully');
	
		// Redirect back to the previous page
		return redirect()->back();
	}

	public function edit(Request $request) {
		// Retrieve the authenticated user
		$user = auth()->user();
	
		// Validate the request data
		$validated_data = $request->validate([
			'password' => 'required|min:1|max:20',
		]);
	
		// Update the user's name
		$user->password = $validated_data['password'];
	
		// Save the updated user
		$user->save();
	
		// Flash a success message to the session
		session()->flash('success', 'Password updated successfully');
	
		// Redirect back to the previous page
		return redirect()->back();
	}

}
