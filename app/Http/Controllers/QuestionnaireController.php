<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class QuestionnaireController extends Controller
{
    /**
     * Store questionnaire responses
     */
    public function store(Request $request)
    {
        // Determine if this is an AJAX auto-save or a full form submit
        if ($request->expectsJson() || $request->ajax()) {
            $field = $request->input('field');
            $value = $request->input('value');
            if (!$field) {
                return response()->json(['success' => false, 'message' => 'Field is required.'], 422);
            }
            // Get current data, update the field, and save back to session
            $data = session()->get('questionnaire_data', []);
            $data[$field] = $value;
            session(['questionnaire_data' => $data]);
            return response()->json(['success' => true]);
        }

        // Full form submit: collect all fields
        $questionnaireData = $request->except(['_token']);
        session(['questionnaire_data' => $questionnaireData]);
        return redirect()->route('questionnaire.show')->with('success', 'Questionnaire saved successfully!');
    }

    /**
     * Show the questionnaire form
     */
    public function show()
    {
        $scoreMap = $this->getResponseData();
        $questionnaireData = session()->get('questionnaire_data', []);
        $questionnaires = $this->getQuestionnaireDataWithAvg($questionnaireData, $scoreMap);
        return view('questionnaire', compact('questionnaires', 'scoreMap', 'questionnaireData'));
    }

    /**
     * Add vector average to each questionnaire vector
     */
    public function getQuestionnaireDataWithAvg($questionnaireData, $scoreMap)
    {
        $questionnaires = $this->getQuestionnaireData();

        foreach ($questionnaires as &$vector) {
            $vectorFieldNames = [];
            $id = $vector['id'];

            // Generate field names for this vector
            for ($i = 0; $i < count($vector['questions']); $i++) {
                if ($id <= 4) {
                    $vectorFieldNames[] = 'Q' . (($id - 1) * 3 + $i + 1);
                } else {
                    $vectorCodes = [
                        5 => 'I1',
                        6 => 'I2',
                        7 => 'I3',
                        8 => 'I4',
                        9 => 'I5',
                        10 => 'I6',
                        11 => 'C1',
                        12 => 'C2',
                    ];
                    $vectorFieldNames[] = $vectorCodes[$id] . '_' . ($i + 1);
                }
            }

            $responseScores = [];
            $responseLabels = [];

            // Get response scores for this vector
            foreach ($vectorFieldNames as $fname) {
                $selectedLabel = $questionnaireData[$fname] ?? null;
                if ($selectedLabel && isset($scoreMap[$selectedLabel])) {
                    $score = $scoreMap[$selectedLabel];
                    $responseScores[] = $score;
                    $responseLabels[] = $selectedLabel;
                }
            }

            // Calculate questionnaire_response_avg: sum of response scores divided by 3
            if (count($responseScores) === 3) {
                $scoreSum = array_sum($responseScores);
                $questionnaire_response_avg = $scoreSum / 3;
                $vector['questionnaire_response_avg'] = number_format($questionnaire_response_avg, 1);
            } else {
                $vector['questionnaire_response_avg'] = '';
            }
        }

        return $questionnaires;
    }

    /**
     * Get all questionnaire data
     */
    public function index(): JsonResponse
    {
        $questionnaires = $this->getQuestionnaireData();

        return response()->json([
            'success' => true,
            'data' => $questionnaires,
            'total' => count($questionnaires)
        ]);
    }

    /**
     * Get questionnaire by ID
     */
    public function getById($id): JsonResponse
    {
        $questionnaires = $this->getQuestionnaireData();

        $questionnaire = collect($questionnaires)->firstWhere('id', (int)$id);

        if (!$questionnaire) {
            return response()->json([
                'success' => false,
                'message' => 'Questionnaire not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $questionnaire
        ]);
    }

    /**
     * Get response values mapping
     */
    public function getResponseValues(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->getResponseData()
        ]);
    }

    /**
     * Get intensity score values
     */
    public function getIntensityScores(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->getIntensityScoreValues()
        ]);
    }

    /**
     * Calculate scores for submitted responses
     */
    public function calculateScores(Request $request): JsonResponse
    {
        $request->validate([
            'responses' => 'required|array',
            'responses.*.vector_id' => 'required|integer|between:1,12',
            'responses.*.answers' => 'required|array|size:3',
            'responses.*.answers.*' => 'required|integer|between:0,100'
        ]);

        $responses = $request->input('responses');
        $intensityScores = $this->getIntensityScoreValues();
        $responseValueMap = $this->getResponseData();
        $results = [];

        foreach ($responses as $response) {
            $vectorId = $response['vector_id'];
            $answers = $response['answers'];

            // Calculate average response score (assume numeric input as before)
            $averageScore = array_sum($answers) / count($answers);

            // Find closest intensity score index (0-10 scale)
            $intensityIndex = min(10, max(0, round($averageScore / 10)));

            // Get the corresponding intensity score
            $intensityScore = $intensityScores[$vectorId - 1][$intensityIndex];

            // Calculate questionnaire_response_avg - ALWAYS sum of response numbers divided by 3
            $answerSum = array_sum($answers);
            $questionnaire_response_avg = $answerSum / 3;

            $results[] = [
                'vector_id' => $vectorId,
                'average_response_score' => $averageScore,
                'intensity_score' => $intensityScore,
                'intensity_index' => $intensityIndex,
                'questionnaire_response_avg' => number_format($questionnaire_response_avg, 1)
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $results
        ]);
    }

    /**
     * Get complete questionnaire data structure
     */
    private function getQuestionnaireData(): array
    {
        return [
            [
                'id' => 1,
                'vector_name' => 'E1. Market Spaces',
                'questions' => [
                    'We have assessed, selected and prioritised the target market space(s) for our product or service.',
                    'We understand how value creation activity is structured in our target market space(s), from research to full deployment with mainstream customers / users.',
                    'We know how long it will take to reach the maximum cumulative number of customers for our product or service in our chosen market space(s).'
                ],
                'response' => $this->getResponseData(),
                'intensity_score_values' => [35, 42, 43, 48, 53, 67, 79, 72, 68, 71, 63]
            ],
            [
                'id' => 2,
                'vector_name' => 'E2. Proposition Framing',
                'questions' => [
                    'We have identified the key potential customers, partners, suppliers and competitors in our target market space(s) and defined their contribution to the relevant parts of the market space value chain(s).',
                    'We are aware of and have implemented a strategy to satisfy all the regulatory and sustainability requirements to operate in our target market space(s).',
                    'We have mapped our product or service against our target market space value chain(s), defining its contribution to the relevant parts of the value chain(s) and validated our understanding.'
                ],
                'response' => $this->getResponseData(),
                'intensity_score_values' => [17, 32, 48, 52, 67, 69, 79, 76, 59, 49, 28]
            ],
            [
                'id' => 3,
                'vector_name' => 'E3. Customer Definition',
                'questions' => [
                    'We have identified our target customer types (i.e. governments, businesses, knowledge and affinity-centric workers, consumers), understand their buying behaviour, and have validated our understanding.',
                    'We know our customers\' and users\' specific needs, understand how our product or service can address them, and have validated our understanding with sales to mainstream customers.',
                    'We have accurately estimated the size of the serviceable market in terms of the maximum number of potential customers and users, and total sales revenue per customer in our chosen market space(s).'
                ],
                'response' => $this->getResponseData(),
                'intensity_score_values' => [15, 16, 21, 31, 45, 63, 89, 92, 95, 96, 98]
            ],
            [
                'id' => 4,
                'vector_name' => 'E4. Distribution, Marketing and Sales',
                'questions' => [
                    'We are aware of and have implemented a strategy to address our market entry challenges including product management, pricing, marketing & sales, channels and post-sales support.',
                    'We know what our main channels to market are (direct, franchisees, agents, distributors, outlets, strategic partners) in our target market(s) and have developed and implemented commercial agreements with our channel partners.',
                    'We have developed, validated and implemented sales processes that allows us to sell our product or service to our target customers directly and / or through our channel partners.'
                ],
                'response' => $this->getResponseData(),
                'intensity_score_values' => [5, 5, 13, 23, 31, 34, 72, 92, 94, 95, 97]
            ],
            [
                'id' => 5,
                'vector_name' => 'I1. Tech. Development and Contingent Deployment',
                'questions' => [
                    'We are clear about the importance of technology in our offering, ranging from it being INTEGRAL to our product or service, to our offering being ENABLED by it, to technology being IRRELEVANT to our offering.',
                    'We have characterised our technology stack (from base tech to application tech, to platforms, apps & tools, products, and services), selected the relevant components for our proposition, and understand the implications of our choices.',
                    'We have a clear technology deployment strategy for the development of our offering including the role of partners, suppliers and other service providers.'
                ],
                'response' => $this->getResponseData(),
                'intensity_score_values' => [81, 89, 91, 93, 78, 77, 69, 49, 27, 16, 15]
            ],
            [
                'id' => 6,
                'vector_name' => 'I2. IP Management',
                'questions' => [
                    'We are aware of all forms of IP including registered rights, unregistered rights, and open rights, and understand how to protect them appropriately in our target market(s).',
                    'We have a clear, comprehensive and validated IP strategy that supports the commercialisation of our product or service with all relevant considerations including protection, assignment, licencing and freedom to operate.',
                    'We have strong and defensible IP that underpins the commercialisation of our product or service by supporting all relevant activities including fundraising.'
                ],
                'response' => $this->getResponseData(),
                'intensity_score_values' => [31, 39, 49, 63, 68, 73, 73, 59, 48, 39, 17]
            ],
            [
                'id' => 7,
                'vector_name' => 'I3. Product & Service Definition and Synthesis',
                'questions' => [
                    'We understand whether our product or service design is driven by customer pull, technology push or a mix of both.',
                    'We understand the sustainability impact of all the components which make up our product or service and have put a strategy in place to maximise the sustainability of our product or service.',
                    'We have a strong product management focus; understanding all the key components that make up our final product or service, and how they satisfy customer and user needs.'
                ],
                'response' => $this->getResponseData(),
                'intensity_score_values' => [18, 28, 37, 49, 52, 68, 88, 89, 76, 59, 39]
            ],
            [
                'id' => 8,
                'vector_name' => 'I4. Manufacturing & deployment',
                'questions' => [
                    'We are aware of and have implemented a strategy to address our manufacturing and deployment needs including components, supply chain, processes, and integrated operations.',
                    'The delivery of our product or service can be achieved using existing manufacturing and deployment approaches.',
                    'We have proven our manufacturing and deployment approach at commercial volumes and are clear about the associated economics and sustainability.'
                ],
                'response' => $this->getResponseData(),
                'intensity_score_values' => [2, 5, 6, 9, 19, 33, 49, 73, 88, 91, 82]
            ],
            [
                'id' => 9,
                'vector_name' => 'I5. Talent, Leadership and Culture',
                'questions' => [
                    'We have effective access to all the skills required to deliver our commercialisation plans through our team and key partners / suppliers.',
                    'We have a clear team / organisational structure and processes, including inspiring descriptions of all team members\' roles, mapped against key business processes.',
                    'Our leadership style and culture are aligned with our stated intentions and actual behaviours, and they support the delivery of our commercialisation plans.'
                ],
                'response' => $this->getResponseData(),
                'intensity_score_values' => [17, 29, 32, 41, 53, 62, 79, 93, 94, 95, 95]
            ],
            [
                'id' => 10,
                'vector_name' => 'I6. Funding and Investment',
                'questions' => [
                    'We understand the various sources of funding (e.g. own / family resources, grants, debt, angel / VC / CVC / PE investors and customers) available for our commercialisation plans, what motivates them, and how to access them.',
                    'We have a clear, realistic and validated funding strategy in place to support our commercialisation plans.',
                    'We have a clear understanding of our valuation and how we are perceived by our key stakeholders including investors.'
                ],
                'response' => $this->getResponseData(),
                'intensity_score_values' => [22, 32, 37, 41, 62, 91, 93, 93, 79, 62, 18]
            ],
            [
                'id' => 11,
                'vector_name' => 'C1. Strategic Positioning',
                'questions' => [
                    'We understand conventional generic sources of competitive advantage including low cost, technology-based advantage, differentiated product or service, first-mover advantage and time-based advantage.',
                    'We understand the Triple Chasm approach to dynamic competitive advantage including differentiation based on the meso-economic vectors.',
                    'We have a well-considered and validated strategic position for our product or service in our target market space(s) including clear priorities that drive our execution effort.'
                ],
                'response' => $this->getResponseData(),
                'intensity_score_values' => [11, 21, 31, 41, 59, 79, 89, 91, 91, 80, 59]
            ],
            [
                'id' => 12,
                'vector_name' => 'C2. Business Models',
                'questions' => [
                    'We are aware of business models relevant to our product or service, and their underlying logic of value creation activities.',
                    'We have developed a comprehensive business model covering all drivers of revenue, costs and profit, and have validated it with mainstream customers, suppliers and partners.',
                    'We are tracking and improving our execution performance using relevant metrics derived from our business model.'
                ],
                'response' => $this->getResponseData(),
                'intensity_score_values' => [1, 2, 5, 8, 29, 68, 89, 98, 98, 92, 71]
            ]
        ];
    }

    /**
     * Get response data mapping
     */
    public function getResponseData(): array
    {
        return [
            'Strongly disagree' => 0,
            'Disagree' => 25,
            'Neutral' => 50,
            'Agree' => 75,
            'Strongly agree' => 100
        ];
    }

    /**
     * Get intensity score values for all vectors
     */
    public static function getIntensityScoreValues(): array
    {
        return [
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
            [1, 2, 5, 8, 29, 68, 89, 98, 98, 92, 71]      // C2. Business Models
        ];
    }
}
