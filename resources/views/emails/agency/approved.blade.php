<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Approved</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #10B981, #059669); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
        .button { display: inline-block; padding: 12px 30px; background: #10B981; color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .success-box { background: #D1FAE5; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #10B981; }
        .features { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .feature-item { padding: 10px 0; border-bottom: 1px solid #e5e5e5; }
        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎊 Congratulations!</h1>
            <p style="font-size: 18px; margin: 10px 0 0 0;">Your Agency Has Been Approved</p>
        </div>
        <div class="content">
            <h2>Welcome to Sorted, {{ $agency->agency_name }}!</h2>
            
            <div class="success-box">
                <p style="margin: 0; font-size: 16px;"><strong>Your agency is now active and ready to use all features!</strong></p>
            </div>
            
            <p>We're excited to have you on board. Your agency profile has been verified and approved.</p>
            
            <div class="features">
                <h3>You can now:</h3>
                <div class="feature-item">✓ Add and manage your agents</div>
                <div class="feature-item">✓ List and manage properties</div>
                <div class="feature-item">✓ Upload documents and compliance information</div>
                <div class="feature-item">✓ Customize your agency branding</div>
                <div class="feature-item">✓ Access full dashboard and analytics</div>
                <div class="feature-item">✓ Manage tenant and landlord relationships</div>
            </div>
            
            <p><strong>Get Started:</strong></p>
            <p>We recommend completing these steps to get the most out of Sorted:</p>
            <ol>
                <li>Complete your agency profile and branding</li>
                <li>Add your team members and agents</li>
                <li>Upload required compliance documents</li>
                <li>Start listing your properties</li>
            </ol>
            
            <a href="{{ config('app.url') }}/agency/dashboard" class="button">Access Your Dashboard</a>
            
            <p>Need help getting started? Check out our <a href="{{ config('app.url') }}/help">Help Center</a> or contact our support team.</p>
            
            <p>Welcome aboard!<br>
            <strong>The Sorted Team</strong></p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Sorted Services. All rights reserved.</p>
            <p>If you have any questions, contact us at support@sorted.com</p>
        </div>
    </div>
</body>
</html>
