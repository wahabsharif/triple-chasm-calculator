<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the profile data from session
        $profileData = Session::get('profile_data', []);

        return view('dashboard', compact('profileData'));
    }
}
