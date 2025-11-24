<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Agency Registration</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #8B5CF6, #7C3AED); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
        .button { display: inline-block; padding: 12px 30px; background: #8B5CF6; color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .info-table { width: 100%; background: white; border-radius: 8px; overflow: hidden; margin: 20px 0; }
        .info-table td { padding: 12px; border-bottom: 1px solid #e5e5e5; }
        .info-table td:first-child { font-weight: bold; width: 40%; background: #f3f4f6; }
        .alert-box { background: #FEF3C7; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #F59E0B; }
        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔔 New Agency Registration</h1>
            <p style="margin: 10px 0 0 0;">Action Required</p>
        </div>
        <div class="content">
            <h2>New Agency Awaiting Approval</h2>
            
            <div class="alert-box">
                <strong>⚠️ Pending Review:</strong> A new agency has registered and is awaiting approval.
            </div>
            
            <table class="info-table">
                <tr>
                    <td>Agency Name</td>
                    <td>{{ $agency->agency_name }}</td>
                </tr>
                <tr>
                    <td>Trading Name</td>
                    <td>{{ $agency->trading_name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>ABN</td>
                    <td>{{ $agency->abn }}</td>
                </tr>
                <tr>
                    <td>ACN</td>
                    <td>{{ $agency->acn ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Business Type</td>
                    <td>{{ ucwords(str_replace('_', ' ', $agency->business_type)) }}</td>
                </tr>
                <tr>
                    <td>License Number</td>
                    <td>{{ $agency->license_number }}</td>
                </tr>
                <tr>
                    <td>License Holder</td>
                    <td>{{ $agency->license_holder_name }}</td>
                </tr>
                <tr>
                    <td>State</td>
                    <td>{{ $agency->state }}</td>
                </tr>
                <tr>
                    <td>Business Email</td>
                    <td>{{ $agency->business_email }}</td>
                </tr>
                <tr>
                    <td>Business Phone</td>
                    <td>{{ $agency->business_phone }}</td>
                </tr>
                <tr>
                    <td>Website</td>
                    <td>{{ $agency->website_url ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Registered At</td>
                    <td>{{ $agency->created_at->format('d M Y, h:i A') }}</td>
                </tr>
            </table>
            
            <h3>Required Actions:</h3>
            <ol>
                <li>Verify the ABN and license number</li>
                <li>Check the business registration details</li>
                <li>Review compliance documentation (when uploaded)</li>
                <li>Approve or reject the registration</li>
            </ol>
            
            <a href="{{ config('app.url') }}/admin/agencies/{{ $agency->id }}" class="button">Review Agency Registration</a>
            
            <p style="margin-top: 20px; font-size: 12px; color: #666;">
                <strong>Quick Actions:</strong><br>
                Approve: {{ config('app.url') }}/admin/agencies/{{ $agency->id }}/approve<br>
                View Details: {{ config('app.url') }}/admin/agencies/{{ $agency->id }}
            </p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Sorted Admin Panel</p>
            <p>This is an automated notification for admin users only.</p>
        </div>
    </div>
</body>
</html>