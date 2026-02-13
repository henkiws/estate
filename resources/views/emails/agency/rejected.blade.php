<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Registration Update - {{ config('app.name') }}</title>
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
        .error-box {
            background-color: #fee2e2;
            border-left: 4px solid #ef4444;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .error-box p {
            margin: 8px 0;
            font-size: 14px;
            color: #991b1b;
        }
        .error-box p:first-of-type {
            margin-top: 0;
            font-weight: bold;
            color: #7f1d1d;
            font-size: 15px;
        }
        .error-box p:last-of-type {
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
            <h2 style="color: #1E1C1C; margin-top: 0;">Registration Update</h2>
            
            <p>Hello <strong>{{ $agency->agency_name }}</strong>,</p>

            <p>Thank you for your interest in {{ config('app.name') }}. After reviewing your agency registration, we're unable to approve it at this time.</p>

            @if($reason)
            <!-- Reason Box -->
            <div class="error-box">
                <p>Reason:</p>
                <p>{{ $reason }}</p>
            </div>
            @endif

            <p style="font-weight: bold; margin-top: 25px; margin-bottom: 10px;">Next Steps:</p>
            <p>If you believe this is an error or would like to resubmit your application with corrected information, please:</p>

            <!-- Action List -->
            <div class="action-list">
                <p data-number="1">Review the reason for rejection above</p>
                <p data-number="2">Gather the correct documentation</p>
                <p data-number="3">Contact our support team for assistance</p>
            </div>

            <!-- CTA Button -->
            <div style="text-align: center; margin: 30px 0;">
                <a href="mailto:support@{{ str_replace(['http://', 'https://'], '', config('app.url')) }}" class="cta-button">
                    Contact Support
                </a>
            </div>

            <p>We're here to help you through this process.</p>

            <p style="margin-top: 25px;">Best regards,<br>
            The {{ config('app.name') }} Team</p>

            <!-- Alternative Link -->
            <p style="font-size: 14px; margin-top: 30px;">If you're having trouble clicking the button, send an email directly to:</p>
            <div class="link-text">
                <a href="mailto:support@{{ str_replace(['http://', 'https://'], '', config('app.url')) }}">support@{{ str_replace(['http://', 'https://'], '', config('app.url')) }}</a>
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
                Email: support@{{ str_replace(['http://', 'https://'], '', config('app.url')) }} | Phone: 1300 XXX XXX
            </p>
        </div>
    </div>
</body>
</html>