<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Approved - {{ config('app.name') }}</title>
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
        }
        .success-box p:first-of-type {
            margin-top: 0;
            font-weight: bold;
            color: #065f46;
            font-size: 15px;
        }
        .success-box p:last-of-type {
            margin-bottom: 0;
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
        .feature-list {
            margin: 15px 0;
        }
        .feature-list p {
            margin: 10px 0;
            font-size: 14px;
            color: #555;
            padding-left: 20px;
            position: relative;
        }
        .feature-list p:before {
            content: "•";
            position: absolute;
            left: 0;
            color: #0d9488;
            font-weight: bold;
            font-size: 18px;
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
        .secondary-link {
            color: #0d9488;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
        }
        .secondary-link:hover {
            text-decoration: underline;
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
            <h2 style="color: #1E1C1C; margin-top: 0;">Profile Approved! 🎉</h2>
            
            <p>Hello {{ $userName }},</p>

            <p>We're pleased to inform you that your profile has been <strong>approved</strong> and you can now start applying for properties on {{ config('app.name') }}.</p>

            <!-- Success Box -->
            <div class="success-box">
                <p>Great News!</p>
                <p>Your profile has been verified and you now have full access to all features.</p>
            </div>

            <!-- Info Box -->
            <div class="info-box">
                <p>What This Means:</p>
                <p>You can now access property applications, saved properties, and direct communication with agencies.</p>
            </div>

            <!-- CTA Button -->
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $dashboardUrl }}" class="cta-button">
                    Go to Dashboard →
                </a>
            </div>

            <!-- Next Steps Box -->
            <div class="info-box">
                <p>🏡 Next Steps:</p>
                <div class="feature-list">
                    <p><strong>Browse Properties:</strong> Explore available rentals and properties for sale</p>
                    <p><strong>Save Favorites:</strong> Create a shortlist of properties you're interested in</p>
                    <p><strong>Apply for Properties:</strong> Submit applications directly through the platform</p>
                    <p><strong>Track Applications:</strong> Monitor your application status in real-time</p>
                </div>
            </div>

            <!-- Browse Properties Link -->
            <div style="text-align: center; margin: 25px 0;">
                <a href="{{ $propertiesUrl }}" class="secondary-link">
                    Browse Properties →
                </a>
            </div>

            <p style="margin-top: 30px; font-size: 14px; color: #666;">
                <strong>Approved on:</strong> {{ \Carbon\Carbon::parse($approvedAt)->format('F j, Y \a\t g:i A') }}
            </p>

            <p style="margin-top: 30px;">
                If you have any questions, feel free to contact our support team.
            </p>

            <p style="margin-top: 25px;">
                Best regards,<br>
                <strong>The {{ config('app.name') }} Team</strong>
            </p>

            <!-- Alternative Links -->
            <p style="font-size: 14px; margin-top: 30px;">If you're having trouble clicking the button, copy and paste the URL below into your web browser:</p>
            <div class="link-text">
                <a href="{{ $dashboardUrl }}">{{ $dashboardUrl }}</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>This is an automated notification from {{ config('app.name') }}</p>
            
            <p>
                <a href="{{ $dashboardUrl }}">Dashboard</a> • 
                <a href="{{ $propertiesUrl }}">Properties</a> • 
                <a href="mailto:support@{{ str_replace(['http://', 'https://'], '', config('app.url')) }}">Support</a>
            </p>
            
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