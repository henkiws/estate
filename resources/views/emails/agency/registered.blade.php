<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Sorted</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #0066FF, #0052CC); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
        .button { display: inline-block; padding: 12px 30px; background: #0066FF; color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .info-box { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #0066FF; }
        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to Sorted! 🎉</h1>
        </div>
        <div class="content">
            <h2>Thank you for registering, {{ $agency->agency_name }}!</h2>
            
            <p>We've received your agency registration and it's currently under review by our team.</p>
            
            <div class="info-box">
                <h3>Registration Details:</h3>
                <p><strong>Agency Name:</strong> {{ $agency->agency_name }}</p>
                <p><strong>ABN:</strong> {{ $agency->abn }}</p>
                <p><strong>License Number:</strong> {{ $agency->license_number }}</p>
                <p><strong>State:</strong> {{ $agency->state }}</p>
                <p><strong>Business Email:</strong> {{ $agency->business_email }}</p>
                <p><strong>Status:</strong> <span style="color: #FF9500;">Pending Approval</span></p>
            </div>
            
            <h3>What happens next?</h3>
            <ol>
                <li>Our team will review your registration details</li>
                <li>We'll verify your license and ABN information</li>
                <li>You'll receive an approval notification within 24-48 hours</li>
                <li>Once approved, you can access all features</li>
            </ol>
            
            <p>In the meantime, you can log in to your dashboard to complete your profile:</p>
            
            <a href="{{ config('app.url') }}/agency/dashboard" class="button">Go to Dashboard</a>
            
            <p>If you have any questions, please don't hesitate to contact our support team.</p>
            
            <p>Best regards,<br>
            <strong>The Sorted Team</strong></p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Sorted Services. All rights reserved.</p>
            <p>This is an automated email, please do not reply.</p>
        </div>
    </div>
</body>
</html>