<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QuestionnaireController extends Controller
{
    public function show()
    {
        $questionnaireData = Session::get('questionnaire_data', []);
        $scoreMap = [
            'Strongly disagree' => 0,
            'Disagree' => 25,
            'Neutral' => 50,
            'Agree' => 75,
            'Strongly agree' => 100,
        ];

        // Calculate section averages
        $sectionAverages = $this->calculateSectionAverages($questionnaireData);

        return view('questionnaire', compact('questionnaireData', 'scoreMap', 'sectionAverages'));
    }

    public function store(Request $request)
    {
        // Map dropdown values to numeric scores
        $scoreMap = [
            'Strongly disagree' => 0,
            'Disagree' => 25,
            'Neutral' => 50,
            'Agree' => 75,
            'Strongly agree' => 100,
        ];

        // Build questionnaire data for all questions (Q1-Q12 + I1-I6 + C1-C2)
        $questionnaireData = [];

        // Handle Q1-Q12 (dropdown questions)
        for ($i = 1; $i <= 12; $i++) {
            $key = 'Q' . $i;
            $input = $request->input($key);
            if ($input && isset($scoreMap[$input])) {
                $questionnaireData[$key] = $scoreMap[$input];
            }
        }

        // Handle I1-I6 sections (3 questions each)
        for ($i = 1; $i <= 6; $i++) {
            for ($j = 1; $j <= 3; $j++) {
                $key = 'I' . $i . '_' . $j;
                $input = $request->input($key);
                if ($input && isset($scoreMap[$input])) {
                    $questionnaireData[$key] = $scoreMap[$input];
                }
            }
        }

        // Handle C1-C2 sections (3 questions each)
        for ($i = 1; $i <= 2; $i++) {
            for ($j = 1; $j <= 3; $j++) {
                $key = 'C' . $i . '_' . $j;
                $input = $request->input($key);
                if ($input && isset($scoreMap[$input])) {
                    $questionnaireData[$key] = $scoreMap[$input];
                }
            }
        }

        // Calculate section averages
        $sectionAverages = $this->calculateSectionAverages($questionnaireData);

        // Store both individual responses and section averages
        Session::put('questionnaire_data', $questionnaireData);
        Session::put('section_averages', $sectionAverages);

        return redirect()->route('dashboard')->with('success', 'Questionnaire saved!');
    }

    private function calculateSectionAverages($questionnaireData)
    {
        $sectionAverages = [];

        // Define section mappings
        $sections = [
            'E1' => ['Q1', 'Q2', 'Q3'],
            'E2' => ['Q4', 'Q5', 'Q6'],
            'E3' => ['Q7', 'Q8', 'Q9'],
            'E4' => ['Q10', 'Q11', 'Q12'],
            'I1' => ['I1_1', 'I1_2', 'I1_3'],
            'I2' => ['I2_1', 'I2_2', 'I2_3'],
            'I3' => ['I3_1', 'I3_2', 'I3_3'],
            'I4' => ['I4_1', 'I4_2', 'I4_3'],
            'I5' => ['I5_1', 'I5_2', 'I5_3'],
            'I6' => ['I6_1', 'I6_2', 'I6_3'],
            'C1' => ['C1_1', 'C1_2', 'C1_3'],
            'C2' => ['C2_1', 'C2_2', 'C2_3'],
        ];

        // Calculate average for each section
        foreach ($sections as $sectionKey => $questionKeys) {
            $total = 0;
            $count = 0;

            foreach ($questionKeys as $questionKey) {
                if (isset($questionnaireData[$questionKey]) && is_numeric($questionnaireData[$questionKey])) {
                    $total += $questionnaireData[$questionKey];
                    $count++;
                }
            }

            // Calculate average (sum / 3) only if we have responses
            if ($count > 0) {
                $sectionAverages[$sectionKey] = round($total / 3, 2);
            } else {
                $sectionAverages[$sectionKey] = 0;
            }
        }

        return $sectionAverages;
    }

    public function getSectionAverages()
    {
        $questionnaireData = Session::get('questionnaire_data', []);
        return $this->calculateSectionAverages($questionnaireData);
    }
}
