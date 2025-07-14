<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\QuestionnaireController;

class DashboardController extends Controller
{
    public function index()
    {

        // Get the profile data from session
        $profileData = Session::get('profile_data', []);

        // Get product_maturity from profile data and calculate intensity_score
        $intensity_score = null;
        $intensity_score_sum = null;
        $intensityScoreValues = QuestionnaireController::getIntensityScoreValues();

        if (isset($profileData['product_maturity'])) {
            $productMaturityIndex = (int) $profileData['product_maturity'];
            if ($productMaturityIndex >= 0 && $productMaturityIndex <= 10) {
                // Use the first vector (index 0) as per instruction
                if (isset($intensityScoreValues[0][$productMaturityIndex])) {
                    $intensity_score = $intensityScoreValues[0][$productMaturityIndex];
                }
            }
        }

        // Calculate sum of all intensity scores for the selected product_maturity index (column) across all vectors
        if (isset($productMaturityIndex)) {
            $intensity_score_sum = 0;
            foreach ($intensityScoreValues as $vector) {
                if (isset($vector[$productMaturityIndex])) {
                    $intensity_score_sum += $vector[$productMaturityIndex];
                }
            }
        }

        // Ensure intensity_score_sum is always set (0 if not calculated)
        $intensity_score_sum = $intensity_score_sum ?? 0;
        return view('dashboard', compact('profileData',  'intensity_score', 'intensity_score_sum'));
    }
}
