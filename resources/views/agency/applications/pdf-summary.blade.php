<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Application Summary - {{ $application->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }
        .header {
            background-color: #5E17EB;
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            background-color: #DDEECD;
            padding: 10px;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 10px;
            border-left: 4px solid #5E17EB;
        }
        .info-row {
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }
        .label {
            font-weight: bold;
            display: inline-block;
            width: 180px;
        }
        .value {
            display: inline-block;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #5E17EB;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th {
            background-color: #f5f5f5;
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>RENTAL APPLICATION SUMMARY</h1>
        <p>Application ID: #{{ $application->id }}</p>
        <p>Generated: {{ now()->format('d M Y, h:i A') }}</p>
    </div>

    <div class="section">
        <div class="section-title">PROPERTY INFORMATION</div>
        <div class="info-row">
            <span class="label">Property Address:</span>
            <span class="value">{{ $application->property->full_address }}</span>
        </div>
        <div class="info-row">
            <span class="label">Property Code:</span>
            <span class="value">{{ $application->property->property_code }}</span>
        </div>
        <div class="info-row">
            <span class="label">Weekly Rent:</span>
            <span class="value">${{ number_format($application->property->rent_per_week, 2) }}</span>
        </div>
    </div>

    <div class="section">
        <div class="section-title">APPLICANT INFORMATION</div>
        <div class="info-row">
            <span class="label">Full Name:</span>
            <span class="value">{{ $application->user->profile->first_name }} {{ $application->user->profile->last_name }}</span>
        </div>
        <div class="info-row">
            <span class="label">Email:</span>
            <span class="value">{{ $application->user->email }}</span>
        </div>
        <div class="info-row">
            <span class="label">Phone:</span>
            <span class="value">{{ $application->user->profile->mobile_country_code }} {{ $application->user->profile->mobile_number }}</span>
        </div>
        <div class="info-row">
            <span class="label">Date of Birth:</span>
            <span class="value">{{ $application->user->profile->date_of_birth->format('d M Y') }}</span>
        </div>
    </div>

    <div class="section">
        <div class="section-title">APPLICATION DETAILS</div>
        <div class="info-row">
            <span class="label">Submitted Date:</span>
            <span class="value">{{ $application->submitted_at->format('d M Y, h:i A') }}</span>
        </div>
        <div class="info-row">
            <span class="label">Status:</span>
            <span class="value">{{ ucfirst($application->status) }}</span>
        </div>
        <div class="info-row">
            <span class="label">Move-in Date:</span>
            <span class="value">{{ $application->move_in_date->format('d M Y') }}</span>
        </div>
        <div class="info-row">
            <span class="label">Lease Term:</span>
            <span class="value">{{ $application->lease_term }} months</span>
        </div>
        <div class="info-row">
            <span class="label">Number of Occupants:</span>
            <span class="value">{{ $application->number_of_occupants }}</span>
        </div>
        <div class="info-row">
            <span class="label">Property Inspected:</span>
            <span class="value">{{ $application->property_inspection === 'yes' ? 'Yes' : 'No' }}</span>
        </div>
        @if($application->inspection_date)
        <div class="info-row">
            <span class="label">Inspection Date:</span>
            <span class="value">{{ $application->inspection_date->format('d M Y') }}</span>
        </div>
        @endif
    </div>

    <div class="section">
        <div class="section-title">FINANCIAL INFORMATION</div>
        <div class="info-row">
            <span class="label">Total Annual Income:</span>
            <span class="value">${{ number_format($application->annual_income, 2) }}</span>
        </div>
        
        @if($application->user->incomes->count() > 0)
        <table style="margin-top: 15px;">
            <thead>
                <tr>
                    <th>Income Source</th>
                    <th>Net Weekly Amount</th>
                    <th>Annual Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($application->user->incomes as $income)
                <tr>
                    <td>{{ ucfirst(str_replace('_', ' ', $income->source_of_income)) }}</td>
                    <td>${{ number_format($income->net_weekly_amount, 2) }}</td>
                    <td>${{ number_format($income->net_weekly_amount * 52, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    @if($application->user->employments->count() > 0)
    <div class="section">
        <div class="section-title">EMPLOYMENT HISTORY</div>
        @foreach($application->user->employments as $employment)
        <div style="margin-bottom: 15px; padding: 10px; background-color: #f9f9f9;">
            <div class="info-row">
                <span class="label">Company:</span>
                <span class="value">{{ $employment->company_name }}</span>
            </div>
            <div class="info-row">
                <span class="label">Position:</span>
                <span class="value">{{ $employment->position }}</span>
            </div>
            <div class="info-row">
                <span class="label">Gross Annual Salary:</span>
                <span class="value">${{ number_format($employment->gross_annual_salary, 2) }}</span>
            </div>
            <div class="info-row">
                <span class="label">Employment Period:</span>
                <span class="value">{{ \Carbon\Carbon::parse($employment->start_date)->format('M Y') }} - {{ $employment->still_employed ? 'Present' : \Carbon\Carbon::parse($employment->end_date)->format('M Y') }}</span>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    @if($application->user->addresses->count() > 0)
    <div class="section">
        <div class="section-title">ADDRESS HISTORY</div>
        @foreach($application->user->addresses as $address)
        <div style="margin-bottom: 10px;">
            <div class="info-row">
                <span class="label">Address:</span>
                <span class="value">{{ $address->address }}</span>
            </div>
            <div class="info-row">
                <span class="label">Duration:</span>
                <span class="value">{{ $address->years_lived }} years, {{ $address->months_lived }} months</span>
            </div>
            <div class="info-row">
                <span class="label">Living Arrangement:</span>
                <span class="value">{{ ucfirst(str_replace('_', ' ', $address->living_arrangement)) }}</span>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    @if($application->special_requests)
    <div class="section">
        <div class="section-title">SPECIAL REQUESTS</div>
        <p>{{ $application->special_requests }}</p>
    </div>
    @endif

    @if($application->notes)
    <div class="section">
        <div class="section-title">ADDITIONAL NOTES</div>
        <p>{{ $application->notes }}</p>
    </div>
    @endif

    <div class="footer">
        <p>This document is confidential and intended for authorized personnel only.</p>
        <p>Generated by Plyform Property Management System</p>
    </div>
</body>
</html>