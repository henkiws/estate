<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Update Required - {{ config('app.name') }}</title>
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
        .warning-box {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .warning-box p {
            margin: 5px 0;
            font-size: 14px;
            color: #92400e;
        }
        .warning-box p:first-of-type {
            margin-top: 0;
            font-weight: bold;
            color: #78350f;
            font-size: 15px;
        }
        .warning-box p:last-of-type {
            margin-bottom: 0;
        }
        .reason-box {
            background-color: #fee2e2;
            border: 2px solid #fca5a5;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .reason-box p {
            margin: 8px 0;
            font-size: 14px;
            color: #991b1b;
        }
        .reason-box p:first-of-type {
            margin-top: 0;
            font-weight: bold;
            color: #7f1d1d;
            font-size: 15px;
        }
        .reason-box p:last-of-type {
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
            color: #f59e0b;
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
            <h2 style="color: #1E1C1C; margin-top: 0;">Profile Update Required ⚠</h2>
            
            <p>Hello {{ $userName }},</p>

            <p>Thank you for submitting your profile. After careful review, we need you to update some information before we can approve your profile.</p>

            <!-- Reason Box -->
            <div class="reason-box">
                <p>📋 Reason for Update Request:</p>
                <p>{{ $rejectionReason }}</p>
            </div>

            <!-- Warning Box -->
            <div class="warning-box">
                <p>What You Need to Do:</p>
                <p>Please review the feedback above and update your profile accordingly. Once you've made the necessary changes, resubmit your profile for review.</p>
            </div>

            <!-- CTA Button -->
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $updateProfileUrl }}" class="cta-button">
                    Update Profile Now →
                </a>
            </div>

            <!-- Common Updates Box -->
            <div class="info-box">
                <p>📝 Common Updates Needed:</p>
                <div class="feature-list">
                    <p><strong>Identity Documents:</strong> Ensure you have minimum 80 points of valid ID</p>
                    <p><strong>Income Verification:</strong> Upload clear, recent bank statements or payslips</p>
                    <p><strong>Employment Details:</strong> Provide complete employment history and letters</p>
                    <p><strong>Contact Information:</strong> Double-check all contact details are correct</p>
                    <p><strong>Document Quality:</strong> Make sure all uploaded documents are clear and readable</p>
                </div>
            </div>

            <p style="margin-top: 30px; font-size: 14px; color: #666;">
                <strong>Reviewed on:</strong> {{ \Carbon\Carbon::parse($rejectedAt)->format('F j, Y \a\t g:i A') }}
            </p>

            <p style="margin-top: 30px;">
                If you have any questions about the required updates or need assistance, please don't hesitate to contact our support team.
            </p>

            <p style="margin-top: 25px;">
                Best regards,<br>
                <strong>The {{ config('app.name') }} Team</strong>
            </p>

            <!-- Alternative Link -->
            <p style="font-size: 14px; margin-top: 30px;">If you're having trouble clicking the button, copy and paste the URL below into your web browser:</p>
            <div class="link-text">
                <a href="{{ $updateProfileUrl }}">{{ $updateProfileUrl }}</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>This is an automated notification from {{ config('app.name') }}</p>
            
            <p>
                <a href="{{ $updateProfileUrl }}">Update Profile</a> • 
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