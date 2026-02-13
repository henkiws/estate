<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ config('app.name') }}</title>
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
        .info-box p:first-of-type {
            margin-top: 0;
            font-weight: bold;
            color: #1E1C1C;
            font-size: 15px;
        }
        .info-box p:last-of-type {
            margin-bottom: 0;
        }
        .status-badge {
            color: #ed8936;
            font-weight: 600;
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
            <h2>{{ config('app.name') }}</h2>
        </div>

        <!-- Content -->
        <div class="email-content">
            <h2 style="color: #1E1C1C; margin-top: 0;">Welcome to {{ config('app.name') }}! 🎉</h2>
            
            <p>Thank you for registering <strong>{{ $agency->agency_name }}</strong> with {{ config('app.name') }}!</p>

            <p>We've received your agency registration and it's currently under review by our team.</p>

            <!-- Registration Details Box -->
            <div class="info-box">
                <p>Registration Details</p>
                <p><strong>Agency Name:</strong> {{ $agency->agency_name }}</p>
                <p><strong>Trading Name:</strong> {{ $agency->trading_name }}</p>
                <p><strong>ABN:</strong> {{ $agency->abn }}</p>
                <p><strong>License Number:</strong> {{ $agency->license_number }}</p>
                <p><strong>State:</strong> {{ $agency->state }}</p>
                <p><strong>Business Email:</strong> {{ $agency->business_email }}</p>
                <p><strong>Status:</strong> <span class="status-badge">Pending Approval</span></p>
            </div>

            <p style="font-weight: bold; margin-top: 25px; margin-bottom: 10px;">What happens next?</p>

            <!-- Action List -->
            <div class="action-list">
                <p data-number="1">Our team will review your registration details</p>
                <p data-number="2">We'll verify your license and ABN information</p>
                <p data-number="3">You'll receive an approval notification within 24-48 hours</p>
                <p data-number="4">Once approved, you can access all features</p>
            </div>

            <p style="margin-top: 25px;">In the meantime, you can log in to your dashboard to complete your profile:</p>

            <!-- CTA Button -->
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ config('app.url') }}/agency/dashboard" class="cta-button">
                    Go to Dashboard
                </a>
            </div>

            <p>If you have any questions, please don't hesitate to contact our support team.</p>

            <p style="margin-top: 25px;">Regards,<br>
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
                This is an automated email, please do not reply.
            </p>
        </div>
    </div>
</body>
</html>