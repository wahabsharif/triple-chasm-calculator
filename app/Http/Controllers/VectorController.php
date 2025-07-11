<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VectorController extends Controller
{
    // Full intensity scores table for each vector (0-10 columns)
    private $intensity_scores_table = [
        [35, 42, 43, 48, 53, 67, 79, 72, 68, 71, 63], // E1. Market Spaces
        [17, 32, 48, 52, 67, 69, 79, 76, 59, 49, 28], // E2. Proposition Framing
        [15, 16, 21, 31, 45, 63, 89, 92, 95, 96, 98], // E3. Customer Definition
        [5, 5, 13, 23, 31, 34, 72, 92, 94, 95, 97],   // E4. Distribution, Marketing and Sales
        [81, 89, 91, 93, 78, 77, 69, 49, 27, 16, 15], // I1. Tech. Development and Contingent Deployment
        [31, 39, 49, 63, 68, 73, 73, 59, 48, 39, 17], // I2. IP Management
        [18, 28, 37, 49, 52, 68, 88, 89, 76, 59, 39], // I3. Product & Service Definition and Synthesis
        [2, 5, 6, 9, 19, 33, 49, 73, 88, 91, 82],     // I4. Manufacturing & deployment
        [17, 29, 32, 41, 53, 62, 79, 93, 94, 95, 95], // I5. Talent, Leadership and Culture
        [22, 32, 37, 41, 62, 91, 93, 93, 79, 62, 18], // I6. Funding and Investment
        [11, 21, 31, 41, 59, 79, 89, 91, 91, 80, 59], // C1. Strategic Positioning
        [1, 2, 5, 8, 29, 68, 89, 98, 98, 92, 71],     // C2. Business Models
    ];

    // Vector names and scores
    private $vectors = [
        ['name' => 'E1. Market Spaces', 'vector_score' => 50.0],
        ['name' => 'E2. Proposition Framing', 'vector_score' => 66.7],
        ['name' => 'E3. Customer Definition', 'vector_score' => 75.0],
        ['name' => 'E4. Distribution, Marketing and Sales', 'vector_score' => 33.3],
        ['name' => 'I1. Tech. Development and Contingent Deployment', 'vector_score' => 50.0],
        ['name' => 'I2. IP Management', 'vector_score' => 58.3],
        ['name' => 'I3. Product & Service Definition and Synthesis', 'vector_score' => 41.7],
        ['name' => 'I4. Manufacturing & deployment', 'vector_score' => 25.0],
        ['name' => 'I5. Talent, Leadership and Culture', 'vector_score' => 50.0],
        ['name' => 'I6. Funding and Investment', 'vector_score' => 50.0],
        ['name' => 'C1. Strategic Positioning', 'vector_score' => 75.0],
        ['name' => 'C2. Business Models', 'vector_score' => 33.3],
    ];

    public function calculate(Request $request)
    {
        // Get product_maturity from session (profile_data)
        $product_maturity = 0;
        $profile = Session::get('profile_data', []);
        if (isset($profile['product_maturity']) && is_numeric($profile['product_maturity'])) {
            $product_maturity = (int)$profile['product_maturity'];
        }

        // Only use the table if product_maturity is between 0-10, else all zeros
        $use_scores = ($product_maturity >= 0 && $product_maturity <= 10);

        // Get questionnaire section averages from session (if available)
        $sectionAverages = Session::get('section_averages', []); // expects ['E1' => value, ...]

        $results = [];
        $totals = array_fill(0, 11, 0);
        $count = count($this->vectors);
        $intensity_score_total = 0;
        $intensity_less_score_total = 0;
        $status_count_total = 0;

        // Calculate total_intensity_score_sum for all vectors
        $total_intensity_score_sum = 0;
        $intensity_scores_per_vector = [];
        foreach ($this->vectors as $i => $vector) {
            $intensity_scores_selection = $use_scores ? $this->intensity_scores_table[$i] : array_fill(0, 11, 0);
            $intensity_score = array_sum($intensity_scores_selection);
            $intensity_scores_per_vector[$i] = $intensity_score;
            $total_intensity_score_sum += $intensity_score;
        }

        // Section keys for mapping
        $sectionKeys = [
            'E1',
            'E2',
            'E3',
            'E4',
            'I1',
            'I2',
            'I3',
            'I4',
            'I5',
            'I6',
            'C1',
            'C2',
        ];

        // Now build results with correct status and intensity_less_score
        foreach ($this->vectors as $i => $vector) {
            $intensity_score = $intensity_scores_per_vector[$i];
            // Use section average if available, else vector_score
            $sectionKey = $sectionKeys[$i];
            $sectionAverage = (isset($sectionAverages) && isset($sectionAverages[$sectionKey]) && is_numeric($sectionAverages[$sectionKey]))
                ? (float)$sectionAverages[$sectionKey]
                : $vector['vector_score'];
            $intensity_less_score = $intensity_score - $sectionAverage;

            // Status logic as per user request (strictly follow the order and logic)
            if ($total_intensity_score_sum === 0) {
                $status = " ";
            } elseif ($intensity_less_score > 50) {
                $status = "Needs attention";
            } elseif ($intensity_less_score < 10) {
                $status = "Looks good";
            } else {
                $status = "Needs consideration";
            }

            $results[] = [
                'name' => $vector['name'],
                'vector_score' => $vector['vector_score'],
                'intensity_score' => $intensity_score,
                'intensity_less_score' => $intensity_less_score,
                'intensity_scores_selection' => $use_scores ? $this->intensity_scores_table[$i] : array_fill(0, 11, 0),
                'status' => $status,
            ];
            // Sum columns for totals
            foreach ($use_scores ? $this->intensity_scores_table[$i] : array_fill(0, 11, 0) as $j => $val) {
                $totals[$j] += $val;
            }
            $intensity_score_total += $intensity_score;
            $intensity_less_score_total += $intensity_less_score;
            $status_count_total += ($intensity_score > 0) ? 1 : 0;
        }

        // Calculate averages
        $averages = array_map(function ($total) use ($count) {
            return $count ? $total / $count : 0;
        }, $totals);
        $average_intensity_score = $count ? $intensity_score_total / $count : 0;
        $average_intensity_less_score = $count ? $intensity_less_score_total / $count : 0;
        $average_status_count = $count ? $status_count_total / $count : 0;

        $totals['intensity_score'] = $intensity_score_total;
        $totals['intensity_less_score'] = $intensity_less_score_total;
        $totals['status_count'] = $status_count_total;

        $averages['intensity_score'] = $average_intensity_score;
        $averages['intensity_less_score'] = $average_intensity_less_score;
        $averages['status_count'] = $average_status_count;

        return response()->json([
            'results' => $results,
            'totals' => $totals,
            'averages' => $averages,
            'total_intensity_score_sum' => $total_intensity_score_sum,
        ]);
    }
}
