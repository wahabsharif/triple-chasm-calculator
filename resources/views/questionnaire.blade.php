@extends('layouts.main')

@section('content')
    <style>
        select {
            width: 100%;
            height: 100%;
            box-sizing: border-box;
            border: none;
            color: black;
            vertical-align: middle;
            display: block;
            text-align: center;
            font-weight: bold;
            cursor: pointer;
        }

        select:focus {
            outline: none;
            border: none;
        }

        .questionnaire-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .questionnaire-table {
            width: 100%;
            border-collapse: collapse;
        }

        .questionnaire-header-row {
            background: #595959;
            color: #fff;
        }

        .questionnaire-th {
            padding: 10px;
            font-size: 1.5rem
        }

        .vector-col {
            width: 180px;
        }

        .question-col {
            /* default width */
        }

        .response-col {
            width: 200px;
        }

        .questionnaire-table td {
            border-bottom: 1px solid #595959;
            padding: 10px;
            vertical-align: middle;
        }

        .questionnaire-table td[rowspan] {
            font-weight: bold;
        }
    </style>
    <div class="container questionnaire-container">
        <form method="POST" action="{{ route('questionnaire.store') }}" style="border: 4px solid #595959">
            @csrf
            <table class="questionnaire-table">
                <thead>
                    <tr class="questionnaire-header-row">
                        <th class="questionnaire-th vector-col">Vector</th>
                        <th class="questionnaire-th question-col">Question</th>
                        <th class="questionnaire-th response-col">Response</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- E1. Market Spaces -->
                    <tr>
                        <td rowspan="3">E1. Market Spaces</td>
                        <td>We have assessed, selected and prioritised the target market space(s) for our product or
                            service.</td>
                        <td style="background: white">
                            <select name="Q1" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('Q1', $questionnaireData['Q1'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>We understand how value creation activity is structured in our target market space(s), from
                            research to full deployment with mainstream customers / users.</td>
                        <td style="background: white">
                            <select name="Q2" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('Q2', $questionnaireData['Q2'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>We know how long it will take to reach the maximum cumulative number of customers for our
                            product or service in our chosen market space(s).</td>
                        <td style="background: white">
                            <select name="Q3" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('Q3', $questionnaireData['Q3'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <!-- E2. Proposition Framing -->
                    <tr>
                        <td rowspan="3">E2. Proposition Framing</td>
                        <td>We have identified the key potential customers, partners, suppliers and competitors in our
                            target market space(s) and defined their contribution to the relevant parts of the market space
                            value chain(s).</td>
                        <td style="background: white">
                            <select name="Q4" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('Q4', $questionnaireData['Q4'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>We are aware of and have implemented a strategy to satisfy all the regulatory and sustainability
                            requirements to operate in our target market space(s).</td>
                        <td style="background: white">
                            <select name="Q5" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('Q5', $questionnaireData['Q5'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>We have mapped our product or service against our target market space value chain(s), defining
                            its contribution to the relevant parts of the value chain(s) and validated our understanding.
                        </td>
                        <td style="background: white">
                            <select name="Q6" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('Q6', $questionnaireData['Q6'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <!-- E3. Customer Definition -->
                    <tr>
                        <td rowspan="3">E3. Customer Definition</td>
                        <td>We have identified our target customer types (i.e. governments, businesses, knowledge and
                            affinity-centric workers, consumers), understand their buying behaviour, and have validated our
                            understanding.</td>
                        <td style="background: white">
                            <select name="Q7" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('Q7', $questionnaireData['Q7'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>We know our customers' and users' specific needs, understand how our product or service can
                            address them, and have validated our understanding with sales to mainstream customers.</td>
                        <td style="background: white">
                            <select name="Q8" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('Q8', $questionnaireData['Q8'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>We have accurately estimated the size of the serviceable market in terms of the maximum number
                            of potential customers and users, and total sales revenue per customer in our chosen market
                            space(s).</td>
                        <td style="background: white">
                            <select name="Q9" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('Q9', $questionnaireData['Q9'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <!-- E4. Distribution, Marketing and Sales -->
                    <tr>
                        <td rowspan="3">E4. Distribution, Marketing and Sales</td>
                        <td>We are aware of and have implemented a strategy to address our market entry challenges including
                            product management, pricing, marketing & sales, channels and post-sales support.</td>
                        <td style="background: white">
                            <select name="Q10" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('Q10', $questionnaireData['Q10'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>We know what our main channels to market are (direct, franchisees, agents, distributors,
                            outlets, strategic partners) in our target market(s) and have developed and implemented
                            commercial agreements with our channel partners.</td>
                        <td style="background: white">
                            <select name="Q11" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('Q11', $questionnaireData['Q11'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>We have developed, validated and implemented sales processes that allows us to sell our product
                            or service to our target customers directly and / or through our channel partners.</td>
                        <td style="background: white">
                            <select name="Q12" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('Q12', $questionnaireData['Q12'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <!-- I1. Tech. Development and Contingent Deployment -->
                    <tr>
                        <td rowspan="3">I1. Tech. Development and Contingent Deployment</td>
                        <td>We are clear about the importance of technology in our offering, ranging from it being INTEGRAL
                            to our product or service, to our offering being ENABLED by it, to technology being IRRELEVANT
                            to our offering.</td>
                        <td style="background: white">
                            <select name="I1_1" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('I1_1', $questionnaireData['I1_1'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>We have characterised our technology stack (from base tech to application tech, to platforms,
                            apps & tools, products, and services), selected the relevant components for our proposition, and
                            understand the implications of our choices. </td>
                        <td style="background: white">
                            <select name="I1_2" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('I1_2', $questionnaireData['I1_2'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>We have a clear technology deployment strategy for the development of our offering including the
                            role of partners, suppliers and other service providers.</td>
                        <td style="background: white">
                            <select name="I1_3" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('I1_3', $questionnaireData['I1_3'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <!-- I2. IP Management -->
                    <tr>
                        <td rowspan="3">I2. IP Management</td>
                        <td>We are aware of all forms of IP including registered rights, unregistered rights, and open
                            rights, and understand how to protect them appropriately in our target market(s).</td>
                        <td style="background: white">
                            <select name="I2_1" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('I2_1', $questionnaireData['I2_1'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>We have a clear, comprehensive and validated IP strategy that supports the commercialisation of
                            our product or service with all relevant considerations including protection, assignment,
                            licencing and freedom to operate.</td>
                        <td style="background: white">
                            <select name="I2_2" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('I2_2', $questionnaireData['I2_2'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>We have strong and defensible IP that underpins the commercialisation of our product or service
                            by supporting all relevant activities including fundraising.</td>
                        <td style="background: white">
                            <select name="I2_3" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('I2_3', $questionnaireData['I2_3'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <!-- I3. Product & Service Definition and Synthesis -->
                    <tr>
                        <td rowspan="3">I3. Product & Service Definition and Synthesis</td>
                        <td>We understand whether our product or service design is driven by customer pull, technology push
                            or a mix of both.</td>
                        <td style="background: white">
                            <select name="I3_1" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('I3_1', $questionnaireData['I3_1'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>We understand the sustainability impact of all the components which make up our product or
                            service and have put a strategy in place to maximise the sustainability of our product or
                            service.</td>
                        <td style="background: white">
                            <select name="I3_2" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('I3_2', $questionnaireData['I3_2'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>We have a strong product management focus; understanding all the key components that make up our
                            final product or service, and how they satisfy customer and user needs.</td>
                        <td style="background: white">
                            <select name="I3_3" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('I3_3', $questionnaireData['I3_3'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <!-- I4. Manufacturing & deployment -->
                    <tr>
                        <td rowspan="3">I4. Manufacturing & deployment</td>
                        <td>We are aware of and have implemented a strategy to address our manufacturing and deployment
                            needs including components, supply chain, processes, and integrated operations.</td>
                        <td style="background: white">
                            <select name="I4_1" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('I4_1', $questionnaireData['I4_1'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>The delivery of our product or service can be achieved using existing manufacturing and
                            deployment approaches.</td>
                        <td style="background: white">
                            <select name="I4_2" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('I4_2', $questionnaireData['I4_2'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>We have proven our manufacturing and deployment approach at commercial volumes and are clear
                            about the associated economics and sustainability.</td>
                        <td style="background: white">
                            <select name="I4_3" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('I4_3', $questionnaireData['I4_3'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <!-- I5. Talent, Leadership and Culture -->
                    <tr>
                        <td rowspan="3">I5. Talent, Leadership and Culture</td>
                        <td>We have effective access to all the skills required to deliver our commercialisation plans
                            through our team and key partners / suppliers.</td>
                        <td style="background: white">
                            <select name="I5_1" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('I5_1', $questionnaireData['I5_1'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>We have a clear team / organisational structure and processes, including inspiring descriptions
                            of all team members' roles, mapped against key business processes.</td>
                        <td style="background: white">
                            <select name="I5_2" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('I5_2', $questionnaireData['I5_2'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Our leadership style and culture are aligned with our stated intentions and actual behaviours,
                            and they support the delivery of our commercialisation plans.</td>
                        <td style="background: white">
                            <select name="I5_3" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('I5_3', $questionnaireData['I5_3'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <!-- I6. Funding and Investment -->
                    <tr>
                        <td rowspan="3">I6. Funding and Investment</td>
                        <td>We understand the various sources of funding (e.g. own / family resources, grants, debt, angel /
                            VC / CVC / PE investors and customers) available for our commercialisation plans, what motivates
                            them, and how to access them.</td>
                        <td style="background: white">
                            <select name="I6_1" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('I6_1', $questionnaireData['I6_1'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>We have a clear, realistic and validated funding strategy in place to support our
                            commercialisation plans.</td>
                        <td style="background: white">
                            <select name="I6_2" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('I6_2', $questionnaireData['I6_2'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>We have a clear understanding of our valuation and how we are perceived by our key stakeholders
                            including investors.</td>
                        <td style="background: white">
                            <select name="I6_3" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('I6_3', $questionnaireData['I6_3'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <!-- C1. Strategic Positioning -->
                    <tr>
                        <td rowspan="3">C1. Strategic Positioning</td>
                        <td>We understand conventional generic sources of competitive advantage including low cost,
                            technology-based advantage, differentiated product or service, first-mover advantage and
                            time-based advantage.</td>
                        <td style="background: white">
                            <select name="C1_1" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('C1_1', $questionnaireData['C1_1'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>We understand the Triple Chasm approach to dynamic competitive advantage including
                            differentiation based on the meso-economic vectors.</td>
                        <td style="background: white">
                            <select name="C1_2" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('C1_2', $questionnaireData['C1_2'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>We have a well-considered and validated strategic position for our product or service in our
                            target market space(s) including clear priorities that drive our execution effort.</td>
                        <td style="background: white">
                            <select name="C1_3" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('C1_3', $questionnaireData['C1_3'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <!-- C2. Business Models -->
                    <tr>
                        <td rowspan="3">C2. Business Models</td>
                        <td>We are aware of business models relevant to our product or service, and their underlying logic
                            of value creation activities.</td>
                        <td style="background: white">
                            <select name="C2_1" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('C2_1', $questionnaireData['C2_1'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>We have developed a comprehensive business model covering all drivers of revenue, costs and
                            profit, and have validated it with mainstream customers, suppliers and partners. </td>
                        <td style="background: white">
                            <select name="C2_2" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('C2_2', $questionnaireData['C2_2'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>We are tracking and improving our execution performance using relevant metrics derived from our
                            business model.</td>
                        <td style="background: white">
                            <select name="C2_3" class="form-control">
                                <option value="">Select...</option>
                                @foreach ($scoreMap as $label => $score)
                                    <option value="{{ $label }}"
                                        {{ old('C2_3', $questionnaireData['C2_3'] ?? null) == $score ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div style="text-align:center; margin: 20px 0;">
                <button type="submit" class="btn btn-primary">Save Questionnaire</button>
            </div>
        </form>
    </div>
@endsection
