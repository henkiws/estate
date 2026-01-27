<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #DDEECD 0%, #E6FF4B 100%);
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            color: #1E1C1C;
            font-size: 24px;
        }
        .content {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .info-box {
            background: #f9fafb;
            border-left: 4px solid #DDEECD;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .info-box strong {
            color: #1E1C1C;
        }
        .button {
            display: inline-block;
            padding: 15px 30px;
            background: linear-gradient(135deg, #5E17EB 0%, #7C3AED 100%);
            color: #fff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
        .button:hover {
            background: linear-gradient(135deg, #7C3AED 0%, #5E17EB 100%);
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📧 Address Reference Request</h1>
    </div>

    <div class="content">
        <p>Dear {{ $address->reference_full_name }},</p>

        <p>You have been listed as an address reference by <strong>{{ $applicant->profile->first_name }} {{ $applicant->profile->last_name }}</strong> for their rental application.</p>

        <div class="info-box">
            <strong>Applicant Details:</strong><br>
            Name: {{ $applicant->profile->first_name }} {{ $applicant->profile->last_name }}<br>
            Email: {{ $applicant->email }}<br>
            Phone: {{ $applicant->profile->mobile_country_code }}{{ $applicant->profile->mobile_number }}
        </div>

        <div class="info-box">
            <strong>Address in Question:</strong><br>
            {{ $address->address }}<br>
            Duration: {{ $address->years_lived }} years, {{ $address->months_lived }} months
        </div>

        <p>We kindly request you to verify this address history by completing a short reference form. This will help the property manager assess the rental application.</p>

        <p style="text-align: center;">
            <a href="{{ $verificationUrl }}" class="button">
                Complete Reference Form
            </a>
        </p>

        <p style="font-size: 14px; color: #6b7280;">
            Or copy and paste this link into your browser:<br>
            <a href="{{ $verificationUrl }}" style="color: #5E17EB; word-break: break-all;">{{ $verificationUrl }}</a>
        </p>

        <p>This request will expire in 7 days. If you did not expect this email or have any questions, please contact us at support@plyform.com</p>

        <p>Thank you for your time and cooperation.</p>

        <p>
            Best regards,<br>
            <strong>Plyform Team</strong>
        </p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Plyform. All rights reserved.</p>
        <p>This is an automated email. Please do not reply directly to this message.</p>
    </div>
</body>
</html>