<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Approved - {{ config('app.name') }}</title>
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
        .email-header h2 {
            color: #E6FF4B;
            margin: 0;
        }
        .email-content {
            padding: 30px;
        }
        .success-box {
            background-color: #d1fae5;
            border-left: 4px solid #10b981;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .success-box p {
            margin: 5px 0;
            font-size: 14px;
            color: #065f46;
            font-weight: 600;
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
        .info-box p:first-of-type {
            margin-top: 0;
            font-weight: bold;
            color: #1E1C1C;
            font-size: 15px;
        }
        .info-box p:last-of-type {
            margin-bottom: 0;
        }
        .action-list {
            margin: 20px 0;
        }
        .action-list p {
            margin: 8px 0;
            font-size: 15px;
            color: #555;
            padding-left: 20px;
            position: relative;
        }
        .action-list p:before {
            content: attr(data-number) ".";
            position: absolute;
            left: 0;
            color: #555;
        }
        .feature-list p {
            margin: 8px 0;
            font-size: 14px;
            color: #555;
        }
        .cta-button {
            display: inline-block;
            background-color: #e6ff4b;
            color: #000000 !important;
            text-decoration: none;
            padding: 15px 40px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 16px;
            margin: 20px 0;
            text-align: center;
        }
        .cta-button:hover {
            background-color: #ddeecd;
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
            <h2>{{ config('app.name') }}</h2>
        </div>

        <!-- Content -->
        <div class="email-content">
            <h2 style="color: #1E1C1C; margin-top: 0;">🎊 Congratulations!</h2>
            
            <p>Welcome to {{ config('app.name') }}, <strong>{{ $agency->agency_name }}</strong>!</p>

            <!-- Success Box -->
            <div class="success-box">
                <p>Your agency is now active and ready to use all features!</p>
            </div>

            <p>We're excited to have you on board. Your agency profile has been verified and approved.</p>

            <!-- Features Box -->
            <div class="info-box">
                <p>You can now:</p>
                <div class="feature-list">
                    <p>✓ Add and manage your agents</p>
                    <p>✓ List and manage properties</p>
                    <p>✓ Upload documents and compliance information</p>
                    <p>✓ Customize your agency branding</p>
                    <p>✓ Access full dashboard and analytics</p>
                    <p>✓ Manage tenant and landlord relationships</p>
                </div>
            </div>

            <p style="font-weight: bold; margin-top: 25px; margin-bottom: 10px;">Get Started:</p>
            <p>We recommend completing these steps to get the most out of {{ config('app.name') }}:</p>

            <!-- Action List -->
            <div class="action-list">
                <p data-number="1">Complete your agency profile and branding</p>
                <p data-number="2">Add your team members and agents</p>
                <p data-number="3">Upload required compliance documents</p>
                <p data-number="4">Start listing your properties</p>
            </div>

            <!-- CTA Button -->
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ config('app.url') }}/agency/dashboard" class="cta-button">
                    Access Your Dashboard
                </a>
            </div>

            <p>Need help getting started? Check out our <a href="{{ config('app.url') }}/help" style="color: #0d9488; text-decoration: none;">Help Center</a> or contact our support team.</p>

            <p style="margin-top: 25px;">Welcome aboard!<br>
            The {{ config('app.name') }} Team</p>

            <!-- Alternative Link -->
            <p style="font-size: 14px; margin-top: 30px;">If you're having trouble clicking the button, copy and paste the URL below into your web browser:</p>
            <div class="link-text">
                <a href="{{ config('app.url') }}/agency/dashboard">{{ config('app.url') }}/agency/dashboard</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            
            <p>
                <a href="{{ config('app.url') }}/support">Support FAQs</a> | 
                <a href="{{ config('app.url') }}/terms">Terms of use</a> | 
                <a href="{{ config('app.url') }}/privacy">Privacy Policy</a>
            </p>
            
            <p style="margin-top: 15px; color: #999;">
                If you have any questions, contact us at support@{{ str_replace(['http://', 'https://'], '', config('app.url')) }}
            </p>
        </div>
    </div>
</body>
</html>