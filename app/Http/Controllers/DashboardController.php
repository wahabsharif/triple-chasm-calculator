<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\QuestionnaireController;

class DashboardController extends Controller
{
    public function index()
    {

        // Get the profile data from session
        $profileData = Session::get('profile_data', []);

        // Get all questionnaire data with averages
        $questionnaireData = Session::get('questionnaire_data', []);
        $scoreMap = (new QuestionnaireController)->getResponseData();
        $questionnaires = (new QuestionnaireController)->getQuestionnaireDataWithAvg($questionnaireData, $scoreMap);
        $intensityScoreValues = QuestionnaireController::getIntensityScoreValues();

        $vectorResults = [];
        foreach ($questionnaires as $i => $vector) {
            $vectorName = $vector['vector_name'] ?? 'Vector ' . ($i + 1);
            $productMaturityIndex = isset($profileData['product_maturity']) ? (int)$profileData['product_maturity'] : null;
            $intensity_score = null;
            $intensity_score_sum = null;
            $intensity_less_score = null;
            $questionnaire_response_avg = isset($vector['questionnaire_response_avg']) && $vector['questionnaire_response_avg'] !== '' ? (float)$vector['questionnaire_response_avg'] : 0;

            // Intensity score for this vector at product maturity index
            if ($productMaturityIndex !== null && $productMaturityIndex >= 0 && $productMaturityIndex <= 10) {
                if (isset($intensityScoreValues[$i][$productMaturityIndex])) {
                    $intensity_score = $intensityScoreValues[$i][$productMaturityIndex];
                }
            }

            // Sum of all intensity scores for this product maturity index across all vectors
            if ($productMaturityIndex !== null) {
                $intensity_score_sum = 0;
                foreach ($intensityScoreValues as $vec) {
                    if (isset($vec[$productMaturityIndex])) {
                        $intensity_score_sum += $vec[$productMaturityIndex];
                    }
                }
            }
            $intensity_score_sum = $intensity_score_sum ?? 0;
            $intensity_less_score = $intensity_score - $questionnaire_response_avg;
            $intensity_less_score = is_numeric($intensity_less_score) ? number_format($intensity_less_score, 1) : null;

            // Determine status
            $status = '';
            if ($intensity_score_sum == 0) {
                $status = '';
            } elseif ($intensity_less_score < 10) {
                $status = 'Looks good';
            } elseif ($intensity_less_score > 50) {
                $status = 'Needs attention';
            } else {
                $status = 'Needs consideration';
            }

            $vectorResults[] = [
                'vector_name' => $vectorName,
                'intensity_score' => $intensity_score,
                'intensity_score_sum' => $intensity_score_sum,
                'questionnaire_response_avg' => $questionnaire_response_avg,
                'intensity_less_score' => $intensity_less_score,
                'status' => $status
            ];
        }

        Log::info('DashboardController returning vector results', $vectorResults);
        return view('dashboard', compact('profileData', 'vectorResults'));
    }
}
