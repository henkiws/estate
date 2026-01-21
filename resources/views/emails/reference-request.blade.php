<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reference Request</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #1E1C1C;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #DDEECD 0%, #E6FF4B 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            color: #1E1C1C;
            font-size: 28px;
            font-weight: 700;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #1E1C1C;
            margin-bottom: 20px;
        }
        .text {
            color: #4b5563;
            margin-bottom: 20px;
            font-size: 15px;
        }
        .highlight-box {
            background: #DDEECD;
            border-left: 4px solid #5E17EB;
            padding: 20px;
            margin: 25px 0;
            border-radius: 8px;
        }
        .highlight-box p {
            margin: 8px 0;
            color: #1E1C1C;
        }
        .highlight-box strong {
            color: #5E17EB;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #5E17EB 0%, #8B3FFF 100%);
            color: #ffffff !important;
            padding: 16px 40px;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            margin: 25px 0;
            box-shadow: 0 4px 12px rgba(94, 23, 235, 0.3);
            transition: transform 0.2s;
        }
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(94, 23, 235, 0.4);
        }
        .info-section {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
        }
        .info-section h3 {
            margin-top: 0;
            color: #1E1C1C;
            font-size: 16px;
        }
        .info-section ul {
            margin: 10px 0;
            padding-left: 20px;
        }
        .info-section li {
            margin: 8px 0;
            color: #4b5563;
        }
        .footer {
            background: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            margin: 5px 0;
            color: #6b7280;
            font-size: 13px;
        }
        .footer a {
            color: #5E17EB;
            text-decoration: none;
        }
        .expiry-notice {
            background: #FEF3C7;
            border-left: 4px solid #F59E0B;
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;
            font-size: 14px;
            color: #92400E;
        }
        @media only screen and (max-width: 600px) {
            .container {
                margin: 20px;
            }
            .header, .content, .footer {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🏠 Plyform Rental Reference</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <p class="greeting">Dear {{ $referenceName }},</p>

            <p class="text">
                <strong>{{ $userName }}</strong> has listed you as a {{ $relationship }} reference 
                for their rental application through Plyform. They are applying for a rental property 
                and would greatly appreciate your help.
            </p>

            <div class="highlight-box">
                <p><strong>Applicant:</strong> {{ $userName }}</p>
                <p><strong>Your Relationship:</strong> {{ ucwords(str_replace('_', ' ', $relationship)) }}</p>
                <p><strong>Time Required:</strong> Approximately 5-10 minutes</p>
            </div>

            <p class="text">
                Your reference helps property managers make informed decisions and assists 
                {{ $userName }} in securing their desired rental property. All information you 
                provide will be kept confidential and used solely for this rental application.
            </p>

            <center>
                <a href="{{ $referenceUrl }}" class="cta-button">
                    Provide Reference
                </a>
            </center>

            <div class="info-section">
                <h3>What You'll Be Asked:</h3>
                <ul>
                    <li>How long you've known the applicant</li>
                    <li>Your assessment of their character and reliability</li>
                    <li>Whether you'd recommend them as a tenant</li>
                    <li>Any additional comments you'd like to share</li>
                </ul>
            </div>

            <div class="expiry-notice">
                ⏰ <strong>Important:</strong> This reference link will expire in 14 days. 
                Please complete it at your earliest convenience.
            </div>

            <p class="text">
                If you have any questions or concerns about this reference request, please don't 
                hesitate to contact us at 
                <a href="mailto:support@plyform.com" style="color: #5E17EB;">support@plyform.com</a>.
            </p>

            <p class="text">
                Thank you for taking the time to help {{ $userName }}!
            </p>

            <p class="text" style="margin-top: 30px;">
                Best regards,<br>
                <strong>The Plyform Team</strong>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Plyform</strong> - Property Rental Made Simple</p>
            <p>
                <a href="{{ config('app.url') }}">Visit Website</a> | 
                <a href="mailto:support@plyform.com">Contact Support</a>
            </p>
            <p style="margin-top: 15px;">
                You received this email because {{ $userName }} provided your email address 
                as a rental reference.
            </p>
            <p style="margin-top: 10px; font-size: 12px;">
                © {{ date('Y') }} Plyform. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>