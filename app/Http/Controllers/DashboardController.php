<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\QuestionnaireController;

class DashboardController extends Controller
{
    private const STEPS_DATA = [
        0 => "Complete the PROFILE & QUESTIONNAIRE.",
        1100 => "Your total score is unusually high so you should consider reassessing your input after reviewing the Triple Chasm resources including our website and /or books.\n\nIf you are still confident of your input, it looks like you are ready for the next step on your commercialisation journey. Download our Commercialisation Canvas to start planning or get in touch if you'd like to join one of our market space focussed commercialisation programmes.",
        100 => "Your total score is unusually low so you should consider reassessing your input after reviewing the Triple Chasm resources including our website and / or books.\n\nIf you are still confident of your input, it looks like you need to act quickly to get your business back on track. Contact us to discuss your situation and the most appropriate next steps.",
        15 => "It looks like you're in good shape and ready for the next step.\n\nYour product looks good relative to the average Commercialisation Intensity for 304 successfully commercialised products at the selected Maturity. So, we'd suggest downloading our Commercialisation Canvas to start planning or get in touch if you'd like to join one of our market space focussed commercialisation programmes.",
        7 => "It looks like you've got a lot of work to do to achieve your selected Maturity.\n\nYour product falls short relative to the average Commercialisation Intensity for 304 successfully commercialised products at the selected Maturity. So, we'd suggest you first reassess your input after reviewing the Triple Chasm resources including our website and books.\n\nIf you are still confident of your input we'd suggest you download our Commercialisation Canvas to help prioritise your next steps or get in touch if you'd like to discuss your situation and / or join one of our market space focussed commercialisation programmes.",
        'ELSE' => "It looks like you're facing a few challenges and need to prioritise your effort for the next step along the commercialisation journey.\n\nYour product looks OK relative to the average Commercialisation Intensity for 304 successfully commercialised products at the selected Maturity. So, we'd suggest downloading our Commercialisation Canvas to start planning or get in touch if you'd like to join one of our market space focussed commercialisation programmes."
    ];

    private const VERY_HIGH_THRESHOLD = 1100;
    private const VERY_LOW_THRESHOLD = 100;
    private const GOOD_THRESHOLD = 15;
    private const WORK_THRESHOLD = 7;

    public function index()
    {
        $profileData = Session::get('profile_data', []);
        $questionnaireData = Session::get('questionnaire_data', []);

        $questionnaireController = new QuestionnaireController();
        $scoreMap = $questionnaireController->getResponseData();
        $questionnaires = $questionnaireController->getQuestionnaireDataWithAvg($questionnaireData, $scoreMap);
        $intensityScoreValues = QuestionnaireController::getIntensityScoreValues();

        $vectorResults = $this->processVectorResults($questionnaires, $profileData, $intensityScoreValues);
        $stepsDataResult = $this->determineStepsDataResult($vectorResults);
        $questionnaire_response_sum_avg = $this->getQuestionnaireResponseSumAvg($vectorResults);

        return view('dashboard', compact(
            'profileData',
            'vectorResults',
            'stepsDataResult',
            'questionnaire_response_sum_avg'
        ));
    }

    private function processVectorResults(array $questionnaires, array $profileData, array $intensityScoreValues): array
    {
        $vectorResults = [];
        $productMaturityIndex = $this->getProductMaturityIndex($profileData);
        $intensityScoreSum = $this->calculateIntensityScoreSum($intensityScoreValues, $productMaturityIndex);

        foreach ($questionnaires as $i => $vector) {
            $vectorName = $vector['vector_name'] ?? "Vector " . ($i + 1);
            $questionnaireResponseAvg = $this->getQuestionnaireResponseAvg($vector);
            $intensityScore = $this->getIntensityScore($intensityScoreValues, $i, $productMaturityIndex);
            $intensityLessScore = $this->calculateIntensityLessScore($intensityScore, $questionnaireResponseAvg);
            $status = $this->determineStatus($intensityScoreSum, $intensityLessScore);

            $vectorResults[] = [
                'vector_name' => $vectorName,
                'intensity_score' => $intensityScore,
                'intensity_score_sum' => $intensityScoreSum,
                'questionnaire_response_avg' => $questionnaireResponseAvg,
                'intensity_less_score' => $intensityLessScore,
                'status' => $status,
                'status_count' => $this->getStatusCount($status),
            ];
        }

        return $vectorResults;
    }

    private function getProductMaturityIndex(array $profileData): ?int
    {
        return isset($profileData['product_maturity']) ? (int)$profileData['product_maturity'] : null;
    }

    private function calculateIntensityScoreSum(array $intensityScoreValues, ?int $productMaturityIndex): int
    {
        if ($productMaturityIndex === null) {
            return 0;
        }

        $sum = 0;
        foreach ($intensityScoreValues as $vector) {
            if (isset($vector[$productMaturityIndex])) {
                $sum += $vector[$productMaturityIndex];
            }
        }

        return $sum;
    }

    private function getQuestionnaireResponseAvg(array $vector): float
    {
        return isset($vector['questionnaire_response_avg']) && $vector['questionnaire_response_avg'] !== ''
            ? (float)$vector['questionnaire_response_avg']
            : 0;
    }

    private function getIntensityScore(array $intensityScoreValues, int $vectorIndex, ?int $productMaturityIndex): ?float
    {
        if ($productMaturityIndex === null || $productMaturityIndex < 0 || $productMaturityIndex > 10) {
            return null;
        }

        return $intensityScoreValues[$vectorIndex][$productMaturityIndex] ?? null;
    }

    private function calculateIntensityLessScore(?float $intensityScore, float $questionnaireResponseAvg): ?string
    {
        if ($intensityScore === null) {
            return null;
        }

        $difference = $intensityScore - $questionnaireResponseAvg;
        return number_format($difference, 1);
    }

    private function determineStatus(int $intensityScoreSum, ?string $intensityLessScore): string
    {
        if ($intensityScoreSum === 0 || $intensityLessScore === null) {
            return '';
        }

        $score = (float)$intensityLessScore;

        if ($score < 10) {
            return 'Looks good';
        } elseif ($score > 50) {
            return 'Needs attention';
        } else {
            return 'Needs consideration';
        }
    }

    private function getStatusCount(string $status): int
    {
        switch ($status) {
            case 'Looks good':
                return 2;
            case 'Needs consideration':
                return 1;
            default:
                return 0;
        }
    }

    private function determineStepsDataResult(array $vectorResults): string
    {
        $questionnaireResponseAvgSum = $this->calculateQuestionnaireResponseAvgSum($vectorResults);
        $statusCountSum = $this->calculateStatusCountSum($vectorResults);
        $intensityScoreSum = $vectorResults[0]['intensity_score_sum'] ?? 0;

        if ($intensityScoreSum === self::VERY_HIGH_THRESHOLD || $questionnaireResponseAvgSum > self::VERY_HIGH_THRESHOLD) {
            return self::STEPS_DATA[self::VERY_HIGH_THRESHOLD];
        }

        if ($questionnaireResponseAvgSum < self::VERY_LOW_THRESHOLD) {
            return self::STEPS_DATA[self::VERY_LOW_THRESHOLD];
        }

        if ($statusCountSum > self::GOOD_THRESHOLD) {
            return self::STEPS_DATA[self::GOOD_THRESHOLD];
        }

        if ($statusCountSum < self::WORK_THRESHOLD) {
            return self::STEPS_DATA[self::WORK_THRESHOLD];
        }

        return self::STEPS_DATA['ELSE'];
    }


    private function calculateQuestionnaireResponseAvgSum(array $vectorResults): float
    {
        return array_sum(array_column($vectorResults, 'questionnaire_response_avg'));
    }

    /**
     * Get the average of all questionnaire_response_avg values and return as questionnaire_response_sum_avg
     */
    public function getQuestionnaireResponseSumAvg(array $vectorResults): float
    {
        $avgs = array_column($vectorResults, 'questionnaire_response_avg');
        $count = count($avgs);
        if ($count === 0) {
            return 0;
        }
        $sum = array_sum($avgs);
        return $sum / $count;
    }

    private function calculateStatusCountSum(array $vectorResults): int
    {
        return array_sum(array_column($vectorResults, 'status_count'));
    }
}
