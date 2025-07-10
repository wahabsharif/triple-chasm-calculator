@extends('layouts.main')

@section('content')
    <form class="assessment-form" method="POST" action="{{ route('profile.store') }}">
        @csrf
        <div class="form-row">
            <label>Assessment Type:</label>
            <select name="assessment_type" required>
                <option value="">Select assessment type</option>
                <option value="Diagnosis"
                    {{ old('assessment_type', $profileData['assessment_type'] ?? '') == 'Diagnosis' ? 'selected' : '' }}>
                    Diagnosis</option>
                <option value="Target"
                    {{ old('assessment_type', $profileData['assessment_type'] ?? '') == 'Target' ? 'selected' : '' }}>
                    Target</option>
            </select>
        </div>
        <div class="form-row">
            <label>Assessment Date:</label>
            <input type="date" name="assessment_date"
                value="{{ old('assessment_date', $profileData['assessment_date'] ?? '2025-03-13') }}" required />
        </div>
        <div class="form-row">
            <label>Target Date (if applicable):</label>
            <input type="date" name="target_date" value="{{ old('target_date', $profileData['target_date'] ?? '') }}" />
        </div>
        <div class="form-row">
            <label>First Name:</label>
            <input type="text" name="first_name" value="{{ old('first_name', $profileData['first_name'] ?? 'A') }}"
                required />
        </div>
        <div class="form-row">
            <label>Last Name:</label>
            <input type="text" name="last_name" value="{{ old('last_name', $profileData['last_name'] ?? 'Founder') }}"
                required />
        </div>
        <div class="form-row">
            <label>Venture Name:</label>
            <input type="text" name="venture_name"
                value="{{ old('venture_name', $profileData['venture_name'] ?? 'Demo Venture') }}" required />
        </div>
        <div class="form-row">
            <label>Venture Motivation:</label>
            <select name="venture_motivation" required>
                <option value="">Select the option that best describes your motivation</option>
                <option value="Traditional commercial business"
                    {{ old('venture_motivation', $profileData['venture_motivation'] ?? '') == 'Traditional commercial business' ? 'selected' : '' }}>
                    Traditional commercial business</option>
                <option value="Mission-driven business"
                    {{ old('venture_motivation', $profileData['venture_motivation'] ?? '') == 'Mission-driven business' ? 'selected' : '' }}>
                    Mission-driven business</option>
                <option value="Social business"
                    {{ old('venture_motivation', $profileData['venture_motivation'] ?? '') == 'Social business' ? 'selected' : '' }}>
                    Social business</option>
                <option value="Self-sustaining business"
                    {{ old('venture_motivation', $profileData['venture_motivation'] ?? '') == 'Self-sustaining business' ? 'selected' : '' }}>
                    Self-sustaining business</option>
                <option value="Philanthropic business"
                    {{ old('venture_motivation', $profileData['venture_motivation'] ?? '') == 'Philanthropic business' ? 'selected' : '' }}>
                    Philanthropic business</option>
            </select>
        </div>
        <div class="form-row">
            <label>Venture Sustainability Attitude:</label>
            <select name="venture_sustainability_attitude" required>
                <option value="">Select the option that best describes your attitude to sustainability</option>
                <option value="Sustainability does not concern us"
                    {{ old('venture_sustainability_attitude', $profileData['venture_sustainability_attitude'] ?? '') == 'Sustainability does not concern us' ? 'selected' : '' }}>
                    Sustainability does not concern us</option>
                <option value="We are interested in sustainability but need to take practical steps to address it"
                    {{ old('venture_sustainability_attitude', $profileData['venture_sustainability_attitude'] ?? '') == 'We are interested in sustainability but need to take practical steps to address it' ? 'selected' : '' }}>
                    We are interested in sustainability but need to take practical steps to address it</option>
                <option value="We are interested in sustainability and have taken practical steps to address it"
                    {{ old('venture_sustainability_attitude', $profileData['venture_sustainability_attitude'] ?? '') == 'We are interested in sustainability and have taken practical steps to address it' ? 'selected' : '' }}>
                    We are interested in sustainability and have taken practical steps to address it</option>
                <option value="Sustainability is of primary importance to us but we need to improve implementation"
                    {{ old('venture_sustainability_attitude', $profileData['venture_sustainability_attitude'] ?? '') == 'Sustainability is of primary importance to us but we need to improve implementation' ? 'selected' : '' }}>
                    Sustainability is of primary importance to us but we need to improve implementation</option>
                <option
                    value="Sustainability is of primary importance to us and we have a track record of successful implementation"
                    {{ old('venture_sustainability_attitude', $profileData['venture_sustainability_attitude'] ?? '') == 'Sustainability is of primary importance to us and we have a track record of successful implementation' ? 'selected' : '' }}>
                    Sustainability is of primary importance to us and we have a track record of successful implementation
                </option>
            </select>
        </div>
        <div class="form-row">
            <label>Product Name:</label>
            <input type="text" name="product_name"
                value="{{ old('product_name', $profileData['product_name'] ?? 'Demo Product') }}" required />
        </div>
        <div class="form-row">
            <label>Product Maturity:</label>
            <select name="product_maturity" required>
                <option value="">Select product Maturity</option>
                @for ($i = 0; $i <= 10; $i++)
                    <option value="{{ $i }}"
                        {{ old('product_maturity', $profileData['product_maturity'] ?? '') == $i ? 'selected' : '' }}>
                        {{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="form-row">
            <label>Primary Sector / Market Space:</label>
            <select name="primary_sector" required>
                <option value="">Select primary (sub)market category</option>
                @php $primary_sector_val = old('primary_sector', $profileData['primary_sector'] ?? ''); @endphp
                @foreach ([
            'Agri-food',
            'Agri-food / Pesticides, Herbicides & Fertilizers',
            'Agri-food / Research, Analytics & Testing',
            'Agri-food / Monitoring, Safety & Compliance',
            'Agri-food / Packaging & Processing',
            'Agri-food / Precision Farming',
            'Agri-food / Plant-based products',
            'Agri-food / Dairy Products',
            'Agri-food / Non-conventional Food Sources',
            'Agri-food / Animal-based Products',
            'Agri-food / Drinks',
            'Agri-food / Waste Management',
            'Agri-food / Food Marketplaces',
            'Agri-food / Food Distribution Networks',
            'Agri-food / Social Applications & Networks',
            'Bio-tech',
            'Bio-tech / White (Industrial) Biotech Products & Services',
            'Bio-tech / Red (Bio-Pharma) Biotech Products & Services',
            'Bio-tech / Green (Plant) Biotech Products & Services',
            'Bio-tech / Blue (Marine) Biotech Products & Services',
            'Bio-tech / Research and Development Tools & Platforms',
            'Bio-tech / Analytics & Testing Platforms & Services',
            'Bio-tech / Scaling Tools & Platforms',
            'Community & Social Provision',
            'Community & Social Provision / Housing',
            'Community & Social Provision / Civic Services',
            'Community & Social Provision / Land & Rates Management',
            'Community & Social Provision / Community Services',
            'Distribution, Logistics & Retail',
            'Distribution, Logistics & Retail / Warehousing',
            'Distribution, Logistics & Retail / Distribution Management',
            'Distribution, Logistics & Retail / Logistics',
            'Distribution, Logistics & Retail / e-commerce',
            'Distribution, Logistics & Retail / Retail stores',
            'Education & Training',
            'Education & Training / Primary Education',
            'Education & Training / Secondary Education',
            'Education & Training / Tertiary Education',
            'Education & Training / Life-long Learning',
            'Education & Training / e-learning',
            'Electronics & Hardware',
            'Electronics & Hardware / Semi-conductors',
            'Electronics & Hardware / Processing Platforms',
            'Electronics & Hardware / Integrated Products',
            'Electronics & Hardware / Network and Network Management',
            'Engineering',
            'Engineering / Aerospace',
            'Engineering / Automotive',
            'Engineering / Construction',
            'Engineering / Oil & Gas',
            'Engineering / Materials',
            'Engineering / Marine',
            'Engineering / Mining',
            'Fashion & Clothing',
            'Fashion & Clothing / Industrial Clothing',
            'Fashion & Clothing / Fashion Clothing',
            'Fashion & Clothing / Footwear',
            'Fashion & Clothing / Safety Apparel',
            'Financial Services',
            'Financial Services / Insurance Services',
            'Financial Services / e-payment systems',
            'Financial Services / Retail Banking',
            'Financial Services / Corporate Banking & Finance',
            'Financial Services / Share Trading & Exchanges',
            'Financial Services / General Financial Management',
            'Healthcare & Wellbeing',
            'Healthcare & Wellbeing / Gene-level insights & Interventions',
            'Healthcare & Wellbeing / Cell-level insights & interventions',
            'Healthcare & Wellbeing / Organ-level insights & interventions',
            'Healthcare & Wellbeing / Metrology',
            'Healthcare & Wellbeing / Diagnostics',
            'Healthcare & Wellbeing / Therapeutics',
            'Healthcare & Wellbeing / Clinical Testing/Regulatory Services',
            'Healthcare & Wellbeing / Primary Healthcare',
            'Healthcare & Wellbeing / Secondary Healthcare',
            'Healthcare & Wellbeing / Tertiary Healthcare',
            'Healthcare & Wellbeing / Electronic Health Management Services',
            'Healthcare & Wellbeing / Care-in-the Community',
            'Media & Entertainment',
            'Media & Entertainment / Content-centric products and services: video',
            'Media & Entertainment / Content-centric products and services: music',
            'Media & Entertainment / Image-based services',
            'Media & Entertainment / Print Media',
            'Media & Entertainment / Gaming',
            'Professional Services',
            'Professional Services / General Legal',
            'Professional Services / IP Management',
            'Professional Services / Disputes & Litigation',
            'Professional Services / Recruitment',
            'Professional Services / Management & Specialist Consulting',
            'Professional Services / Lab Equipment & Services',
            'Professional Services / Logistics & Planning',
            'Professional Services / Computation-based Design Services',
            'Professional Services / Regulatory & Information Services',
            'Professional Services / Research Services',
            'Resources & Energy',
            'Resources & Energy / Minerals',
            'Resources & Energy / Forestry',
            'Resources & Energy / Oil & Gas',
            'Resources & Energy / Coal',
            'Resources & Energy / Nuclear',
            'Resources & Energy / Renewable Energy',
            'Resources & Energy / Energy Storage',
            'Resources & Energy / Smart Energy Management',
            'Resources & Energy / Smart Lighting',
            'Software & Computing',
            'Software & Computing / Database Technologies',
            'Software & Computing / Cloud Computing',
            'Software & Computing / Software Languages',
            'Software & Computing / Algorithms',
            'Telecommunications',
            'Telecommunications / Fixed Networks',
            'Telecommunications / Mobile Networks',
            'Telecommunications / Hybrid Networks',
            'Telecommunications / Network Management',
            'Travel, Transportation & Hospitality',
            'Travel, Transportation & Hospitality / Road',
            'Travel, Transportation & Hospitality / Rail',
            'Travel, Transportation & Hospitality / Aviation',
            'Travel, Transportation & Hospitality / Marine',
            'Travel, Transportation & Hospitality / Navigation Systems',
            'Travel, Transportation & Hospitality / Infrastructures',
            'Travel, Transportation & Hospitality / Accommodation',
            'Other (Sub)Market Space',
            'Multiple (Sub)Market Spaces',
        ] as $sector)
                    <option value="{{ $sector }}" {{ $primary_sector_val == $sector ? 'selected' : '' }}>
                        {{ $sector }}</option>
                @endforeach
            </select>

            </select>
        </div>
        <div class="form-row">
            <label>'Other' Sector / Market Space:</label>
            <input type="text" name="other_sector"
                value="{{ old('other_sector', $profileData['other_sector'] ?? '') }}" />
        </div>
        <div class="form-row">
            <label>Full-time equivalent (FTE) employees:</label>
            <input type="number" step="0.1" name="fte_employees"
                value="{{ old('fte_employees', $profileData['fte_employees'] ?? '3.0') }}" required />
        </div>
        <div class="form-row">
            <label>Valuation:</label>
            <input type="text" name="valuation"
                value="{{ old('valuation', $profileData['valuation'] ?? '£1,000,000.00') }}" required />
        </div>
        <div class="form-row">
            <label>Grants awarded to date:</label>
            <input type="text" name="grants_awarded"
                value="{{ old('grants_awarded', $profileData['grants_awarded'] ?? '£150,000.00') }}" required />
        </div>
        <div class="form-row">
            <label>Equity investment raised to date:</label>
            <input type="text" name="equity_investment"
                value="{{ old('equity_investment', $profileData['equity_investment'] ?? '£0.00') }}" required />
        </div>
        <div class="form-row">
            <label>Sales revenue generated to date:</label>
            <input type="text" name="sales_revenue"
                value="{{ old('sales_revenue', $profileData['sales_revenue'] ?? '£0.00') }}" required />
        </div>
        <div class="form-row">
            <label>Estimated net profit to date:</label>
            <input type="text" name="estimated_net_profit"
                value="{{ old('estimated_net_profit', $profileData['estimated_net_profit'] ?? '£0.00') }}" required />
        </div>
    </form>

    <script>
        const form = document.querySelector('.assessment-form');
        let autosaveTimeout;

        // Show validation errors
        function showValidationErrors(errors) {
            // Remove old error borders
            form.querySelectorAll('.autosave-error').forEach(input => {
                input.classList.remove('autosave-error');
                input.style.borderColor = '';
            });
            for (const [field, messages] of Object.entries(errors)) {
                const input = form.querySelector(`[name="${field}"]`);
                if (input) {
                    input.classList.add('autosave-error');
                    input.style.borderColor = 'red';
                }
            }
        }

        function autosaveProfile() {
            clearTimeout(autosaveTimeout);
            autosaveTimeout = setTimeout(() => {
                // Remove old error borders
                form.querySelectorAll('.autosave-error').forEach(input => {
                    input.classList.remove('autosave-error');
                    input.style.borderColor = '';
                });
                const formData = new FormData(form);
                fetch("{{ route('profile.store') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                    .then(async response => {
                        if (response.status === 422) {
                            const data = await response.json();
                            if (data.errors) {
                                showValidationErrors(data.errors);
                            }
                        }
                    })
                    .catch(() => {
                        // Silent fail
                    });
            }, 800);
        }

        // Only autosave on change (not input) to avoid partial data
        form.querySelectorAll('input, select, textarea').forEach(input => {
            input.addEventListener('change', autosaveProfile);
        });
    </script>
@endsection
