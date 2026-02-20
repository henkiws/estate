<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Rejected - Action Required</title>
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
        .alert-box {
            background-color: #fee2e2;
            border-left: 4px solid #dc2626;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .alert-box p {
            margin: 5px 0;
            font-size: 14px;
            color: #7f1d1d;
        }
        .alert-box strong {
            color: #7f1d1d;
            font-weight: 600;
        }
        .document-card {
            background-color: #fef2f2;
            border: 2px solid #fecaca;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .document-card h3 {
            color: #991b1b;
            font-size: 18px;
            margin: 0 0 10px 0;
        }
        .required-badge {
            display: inline-block;
            background-color: #dc2626;
            color: #ffffff;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .reason-box {
            background-color: #ffffff;
            border-left: 4px solid #dc2626;
            padding: 15px;
            margin-top: 15px;
            border-radius: 5px;
        }
        .reason-box p:first-child {
            margin: 0 0 8px 0;
            color: #991b1b;
            font-size: 14px;
            font-weight: bold;
        }
        .reason-box p:last-child {
            margin: 0;
            color: #7f1d1d;
            font-size: 14px;
        }
        .info-box {
            background-color: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .info-box p {
            margin: 0 0 10px 0;
            color: #1e40af;
            font-size: 14px;
            font-weight: bold;
        }
        .info-box ul {
            margin: 0;
            padding-left: 20px;
            color: #1e40af;
            font-size: 14px;
        }
        .info-box ul li {
            margin: 5px 0;
        }
        .action-list {
            margin: 20px 0;
            padding-left: 20px;
        }
        .action-list li {
            margin: 8px 0;
            font-size: 15px;
            color: #555;
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
            <div style="width: 80px; height: 80px; background-color: rgba(230, 255, 75, 0.2); border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center;">
                <span style="font-size: 40px;">⚠️</span>
            </div>
            <h2 style="margin: 0;">Document Rejected</h2>
            <p style="margin: 10px 0 0 0; color: rgba(230, 255, 75, 0.9); font-size: 16px;">Action Required</p>
        </div>

        <!-- Content -->
        <div class="email-content">
            <p>Hello <strong>{{ $agency->agency_name }}</strong>,</p>

            <p>We've reviewed your document submission, and unfortunately we cannot approve the following document at this time:</p>

            <!-- Document Card -->
            <div class="document-card">
                <h3>📄 {{ $document->name }}</h3>
                
                @if($document->is_required)
                <span class="required-badge">Required Document</span>
                @endif

                <div class="reason-box">
                    <p>Reason for Rejection:</p>
                    <p>{{ $document->rejection_reason }}</p>
                </div>
            </div>

            <p style="font-weight: bold; margin-top: 25px; margin-bottom: 10px;">What You Need to Do:</p>

            <!-- Action List -->
            <ul class="action-list">
                <li>Review the rejection reason carefully</li>
                <li>Make the necessary corrections to your document</li>
                <li>Reupload the corrected document through your account</li>
            </ul>

            <!-- CTA Button -->
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('agency.onboarding.show', ['step' => 2]) }}" class="cta-button">
                    Reupload Document Now
                </a>
            </div>

            <!-- Tips Box -->
            <div class="info-box">
                <p>💡 Tips for Reupload:</p>
                <ul>
                    <li>Ensure the document is clear and legible</li>
                    <li>Use PDF, JPG, or PNG format</li>
                    <li>Maximum file size: 5MB</li>
                    <li>Make sure all information is current and accurate</li>
                </ul>
            </div>

            <p style="color: #666; font-size: 14px; margin-top: 25px;">If you have any questions about this rejection or need clarification, please don't hesitate to contact our support team.</p>

            <!-- Alternative Link -->
            <p style="font-size: 14px; margin-top: 30px;">If you're having trouble clicking the button, copy and paste the URL below into your web browser:</p>
            <div class="link-text">
                <a href="{{ route('agency.onboarding.show', ['step' => 2]) }}">{{ route('agency.onboarding.show', ['step' => 2]) }}</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p><strong>Need help?</strong></p>
            
            <p>
                <a href="mailto:support@{{ str_replace(['http://', 'https://'], '', config('app.url')) }}">support@{{ str_replace(['http://', 'https://'], '', config('app.url')) }}</a>
                •
                <a href="tel:1300123456">1300 123 456</a>
            </p>
            
            <p style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #444;">
                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
            
            <p>
                <a href="{{ config('app.url') }}/support">Support FAQs</a> | 
                <a href="{{ config('app.url') }}/terms">Terms of use</a> | 
                <a href="{{ config('app.url') }}/privacy">Privacy Policy</a>
            </p>
        </div>
    </div>
</body>
</html>