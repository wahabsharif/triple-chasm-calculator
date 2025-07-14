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

        // Steps data for dashboard
        $stepsData = [
            0 => "Complete the PROFILE & QUESTIONNAIRE.",
            1100 => "Your total score is unusually high so you should consider reassessing your input after reviewing the Triple Chasm resources including our website and /or books.\n  \nIf you are still confident of your input, it looks like you are ready for the next step on your commercialisation journey. Download our Commercialisation Canvas to start planning or get in touch if you’d like to join one of our market space focussed commercialisation programmes.",
            100 => "Your total score is unusually low so you should consider reassessing your input after reviewing the Triple Chasm resources including our website and / or books. \n  \nIf you are still confident of your input, it looks like you need to act quickly to get your business back on track. Contact us to discuss your situation and the most appropriate next steps.",
            15 => "It looks like you’re in good shape and ready for the next step. \n    \nYour product looks good relative to the average Commercialisation Intensity for 304 successfully commercialised products at the selected Maturity. So, we’d suggest downloading our Commercialisation Canvas to start planning or get in touch if you’d like to join one of our market space focussed commercialisation programmes.”",
            7 => "It looks like you’ve got a lot of work to do to achieve your selected Maturity.\n   \nYour product falls short relative to the average Commercialisation Intensity for 304 successfully commercialised products at the selected Maturity. So, we’d suggest you first reassess your input after reviewing the Triple Chasm resources including our website and books. \n   \nIf you are still confident of your input we’d suggest you download our Commercialisation Canvas to help prioritise your next steps or get in touch if you’d like to discuss your situation and / or join one of our market space focussed commercialisation programmes.",
            'ELSE' => "It looks like you’re facing a few challenges and need to prioritise your effort for the next step along the commercialisation journey. \n   \nYour product looks OK relative to the average Commercialisation Intensity for 304 successfully commercialised products at the selected Maturity. So, we’d suggest downloading our Commercialisation Canvas to start planning or get in touch if you’d like to join one of our market space focussed commercialisation programmes.”"
        ];

        $vectorResults = [];
        $questionnaire_response_avg_sum = array_sum(array_map(function ($vector) {
            return isset($vector['questionnaire_response_avg']) && $vector['questionnaire_response_avg'] !== '' ? (float)$vector['questionnaire_response_avg'] : 0;
        }, $questionnaires));

        $status_count_sum = 0;

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
            $status_count = 0; // Initialize for this vector

            if ($intensity_score_sum == 0) {
                $status = '';
            } elseif ($intensity_less_score < 10) {
                $status = 'Looks good';
            } elseif ($intensity_less_score > 50) {
                $status = 'Needs attention';
            } else {
                $status = 'Needs consideration';
            }

            // Count status as per rules
            if ($status === 'Looks good') {
                $status_count = 2;
            } elseif ($status === 'Needs consideration') {
                $status_count = 1;
            } else {
                $status_count = 0;
            }

            $status_count_sum += $status_count;

            $vectorResults[] = [
                'vector_name' => $vectorName,
                'intensity_score' => $intensity_score,
                'intensity_score_sum' => $intensity_score_sum,
                'questionnaire_response_avg' => $questionnaire_response_avg,
                'intensity_less_score' => $intensity_less_score,
                'questionnaire_response_avg_sum' => $questionnaire_response_avg_sum,
                'status' => $status,
                'status_count' => $status_count,
            ];
        }

        Log::info('DashboardController returning vector results', $vectorResults);
        Log::info('Total status_count_sum: ' . $status_count_sum);

        return view('dashboard', compact('profileData', 'vectorResults', 'stepsData', 'questionnaire_response_avg_sum', 'status_count_sum'));
    }
}
