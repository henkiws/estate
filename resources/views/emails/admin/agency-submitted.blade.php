<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Agency Submitted for Review</title>
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
        .alert-box {
            background-color: #fff7ed;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .alert-box p {
            margin: 5px 0;
            font-size: 14px;
            color: #92400e;
        }
        .alert-box strong {
            color: #78350f;
        }
        .info-box {
            background-color: #f9f9f9;
            border-left: 4px solid #E6FF4B;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .info-box p {
            margin: 8px 0;
            font-size: 14px;
            color: #555;
        }
        .info-box strong {
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
            <h2 style="color: #E6FF4B; margin: 0;">Plyform Admin</h2>
        </div>

        <!-- Content -->
        <div class="email-content">
            <h2 style="color: #1E1C1C; margin-top: 0;">🔔 New Agency Review Required</h2>
            
            <p>An agency has completed their onboarding and submitted their application for review.</p>

            <!-- Alert Box -->
            <div class="alert-box">
                <p><strong>Action Required</strong></p>
                <p>Please review the agency details and documents to approve or reject their application.</p>
            </div>

            <!-- Agency Information Box -->
            <div class="info-box">
                <p style="margin-top: 0;"><strong>Agency Information</strong></p>
                <p><strong>Agency Name:</strong> {{ $agency->agency_name }}</p>
                <p><strong>Trading Name:</strong> {{ $agency->trading_name }}</p>
                <p><strong>ABN:</strong> {{ $agency->abn }}</p>
                <p><strong>License Number:</strong> {{ $agency->license_number }}</p>
                <p><strong>State:</strong> {{ $agency->state }}</p>
                <p><strong>Business Email:</strong> {{ $agency->business_email }}</p>
                <p><strong>Business Phone:</strong> {{ $agency->business_phone }}</p>
                <p><strong>Documents Uploaded:</strong> {{ $documentsUploaded }}</p>
                <p style="margin-bottom: 0;"><strong>Submitted At:</strong> {{ $agency->onboarding_completed_at ? \Carbon\Carbon::parse($agency->onboarding_completed_at)->format('d M Y, h:i A') : 'Recently' }}</p>
            </div>

            <p>Click the button below to review this agency application:</p>

            <!-- CTA Button -->
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ config('app.url') }}/admin/agencies/{{ $agency->id }}" class="cta-button">
                    Review Agency Application
                </a>
            </div>

            <!-- Alternative Link -->
            <p style="font-size: 14px;">If you're having trouble clicking the button, copy and paste the URL below into your web browser:</p>
            <div class="link-text">
                <a href="{{ config('app.url') }}/admin/agencies/{{ $agency->id }}">{{ config('app.url') }}/admin/agencies/{{ $agency->id }}</a>
            </div>

            <p style="margin-top: 30px; font-size: 14px; color: #666;">This notification was sent because a new agency requires your review and approval.</p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p><strong>Please do not reply to this email.</strong></p>
            
            <p>
                <a href="{{ config('app.url') }}/support">Support FAQs</a> | 
                <a href="{{ config('app.url') }}/terms">Terms of use</a> | 
                <a href="{{ config('app.url') }}/privacy">Privacy Policy</a>
            </p>
            
            <p style="margin-top: 15px; color: #999;">
                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>