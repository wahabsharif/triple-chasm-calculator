@extends('layouts.main')

@section('content')
    <form class="assessment-form">
        <div class="form-row">
            <label>Assessment Type:</label>
            <select>
                <option value="">Select assessment type</option>
                <option value="Diagnosis">Diagnosis</option>
                <option value="Target">Target</option>
            </select>
        </div>
        <div class="form-row">
            <label>Assessment Date:</label>
            <input type="text" value="3/13/2025" />
        </div>
        <div class="form-row">
            <label>Target Date (if applicable):</label>
            <input type="text" />
        </div>
        <div class="form-row">
            <label>First Name:</label>
            <input type="text" value="A" />
        </div>
        <div class="form-row">
            <label>Last Name:</label>
            <input type="text" value="Founder" />
        </div>
        <div class="form-row">
            <label>Venture Name:</label>
            <input type="text" value="Demo Venture" />
        </div>
        <div class="form-row">
            <label>Venture Motivation:</label>
            <select>
                <option value="">Select the option that best describes your motivation
                </option>
                <option value="Traditional commercial business">Traditional commercial business</option>
                <option value="Mission-driven business">Mission-driven business</option>
                <option value="Social business">Social business</option>
                <option value="Self-sustaining business">Self-sustaining business</option>
                <option value="Philanthropic business">Philanthropic business</option>
            </select>
        </div>
        <div class="form-row">
            <label>Venture Sustainability Attitude:</label>
            <select>
                <option value="">Select the option that best describes your attitude to sustainability</option>
                <option value="Sustainability does not concern us">Sustainability does not concern us</option>
                <option value="We are interested in sustainability but need to take practical steps to address it">We are
                    interested in sustainability but need to take practical steps to address it</option>
                <option value="We are interested in sustainability and have taken practical steps to address it">We are
                    interested in sustainability and have taken practical steps to address it</option>
                <option value="Sustainability is of primary importance to us but we need to improve implementation">
                    Sustainability is of primary importance to us but we need to improve implementation</option>
                <option
                    value="Sustainability is of primary importance to us and we have a track record of successful implementation">
                    Sustainability is of primary importance to us and we have a track record of successful implementation
                </option>
            </select>
        </div>
        <div class="form-row">
            <label>Product Name:</label>
            <input type="text" value="Demo Product" />
        </div>
        <div class="form-row">
            <label>Product Maturity:</label>
            <select>
                <option value="">Select product Maturity</option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
            </select>
        </div>
        <div class="form-row">
            <label>Primary Sector / Market Space:</label>
            <select>
                <option value="">Select primary (sub)market category</option>
                <option value="Agri-food">Agri-food</option>
                <option value="Agri-food / Pesticides, Herbicides & Fertilizers">Agri-food / Pesticides, Herbicides &
                    Fertilizers</option>
                <option value="Agri-food / Research, Analytics & Testing">Agri-food / Research, Analytics & Testing</option>
                <option value="Agri-food / Monitoring, Safety & Compliance">Agri-food / Monitoring, Safety & Compliance
                </option>
                <option value="Agri-food / Packaging & Processing">Agri-food / Packaging & Processing</option>
                <option value="Agri-food / Precision Farming">Agri-food / Precision Farming</option>
                <option value="Agri-food / Plant-based products">Agri-food / Plant-based products</option>
                <option value="Agri-food / Dairy Products">Agri-food / Dairy Products</option>
                <option value="Agri-food / Non-conventional Food Sources">Agri-food / Non-conventional Food Sources</option>
                <option value="Agri-food / Animal-based Products">Agri-food / Animal-based Products</option>
                <option value="Agri-food / Drinks">Agri-food / Drinks</option>
                <option value="Agri-food / Waste Management">Agri-food / Waste Management</option>
                <option value="Agri-food / Food Marketplaces">Agri-food / Food Marketplaces</option>
                <option value="Agri-food / Food Distribution Networks">Agri-food / Food Distribution Networks</option>
                <option value="Agri-food / Social Applications & Networks">Agri-food / Social Applications & Networks
                </option>
                <option value="Bio-tech">Bio-tech</option>
                <option value="Bio-tech / White (Industrial) Biotech Products & Services">Bio-tech / White (Industrial)
                    Biotech Products & Services</option>
                <option value="Bio-tech / Red (Bio-Pharma) Biotech Products & Services">Bio-tech / Red (Bio-Pharma) Biotech
                    Products & Services</option>
                <option value="Bio-tech / Green (Plant) Biotech Products & Services">Bio-tech / Green (Plant) Biotech
                    Products & Services</option>
                <option value="Bio-tech / Blue (Marine) Biotech Products & Services">Bio-tech / Blue (Marine) Biotech
                    Products & Services</option>
                <option value="Bio-tech / Research and Development Tools & Platforms">Bio-tech / Research and Development
                    Tools & Platforms</option>
                <option value="Bio-tech / Analytics & Testing Platforms & Services">Bio-tech / Analytics & Testing Platforms
                    & Services</option>
                <option value="Bio-tech / Scaling Tools & Platforms">Bio-tech / Scaling Tools & Platforms</option>
                <option value="Community & Social Provision">Community & Social Provision</option>
                <option value="Community & Social Provision / Housing">Community & Social Provision / Housing</option>
                <option value="Community & Social Provision / Civic Services">Community & Social Provision / Civic Services
                </option>
                <option value="Community & Social Provision / Land & Rates Management">Community & Social Provision / Land &
                    Rates Management</option>
                <option value="Community & Social Provision / Community Services">Community & Social Provision / Community
                    Services</option>
                <option value="Distribution, Logistics & Retail">Distribution, Logistics & Retail</option>
                <option value="Distribution, Logistics & Retail / Warehousing">Distribution, Logistics & Retail /
                    Warehousing</option>
                <option value="Distribution, Logistics & Retail / Distribution Management">Distribution, Logistics & Retail
                    / Distribution Management</option>
                <option value="Distribution, Logistics & Retail / Logistics">Distribution, Logistics & Retail / Logistics
                </option>
                <option value="Distribution, Logistics & Retail / e-commerce">Distribution, Logistics & Retail / e-commerce
                </option>
                <option value="Distribution, Logistics & Retail / Retail stores">Distribution, Logistics & Retail / Retail
                    stores</option>
                <option value="Education & Training">Education & Training</option>
                <option value="Education & Training / Primary Education">Education & Training / Primary Education</option>
                <option value="Education & Training / Secondary Education">Education & Training / Secondary Education
                </option>
                <option value="Education & Training / Tertiary Education">Education & Training / Tertiary Education</option>
                <option value="Education & Training / Life-long Learning">Education & Training / Life-long Learning</option>
                <option value="Education & Training / e-learning">Education & Training / e-learning</option>
                <option value="Electronics & Hardware">Electronics & Hardware</option>
                <option value="Electronics & Hardware / Semi-conductors">Electronics & Hardware / Semi-conductors</option>
                <option value="Electronics & Hardware / Processing Platforms">Electronics & Hardware / Processing Platforms
                </option>
                <option value="Electronics & Hardware / Integrated Products">Electronics & Hardware / Integrated Products
                </option>
                <option value="Electronics & Hardware / Network and Network Management">Electronics & Hardware / Network and
                    Network Management</option>
                <option value="Engineering">Engineering</option>
                <option value="Engineering / Aerospace">Engineering / Aerospace</option>
                <option value="Engineering / Automotive">Engineering / Automotive</option>
                <option value="Engineering / Construction">Engineering / Construction</option>
                <option value="Engineering / Oil & Gas">Engineering / Oil & Gas</option>
                <option value="Engineering / Materials">Engineering / Materials</option>
                <option value="Engineering / Marine">Engineering / Marine</option>
                <option value="Engineering / Mining">Engineering / Mining</option>
                <option value="Fashion & Clothing">Fashion & Clothing</option>
                <option value="Fashion & Clothing / Industrial Clothing">Fashion & Clothing / Industrial Clothing</option>
                <option value="Fashion & Clothing / Fashion Clothing">Fashion & Clothing / Fashion Clothing</option>
                <option value="Fashion & Clothing / Footwear">Fashion & Clothing / Footwear</option>
                <option value="Fashion & Clothing / Safety Apparel">Fashion & Clothing / Safety Apparel</option>
                <option value="Financial Services">Financial Services</option>
                <option value="Financial Services / Insurance Services">Financial Services / Insurance Services</option>
                <option value="Financial Services / e-payment systems">Financial Services / e-payment systems</option>
                <option value="Financial Services / Retail Banking">Financial Services / Retail Banking</option>
                <option value="Financial Services / Corporate Banking & Finance">Financial Services / Corporate Banking &
                    Finance</option>
                <option value="Financial Services / Share Trading & Exchanges">Financial Services / Share Trading &
                    Exchanges</option>
                <option value="Financial Services / General Financial Management">Financial Services / General Financial
                    Management</option>
                <option value="Healthcare & Wellbeing">Healthcare & Wellbeing</option>
                <option value="Healthcare & Wellbeing / Gene-level insights & Interventions">Healthcare & Wellbeing /
                    Gene-level insights & Interventions</option>
                <option value="Healthcare & Wellbeing / Cell-level insights & interventions">Healthcare & Wellbeing /
                    Cell-level insights & interventions</option>
                <option value="Healthcare & Wellbeing / Organ-level insights & interventions">Healthcare & Wellbeing /
                    Organ-level insights & interventions</option>
                <option value="Healthcare & Wellbeing / Metrology">Healthcare & Wellbeing / Metrology</option>
                <option value="Healthcare & Wellbeing / Diagnostics">Healthcare & Wellbeing / Diagnostics</option>
                <option value="Healthcare & Wellbeing / Therapeutics">Healthcare & Wellbeing / Therapeutics</option>
                <option value="Healthcare & Wellbeing / Clinical Testing/Regulatory Services">Healthcare & Wellbeing /
                    Clinical Testing/Regulatory Services</option>
                <option value="Healthcare & Wellbeing / Primary Healthcare">Healthcare & Wellbeing / Primary Healthcare
                </option>
                <option value="Healthcare & Wellbeing / Secondary Healthcare">Healthcare & Wellbeing / Secondary Healthcare
                </option>
                <option value="Healthcare & Wellbeing / Tertiary Healthcare">Healthcare & Wellbeing / Tertiary Healthcare
                </option>
                <option value="Healthcare & Wellbeing / Electronic Health Management Services">Healthcare & Wellbeing /
                    Electronic Health Management Services</option>
                <option value="Healthcare & Wellbeing / Care-in-the Community">Healthcare & Wellbeing / Care-in-the
                    Community</option>
                <option value="Media & Entertainment">Media & Entertainment</option>
                <option value="Media & Entertainment / Content-centric products and services: video">Media & Entertainment
                    / Content-centric products and services: video</option>
                <option value="Media & Entertainment / Content-centric products and services: music">Media & Entertainment
                    / Content-centric products and services: music</option>
                <option value="Media & Entertainment / Image-based services">Media & Entertainment / Image-based services
                </option>
                <option value="Media & Entertainment / Print Media">Media & Entertainment / Print Media</option>
                <option value="Media & Entertainment / Gaming">Media & Entertainment / Gaming</option>
                <option value="Professional Services">Professional Services</option>
                <option value="Professional Services / General Legal">Professional Services / General Legal</option>
                <option value="Professional Services / IP Management">Professional Services / IP Management</option>
                <option value="Professional Services / Disputes & Litigation">Professional Services / Disputes & Litigation
                </option>
                <option value="Professional Services / Recruitment">Professional Services / Recruitment</option>
                <option value="Professional Services / Management & Specialist Consulting">Professional Services /
                    Management & Specialist Consulting</option>
                <option value="Professional Services / Lab Equipment & Services">Professional Services / Lab Equipment &
                    Services</option>
                <option value="Professional Services / Logistics & Planning">Professional Services / Logistics & Planning
                </option>
                <option value="Professional Services / Computation-based Design Services">Professional Services /
                    Computation-based Design Services</option>
                <option value="Professional Services / Regulatory & Information Services">Professional Services /
                    Regulatory & Information Services</option>
                <option value="Professional Services / Research Services">Professional Services / Research Services
                </option>
                <option value="Resources & Energy">Resources & Energy</option>
                <option value="Resources & Energy / Minerals">Resources & Energy / Minerals</option>
                <option value="Resources & Energy / Forestry">Resources & Energy / Forestry</option>
                <option value="Resources & Energy / Oil & Gas">Resources & Energy / Oil & Gas</option>
                <option value="Resources & Energy / Coal">Resources & Energy / Coal</option>
                <option value="Resources & Energy / Nuclear">Resources & Energy / Nuclear</option>
                <option value="Resources & Energy / Renewable Energy">Resources & Energy / Renewable Energy</option>
                <option value="Resources & Energy / Energy Storage">Resources & Energy / Energy Storage</option>
                <option value="Resources & Energy / Smart Energy Management">Resources & Energy / Smart Energy Management
                </option>
                <option value="Resources & Energy / Smart Lighting">Resources & Energy / Smart Lighting</option>
                <option value="Software & Computing">Software & Computing</option>
                <option value="Software & Computing / Database Technologies">Software & Computing / Database Technologies
                </option>
                <option value="Software & Computing / Cloud Computing">Software & Computing / Cloud Computing</option>
                <option value="Software & Computing / Software Languages">Software & Computing / Software Languages
                </option>
                <option value="Software & Computing / Algorithms">Software & Computing / Algorithms</option>
                <option value="Telecommunications">Telecommunications</option>
                <option value="Telecommunications / Fixed Networks">Telecommunications / Fixed Networks</option>
                <option value="Telecommunications / Mobile Networks">Telecommunications / Mobile Networks</option>
                <option value="Telecommunications / Hybrid Networks">Telecommunications / Hybrid Networks</option>
                <option value="Telecommunications / Network Management">Telecommunications / Network Management</option>
                <option value="Travel, Transportation & Hospitality">Travel, Transportation & Hospitality</option>
                <option value="Travel, Transportation & Hospitality / Road">Travel, Transportation & Hospitality / Road
                </option>
                <option value="Travel, Transportation & Hospitality / Rail">Travel, Transportation & Hospitality / Rail
                </option>
                <option value="Travel, Transportation & Hospitality / Aviation">Travel, Transportation & Hospitality /
                    Aviation</option>
                <option value="Travel, Transportation & Hospitality / Marine">Travel, Transportation & Hospitality / Marine
                </option>
                <option value="Travel, Transportation & Hospitality / Navigation Systems">Travel, Transportation &
                    Hospitality / Navigation Systems</option>
                <option value="Travel, Transportation & Hospitality / Infrastructures">Travel, Transportation & Hospitality
                    / Infrastructures</option>
                <option value="Travel, Transportation & Hospitality / Accommodation">Travel, Transportation & Hospitality /
                    Accommodation</option>
                <option value="Other (Sub)Market Space">Other (Sub)Market Space</option>
                <option value="Multiple (Sub)Market Spaces">Multiple (Sub)Market Spaces</option>
            </select>
        </div>
        <div class="form-row">
            <label>'Other' Sector / Market Space:</label>
            <input type="text" />
        </div>
        <div class="form-row">
            <label>Full-time equivalent (FTE) employees:</label>
            <input type="text" value="3.0" />
        </div>
        <div class="form-row">
            <label>Valuation:</label>
            <input type="text" value="£1,000,000.00" />
        </div>
        <div class="form-row">
            <label>Grants awarded to date:</label>
            <input type="text" value="£150,000.00" />
        </div>
        <div class="form-row">
            <label>Equity investment raised to date:</label>
            <input type="text" value="£0.00" />
        </div>
        <div class="form-row">
            <label>Sales revenue generated to date:</label>
            <input type="text" value="£0.00" />
        </div>
        <div class="form-row">
            <label>Estimated net profit to date:</label>
            <input type="text" value="£0.00" />
        </div>
    </form>
@endsection
