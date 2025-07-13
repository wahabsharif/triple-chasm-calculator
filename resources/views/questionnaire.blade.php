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
            max-width: 90vw;
            margin: 0 auto;
            padding: 10px 0;
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

        .questionnaire-table td {
            border-bottom: 1px solid #595959;
            padding: 10px;
            vertical-align: middle;
        }

        .questionnaire-table td[rowspan] {
            font-weight: bold;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-success {
            color: #3c763d;
            background-color: #dff0d8;
            border-color: #d6e9c6;
        }
    </style>

    <div class="container questionnaire-container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('questionnaire.store') }}" style="border: 4px solid #595959">
            @csrf
            <table class="questionnaire-table">
                <thead>
                    <tr class="questionnaire-header-row">
                        <th class="questionnaire-th" style="width: 200px">Vector</th>
                        <th class="questionnaire-th">Question</th>
                        <th class="questionnaire-th" style="width: 200px">Response</th>
                        <th class="questionnaire-th" style="width: 120px">Avg</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questionnaires as $questionnaire)
                        @php
                            // Prepare all field names for this vector
                            $vectorFieldNames = [];
                            for ($i = 0; $i < count($questionnaire['questions']); $i++) {
                                if ($questionnaire['id'] <= 4) {
                                    $vectorFieldNames[] = 'Q' . (($questionnaire['id'] - 1) * 3 + $i + 1);
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
                                    $vectorFieldNames[] = $vectorCodes[$questionnaire['id']] . '_' . ($i + 1);
                                }
                            }
                            // Calculate vector average
                            $vectorSum = 0;
                            $vectorCount = 0;
                            foreach ($vectorFieldNames as $fname) {
                                $selectedLabel = old($fname, $questionnaireData[$fname] ?? null);
                                if ($selectedLabel && isset($scoreMap[$selectedLabel])) {
                                    $vectorSum += $scoreMap[$selectedLabel];
                                    $vectorCount++;
                                }
                            }
                            $vectorAvg = $vectorCount ? number_format($vectorSum / $vectorCount, 1) : '';
                        @endphp
                        @foreach ($questionnaire['questions'] as $questionIndex => $question)
                            <tr>
                                @if ($questionIndex === 0)
                                    <td rowspan="{{ count($questionnaire['questions']) }}">
                                        {{ $questionnaire['vector_name'] }}</td>
                                @endif
                                <td>{{ $question }}</td>
                                <td style="background: white">
                                    @php
                                        $fieldName = $vectorFieldNames[$questionIndex];
                                    @endphp
                                    <select name="{{ $fieldName }}" class="form-control auto-save-select"
                                        data-field="{{ $fieldName }}">
                                        <option value="">Select Response...</option>
                                        @foreach ($scoreMap as $label => $score)
                                            <option value="{{ $label }}"
                                                {{ old($fieldName, $questionnaireData[$fieldName] ?? null) == $label ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                {{-- Vector Average (only in first row) --}}
                                @if ($questionIndex === 0)
                                    <td rowspan="{{ count($questionnaire['questions']) }}"
                                        style="text-align:center; font-weight:bold; background:#f7f7f7; vertical-align:middle;">
                                        {{ $vectorAvg }}
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
            <div style="text-align:center; margin: 20px 0;">
                <button type="submit" class="btn btn-primary">Save Questionnaire</button>
            </div>
        </form>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.auto-save-select').forEach(function(select) {
                    select.addEventListener('change', function() {
                        const field = this.getAttribute('data-field');
                        const value = this.value;
                        const token = document.querySelector('input[name="_token"]').value;
                        fetch("{{ route('questionnaire.store') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': token,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    field: field,
                                    value: value
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                // Display the stored field and value in the console log
                                if (data && data.field && data.value) {
                                    console.log('Saved:', data.field, '=', data.value);
                                } else {
                                    console.log('Response:', data);
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                            });
                    });
                });
            });
        </script>
    </div>
@endsection
