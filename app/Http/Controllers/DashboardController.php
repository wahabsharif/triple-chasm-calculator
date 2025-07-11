<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the profile data from session
        $profileData = Session::get('profile_data', []);

        // Get vector results from VectorController
        $vectorResults = [];
        $vectorController = app(\App\Http\Controllers\VectorController::class);
        $response = $vectorController->calculate(request());
        if (method_exists($response, 'getData')) {
            $data = $response->getData(true);
            if (isset($data['results'])) {
                $vectorResults = $data['results'];
            }
        }

        return view('dashboard', compact('profileData', 'vectorResults'));
    }
}
