<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Address Reference Request</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #f5f5f5;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f5f5f5;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table role="presentation" style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="padding: 32px 40px; text-align: center; border-bottom: 1px solid #e5e5e5;">
                            <h1 style="margin: 0; font-size: 24px; font-weight: 600; color: #1a1a1a;">
                                Address Reference Request
                            </h1>
                        </td>
                    </tr>
                    
                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px;">
                            <p style="margin: 0 0 20px 0; font-size: 16px; line-height: 1.5; color: #333333;">
                                Hello,
                            </p>
                            
                            <p style="margin: 0 0 20px 0; font-size: 16px; line-height: 1.5; color: #333333;">
                                <strong>{{ $user->profile->first_name ?? $user->name }} {{ $user->profile->last_name ?? '' }}</strong> has listed you as an address reference for their rental application.
                            </p>
                            
                            <!-- Address Info Box -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f9f9f9; border-radius: 8px; margin: 24px 0;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <p style="margin: 0 0 12px 0; font-size: 14px; font-weight: 600; color: #666666; text-transform: uppercase; letter-spacing: 0.5px;">
                                            Address Details
                                        </p>
                                        <p style="margin: 0 0 8px 0; font-size: 16px; color: #1a1a1a;">
                                            <strong>Address:</strong><br>
                                            {{ $address->address }}
                                        </p>
                                        <p style="margin: 0 0 8px 0; font-size: 16px; color: #1a1a1a;">
                                            <strong>Duration:</strong> 
                                            {{ $address->years_lived }} {{ Str::plural('year', $address->years_lived) }}, 
                                            {{ $address->months_lived }} {{ Str::plural('month', $address->months_lived) }}
                                        </p>
                                        <p style="margin: 0; font-size: 16px; color: #1a1a1a;">
                                            <strong>Living Arrangement:</strong> 
                                            {{ ucfirst(str_replace('_', ' ', $address->living_arrangement)) }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="margin: 0 0 24px 0; font-size: 16px; line-height: 1.5; color: #333333;">
                                We need you to verify the address history for this applicant. This will only take a few minutes.
                            </p>
                            
                            <!-- CTA Button -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 32px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $referenceUrl }}" style="display: inline-block; padding: 16px 40px; background-color: #FF3600; color: #ffffff; text-decoration: none; font-size: 16px; font-weight: 600; border-radius: 8px; box-shadow: 0 2px 4px rgba(255, 54, 0, 0.2);">
                                            Complete Reference Form
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Alternative Link -->
                            <p style="margin: 24px 0 0 0; font-size: 14px; line-height: 1.5; color: #666666; text-align: center;">
                                If the button doesn't work, copy and paste this link into your browser:<br>
                                <a href="{{ $referenceUrl }}" style="color: #0066cc; text-decoration: underline; word-break: break-all;">
                                    {{ $referenceUrl }}
                                </a>
                            </p>
                            
                            <!-- Info Box -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #E6F7FF; border-radius: 8px; margin: 32px 0;">
                                <tr>
                                    <td style="padding: 16px;">
                                        <p style="margin: 0; font-size: 14px; line-height: 1.5; color: #1a1a1a;">
                                            <strong>💡 Quick Note:</strong> You can save your progress as a draft and complete the form later. Your responses will be saved automatically.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="padding: 24px 40px; background-color: #f9f9f9; border-top: 1px solid #e5e5e5; border-radius: 0 0 8px 8px;">
                            <p style="margin: 0 0 12px 0; font-size: 13px; line-height: 1.5; color: #666666; text-align: center;">
                                This reference request was sent on behalf of {{ $user->profile->first_name ?? $user->name }} {{ $user->profile->last_name ?? '' }}.
                            </p>
                            <p style="margin: 0; font-size: 12px; line-height: 1.5; color: #999999; text-align: center;">
                                Please do not reply to this email. This is an automated message.
                            </p>
                        </td>
                    </tr>
                    
                </table>
                
                <!-- Privacy Statement -->
                <p style="margin: 24px 0 0 0; font-size: 12px; line-height: 1.5; color: #999999; text-align: center; max-width: 600px;">
                    By providing a reference, you consent to Plyform collecting and using your information in accordance with our Privacy Policy.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>