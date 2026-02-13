<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Address Reference Request</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .email-header {
            background-color: #1E1C1C;
            padding: 20px;
            text-align: center;
        }
        .email-header img {
            max-width: 150px;
            height: auto;
        }
        .email-content {
            padding: 30px;
        }
        .applicant-info {
            background-color: #f9f9f9;
            border-left: 4px solid #E6FF4B;
            padding: 15px;
            margin: 20px 0;
        }
        .applicant-info p {
            margin: 5px 0;
            font-size: 14px;
        }
        .applicant-info strong {
            color: #1E1C1C;
        }
        .info-section {
            margin: 25px 0;
        }
        .info-section p {
            margin: 10px 0;
            font-size: 14px;
            color: #555;
        }
        .cta-button {
            display: inline-block;
            background-color: #0d9488;
            color: #ffffff !important;
            text-decoration: none;
            padding: 15px 40px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 16px;
            margin: 20px 0;
            text-align: center;
        }
        .cta-button:hover {
            background-color: #057e74;
        }
        .link-text {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            word-break: break-all;
            font-size: 12px;
            color: #666;
            margin: 15px 0;
        }
        .link-text a {
            color: #0066cc;
            text-decoration: none;
        }
        .help-link {
            color: #0066cc;
            text-decoration: none;
        }
        .help-link:hover {
            text-decoration: underline;
        }
        .email-footer {
            background-color: #2c2c2c;
            color: #ffffff;
            padding: 25px;
            font-size: 12px;
            text-align: center;
        }
        .email-footer p {
            margin: 8px 0;
        }
        .email-footer a {
            color: #E6FF4B;
            text-decoration: none;
        }
        .email-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <!-- Add your logo here -->
            <h2 style="color: #E6FF4B; margin: 0;">Plyform</h2>
        </div>

        <!-- Content -->
        <div class="email-content">
            <h2 style="color: #1E1C1C; margin-top: 0;">Address Reference Request</h2>
            
            <p>Hello,</p>
            
            <p><strong>{{ $user->profile->first_name ?? $user->name }} {{ $user->profile->last_name ?? '' }}</strong> has applied for a rental property and has listed you as an address reference.</p>

            <div class="applicant-info">
                <p><strong>Name:</strong> {{ $user->profile->first_name ?? $user->name }} {{ $user->profile->last_name ?? '' }}</p>
                <p><strong>Address:</strong> {{ $address->address }}</p>
                <p><strong>Duration:</strong> {{ $address->years_lived }} {{ Str::plural('year', $address->years_lived) }}, {{ $address->months_lived }} {{ Str::plural('month', $address->months_lived) }}</p>
                <p><strong>Living Arrangement:</strong> {{ ucfirst(str_replace('_', ' ', $address->living_arrangement)) }}</p>
            </div>

            <div class="info-section">
                <p>We need you to verify the address history for this applicant.</p>
            </div>

            <p>It only takes a few minutes. {{ $user->profile->first_name ?? $user->name }}'s responses will be visible to property agents considering them for a rental property.</p>

            <!-- CTA Button -->
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $referenceUrl }}" class="cta-button">
                    Complete Reference Form
                </a>
            </div>

            <!-- Alternative Link -->
            <p style="font-size: 14px;">Or, paste this link into your browser:</p>
            <div class="link-text">
                <a href="{{ $referenceUrl }}">{{ $referenceUrl }}</a>
            </div>

            <p style="font-size: 14px;">
                💡 <strong>Quick Note:</strong> You can save your progress as a draft and complete the form later. Your responses will be saved automatically.
            </p>

            <p style="font-size: 14px;">
                Have questions about how to complete this reference? 
                <a href="{{ config('app.url') }}/help" class="help-link">Get help with the reference form.</a>
            </p>

            <p style="margin-top: 30px;">Kind regards,<br>The team at <a href="{{ config('app.url') }}" style="color: #0066cc;">{{ config('app.name') }}</a>, on behalf of {{ $user->profile->first_name ?? $user->name }} {{ $user->profile->last_name ?? '' }}</p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p><strong>Please do not reply to this email.</strong></p>
            
            <p>
                <a href="{{ config('app.url') }}/support">Support FAQs</a> | 
                <a href="{{ config('app.url') }}/terms">Terms of use</a> | 
                <a href="{{ config('app.url') }}/privacy">Privacy Policy</a>
            </p>
            
            <p style="margin-top: 15px; font-size: 11px;">
                By providing a reference, you consent to Plyform collecting and using your information in accordance with our <a href="{{ config('app.url') }}/privacy">Privacy Policy</a>.
            </p>
            
            <p style="margin-top: 15px; color: #999;">
                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>