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
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .warning-icon {
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
            color: #d97706;
            font-size: 22px;
            margin-top: 0;
        }
        .alert-box {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .alert-box strong {
            color: #d97706;
            display: block;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .reason-box {
            background: #fef2f2;
            border: 2px solid #fca5a5;
            padding: 20px;
            margin: 25px 0;
            border-radius: 8px;
        }
        .reason-box h3 {
            color: #dc2626;
            font-size: 16px;
            margin-top: 0;
            margin-bottom: 10px;
        }
        .reason-box p {
            color: #991b1b;
            margin: 0;
            font-size: 15px;
            line-height: 1.6;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 14px 32px;
            text-decoration: none;
            border-radius: 8px;
            margin: 20px 0;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(245, 158, 11, 0.3);
        }
        .button:hover {
            box-shadow: 0 6px 8px rgba(245, 158, 11, 0.4);
        }
        .action-required {
            background: #f9fafb;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }
        .action-required h3 {
            color: #374151;
            font-size: 18px;
            margin-top: 0;
        }
        .action-required ul {
            margin: 0;
            padding-left: 20px;
        }
        .action-required li {
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
            color: #f59e0b;
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
            <div class="warning-icon">⚠</div>
            <h1>Profile Update Required</h1>
        </div>
        
        <div class="content">
            <p>Hello {{ $userName }},</p>
            
            <h2>Profile Review Update</h2>
            
            <p>Thank you for submitting your profile. After careful review, we need you to update some information before we can approve your profile.</p>
            
            <div class="reason-box">
                <h3>📋 Reason for Update Request:</h3>
                <p>{{ $rejectionReason }}</p>
            </div>

            <div class="alert-box">
                <strong>What You Need to Do:</strong>
                <p style="margin: 5px 0;">Please review the feedback above and update your profile accordingly. Once you've made the necessary changes, resubmit your profile for review.</p>
            </div>

            <center>
                <a href="{{ $updateProfileUrl }}" class="button">
                    Update Profile Now →
                </a>
            </center>

            <div class="action-required">
                <h3>📝 Common Updates Needed:</h3>
                <ul>
                    <li><strong>Identity Documents:</strong> Ensure you have minimum 80 points of valid ID</li>
                    <li><strong>Income Verification:</strong> Upload clear, recent bank statements or payslips</li>
                    <li><strong>Employment Details:</strong> Provide complete employment history and letters</li>
                    <li><strong>Contact Information:</strong> Double-check all contact details are correct</li>
                    <li><strong>Document Quality:</strong> Make sure all uploaded documents are clear and readable</li>
                </ul>
            </div>

            <p style="margin-top: 30px; font-size: 14px; color: #6b7280;">
                <strong>Reviewed on:</strong> {{ \Carbon\Carbon::parse($rejectedAt)->format('F j, Y \a\t g:i A') }}
            </p>

            <p style="margin-top: 30px;">
                If you have any questions about the required updates or need assistance, please don't hesitate to contact our support team.
            </p>

            <p>
                Best regards,<br>
                <strong>The Sorted Team</strong>
            </p>
        </div>
        
        <div class="footer">
            <p>This is an automated notification from Sorted Services</p>
            <p>
                <a href="{{ $updateProfileUrl }}">Update Profile</a> • 
                <a href="mailto:support@sorted.com">Support</a>
            </p>
            <p>© {{ date('Y') }} Sorted Services. All rights reserved.</p>
        </div>
    </div>
</body>
</html>