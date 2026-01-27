<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: #E01E5A;
            color: white;
            padding: 30px;
            text-align: left;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .content {
            background: #fff;
            padding: 30px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Thank you</h1>
    </div>

    <div class="content">
        <p><strong>Your reference was submitted</strong></p>

        <p>This feedback was sent to agencies processing your application. Your information will only be shared back with rental agencies managing the property.</p>

        <p>Thank you for taking the time to complete this reference.</p>

        <p>
            Best regards,<br>
            <strong>Plyform Team</strong>
        </p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Plyform. All rights reserved.</p>
    </div>
</body>
</html>