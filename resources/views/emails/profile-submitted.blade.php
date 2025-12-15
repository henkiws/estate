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
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            background: #f9fafb;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .info-box {
            background: white;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .info-box strong {
            color: #667eea;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: 600;
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
        <h1>🔔 New Profile Submission</h1>
    </div>
    
    <div class="content">
        <p>Hello Admin,</p>
        
        <p>A new user profile has been submitted and is awaiting your review and approval.</p>
        
        <div class="info-box">
            <p><strong>Applicant Name:</strong> {{ $userName }}</p>
            <p><strong>Email:</strong> {{ $userEmail }}</p>
            <p><strong>Submitted At:</strong> {{ \Carbon\Carbon::parse($submittedAt)->format('F j, Y \a\t g:i A') }}</p>
        </div>
        
        <p>Please review the profile and either approve or reject the application.</p>
        
        <center>
            <a href="{{ $profileUrl }}" class="button">
                Review Profile →
            </a>
        </center>
        
        <p style="margin-top: 30px; font-size: 14px; color: #6b7280;">
            <strong>Important:</strong> The applicant will not be able to apply for properties until their profile is approved.
        </p>
    </div>
    
    <div class="footer">
        <p>This is an automated notification from Sorted Services</p>
        <p>© {{ date('Y') }} Sorted Services. All rights reserved.</p>
    </div>
</body>
</html>