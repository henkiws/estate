<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Rejected - Action Required</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f3f4f6;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f3f4f6; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); padding: 40px 30px; text-align: center;">
                            <div style="width: 80px; height: 80px; background-color: rgba(255, 255, 255, 0.2); border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center;">
                                <span style="font-size: 40px;">⚠️</span>
                            </div>
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: bold;">Document Rejected</h1>
                            <p style="margin: 10px 0 0 0; color: rgba(255, 255, 255, 0.9); font-size: 16px;">Action Required</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="margin: 0 0 20px 0; color: #374151; font-size: 16px; line-height: 1.6;">
                                Hello <strong>{{ $agency->agency_name }}</strong>,
                            </p>

                            <p style="margin: 0 0 20px 0; color: #374151; font-size: 16px; line-height: 1.6;">
                                We've reviewed your document submission, and unfortunately we cannot approve the following document at this time:
                            </p>

                            <!-- Rejected Document Card -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="border: 2px solid #fecaca; border-radius: 12px; background-color: #fef2f2; margin: 20px 0;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <h2 style="margin: 0 0 10px 0; color: #991b1b; font-size: 18px; font-weight: bold;">
                                            📄 {{ $document->name }}
                                        </h2>
                                        
                                        @if($document->is_required)
                                        <span style="display: inline-block; padding: 4px 12px; background-color: #dc2626; color: #ffffff; border-radius: 9999px; font-size: 12px; font-weight: bold; margin-bottom: 10px;">
                                            Required Document
                                        </span>
                                        @endif

                                        <div style="background-color: #ffffff; border-left: 4px solid #dc2626; padding: 15px; margin-top: 15px; border-radius: 8px;">
                                            <p style="margin: 0 0 8px 0; color: #991b1b; font-size: 14px; font-weight: bold;">
                                                Reason for Rejection:
                                            </p>
                                            <p style="margin: 0; color: #7f1d1d; font-size: 14px; line-height: 1.5;">
                                                {{ $document->rejection_reason }}
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 20px 0; color: #374151; font-size: 16px; line-height: 1.6;">
                                <strong>What You Need to Do:</strong>
                            </p>

                            <ul style="margin: 0 0 20px 0; padding-left: 20px; color: #374151; font-size: 15px; line-height: 1.8;">
                                <li>Review the rejection reason carefully</li>
                                <li>Make the necessary corrections to your document</li>
                                <li>Reupload the corrected document through your account</li>
                            </ul>

                            <!-- CTA Button -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 30px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('agency.onboarding.show', ['step' => 2]) }}" 
                                           style="display: inline-block; padding: 16px 32px; background-color: #2563eb; color: #ffffff; text-decoration: none; border-radius: 12px; font-size: 16px; font-weight: bold; box-shadow: 0 4px 6px rgba(37, 99, 235, 0.3);">
                                            Reupload Document Now
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <div style="background-color: #eff6ff; border: 1px solid: #bfdbfe; border-radius: 12px; padding: 20px; margin: 20px 0;">
                                <p style="margin: 0 0 10px 0; color: #1e40af; font-size: 14px; font-weight: bold;">
                                    💡 Tips for Reupload:
                                </p>
                                <ul style="margin: 0; padding-left: 20px; color: #1e40af; font-size: 14px; line-height: 1.6;">
                                    <li>Ensure the document is clear and legible</li>
                                    <li>Use PDF, JPG, or PNG format</li>
                                    <li>Maximum file size: 5MB</li>
                                    <li>Make sure all information is current and accurate</li>
                                </ul>
                            </div>

                            <p style="margin: 20px 0 0 0; color: #6b7280; font-size: 14px; line-height: 1.6;">
                                If you have any questions about this rejection or need clarification, please don't hesitate to contact our support team.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 30px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0 0 15px 0; color: #6b7280; font-size: 14px;">
                                Need help?
                            </p>
                            <p style="margin: 0; color: #6b7280; font-size: 14px;">
                                <a href="mailto:support@sorted.com" style="color: #2563eb; text-decoration: none; font-weight: bold;">support@sorted.com</a>
                                •
                                <a href="tel:1300123456" style="color: #2563eb; text-decoration: none; font-weight: bold;">1300 123 456</a>
                            </p>
                            
                            <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                                <p style="margin: 0; color: #9ca3af; font-size: 12px;">
                                    © {{ date('Y') }} Sorted Services. All rights reserved.
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>