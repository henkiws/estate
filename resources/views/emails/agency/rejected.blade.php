<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Registration Update</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #EF4444, #DC2626); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
        .button { display: inline-block; padding: 12px 30px; background: #0066FF; color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .warning-box { background: #FEE2E2; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #EF4444; }
        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Registration Update</h1>
        </div>
        <div class="content">
            <h2>Hello {{ $agency->agency_name }},</h2>
            
            <p>Thank you for your interest in Sorted. After reviewing your agency registration, we're unable to approve it at this time.</p>
            
            @if($reason)
            <div class="warning-box">
                <h3>Reason:</h3>
                <p>{{ $reason }}</p>
            </div>
            @endif
            
            <h3>Next Steps:</h3>
            <p>If you believe this is an error or would like to resubmit your application with corrected information, please:</p>
            <ol>
                <li>Review the reason for rejection above</li>
                <li>Gather the correct documentation</li>
                <li>Contact our support team for assistance</li>
            </ol>
            
            <a href="mailto:support@sorted.com" class="button">Contact Support</a>
            
            <p>We're here to help you through this process.</p>
            
            <p>Best regards,<br>
            <strong>The Sorted Team</strong></p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Sorted Services. All rights reserved.</p>
            <p>Email: support@sorted.com | Phone: 1300 XXX XXX</p>
        </div>
    </div>
</body>
</html>