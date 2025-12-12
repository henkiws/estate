<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .email-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .success-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 40px;
        }
        .content {
            padding: 40px 30px;
        }
        .content h2 {
            color: #10b981;
            font-size: 22px;
            margin-top: 0;
        }
        .info-box {
            background: #f0fdf4;
            border-left: 4px solid #10b981;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .info-box strong {
            color: #059669;
            display: block;
            margin-bottom: 5px;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 14px 32px;
            text-decoration: none;
            border-radius: 8px;
            margin: 20px 0;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(16, 185, 129, 0.3);
        }
        .button:hover {
            box-shadow: 0 6px 8px rgba(16, 185, 129, 0.4);
        }
        .next-steps {
            background: #f9fafb;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }
        .next-steps h3 {
            color: #374151;
            font-size: 18px;
            margin-top: 0;
        }
        .next-steps ul {
            margin: 0;
            padding-left: 20px;
        }
        .next-steps li {
            margin: 10px 0;
            color: #6b7280;
        }
        .footer {
            text-align: center;
            padding: 30px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .footer a {
            color: #10b981;
            text-decoration: none;
        }
        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }
            .header, .content {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="success-icon">✓</div>
            <h1>Profile Approved!</h1>
        </div>
        
        <div class="content">
            <p>Hello {{ $userName }},</p>
            
            <h2>🎉 Great News!</h2>
            
            <p>We're pleased to inform you that your profile has been <strong>approved</strong> and you can now start applying for properties on Sorted.</p>
            
            <div class="info-box">
                <strong>What This Means:</strong>
                <p style="margin: 5px 0;">Your profile has been verified and you now have full access to all features including property applications, saved properties, and direct communication with agencies.</p>
            </div>

            <center>
                <a href="{{ $dashboardUrl }}" class="button">
                    Go to Dashboard →
                </a>
            </center>

            <div class="next-steps">
                <h3>🏡 Next Steps:</h3>
                <ul>
                    <li><strong>Browse Properties:</strong> Explore available rentals and properties for sale</li>
                    <li><strong>Save Favorites:</strong> Create a shortlist of properties you're interested in</li>
                    <li><strong>Apply for Properties:</strong> Submit applications directly through the platform</li>
                    <li><strong>Track Applications:</strong> Monitor your application status in real-time</li>
                </ul>
            </div>

            <center>
                <a href="{{ $propertiesUrl }}" style="display: inline-block; margin: 10px; color: #10b981; text-decoration: none; font-weight: 600;">
                    Browse Properties →
                </a>
            </center>

            <p style="margin-top: 30px; font-size: 14px; color: #6b7280;">
                <strong>Approved on:</strong> {{ $approvedAt->format('F j, Y \a\t g:i A') }}
            </p>

            <p style="margin-top: 30px;">
                If you have any questions, feel free to contact our support team.
            </p>

            <p>
                Best regards,<br>
                <strong>The Sorted Team</strong>
            </p>
        </div>
        
        <div class="footer">
            <p>This is an automated notification from Sorted Services</p>
            <p>
                <a href="{{ $dashboardUrl }}">Dashboard</a> • 
                <a href="{{ $propertiesUrl }}">Properties</a> • 
                <a href="mailto:support@sorted.com">Support</a>
            </p>
            <p>© {{ date('Y') }} Sorted Services. All rights reserved.</p>
        </div>
    </div>
</body>
</html>