<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function show()
    {
        $profileData = Session::get('profile_data', []);
        return view('profile', compact('profileData'));
    }

    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'assessment_type' => 'required|string',
            'assessment_date' => 'required|date',
            'target_date' => 'nullable|date',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'venture_name' => 'required|string|max:255',
            'venture_motivation' => 'required|string',
            'venture_sustainability_attitude' => 'required|string',
            'product_name' => 'required|string|max:255',
            'product_maturity' => 'required|integer|min:0|max:10',
            'primary_sector' => 'required|string',
            'other_sector' => 'nullable|string',
            'fte_employees' => 'required|numeric|min:0',
            'valuation' => 'required|string',
            'grants_awarded' => 'required|string',
            'equity_investment' => 'required|string',
            'sales_revenue' => 'required|string',
            'estimated_net_profit' => 'required|string',
        ]);

        // Store the data in session (you might want to store in database instead)
        Session::put('profile_data', $validatedData);

        return redirect()->route('dashboard')->with('success', 'Profile data saved successfully!');
    }
}