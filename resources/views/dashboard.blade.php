@extends('layouts.main')

@section('content')
    <div class="dashboard-container">

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (!empty($profileData))
            <div class="profile-and-vector-col">
                <div class="profile-summary">
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Name:</span>
                            <span class="info-value">{{ $profileData['first_name'] }} {{ $profileData['last_name'] }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Venture:</span>
                            <span class="info-value">{{ $profileData['venture_name'] }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Product:</span>
                            <span class="info-value">{{ $profileData['product_name'] }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Maturity:</span>
                            <span class="info-value">{{ $profileData['product_maturity'] }}
                                ({{ $profileData['assessment_type'] }})</span>
                        </div>
                    </div>
                </div>
                <div class="vector-status-container">
                    <div class="vector-status-title">Vector Status</div>
                    <table class="vector-status-table">
                        @if (isset($vectorResults) && is_array($vectorResults))
                            @foreach ($vectorResults as $vector)
                                @php
                                    $statusClass = '';
                                    if (trim($vector['status']) === '') {
                                        $statusClass = '';
                                    } elseif ($vector['status'] === 'Looks good') {
                                        $statusClass = 'looks-good';
                                    } elseif ($vector['status'] === 'Needs attention') {
                                        $statusClass = 'needs-attention';
                                    } elseif ($vector['status'] === 'Needs consideration') {
                                        $statusClass = 'needs-consideration';
                                    }
                                @endphp
                                <tr>
                                    <td class="status {{ $statusClass }}">{{ $vector['status'] }}</td>
                                    <td class="vector-label">{{ $vector['name'] }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
                <div class="vector-status-container">
                    <div class="vector-status-title">Next Steps</div>
                    <div class="next-steps-content">
                        <p>It looks like you’re facing a few challenges and need to prioritise your effort for the next step
                            along the commercialisation journey.</p>
                        <p>Your product looks OK relative to the average Commercialisation Intensity for 304 successfully
                            commercialised products at the selected Maturity. So, we’d suggest downloading our
                            Commercialisation Canvas to start planning or get in touch if you’d like to join one of our
                            market space focussed commercialisation programmes.”</p>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-state">
                <h2>No Profile Data</h2>
                <p>Please complete your profile to see the dashboard summary.</p>
                <a href="{{ route('profile.show') }}" class="btn btn-primary">Complete Profile</a>
            </div>
        @endif
    </div>

    <style>
        .dashboard-container {
            max-width: 90vw;
            margin: 0 auto;
            padding: 20px;
        }


        .profile-and-vector-col {
            display: flex;
            flex-direction: column;
            max-width: 550px;
            gap: 20px;
        }

        .profile-summary {
            margin-bottom: 0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr;
        }

        .info-item {
            display: flex;
            align-items: center;
        }

        .info-label {
            flex: 0 0 150px;
            text-align: right;
            font-weight: bold;
            margin-right: 10px;
            color: black;
            font-size: 14px
        }

        .info-value {
            flex: 1;
            text-align: left;
            color: #000;
            font-size: 14px
        }

        .vector-status-container {
            max-width: 550px;
            border: 4px solid #595959;
            border-radius: 4px;
            background: #f8f8f8;
            font-family: Arial, sans-serif;
        }

        .vector-status-title {
            background: #595959;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            padding: 12px 0;
            letter-spacing: 1px;
        }

        .vector-status-table {
            width: 100%;
            border-collapse: collapse;
        }

        .vector-status-table td {
            padding: 2px 6px;
            font-size: 14px;
        }

        .status {
            font-weight: bold;
            text-align: center;
            width: 180px;
            border-right: 4px solid #595959;
            border-bottom: 4px solid #595959;
            font-size: 14px
        }

        .vector-status-table tr:last-child td.status {
            border-bottom: none;
        }


        .needs-consideration {
            background: #ffe066;
            color: #333;
        }

        .looks-good {
            background: #00e676;
            color: #222;
        }

        .needs-attention {
            background: #ff1744;
            color: #fff;
        }

        .vector-label {
            background: #fff;
            color: #222;
            border-left: none;
        }

        .next-steps-content {
            padding: 18px 18px 12px 18px;
            color: #222;
            font-size: 16px;
            background: #f8f8f8;
        }

        .next-steps-content p {
            margin-bottom: 12px;
        }
    </style>
@endsection
