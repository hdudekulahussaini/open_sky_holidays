<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enquiry Confirmation - Open Sky Holidays</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            margin: 0;
            padding: 20px;
        }
        .card {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        .header {
            background: #0f766e;
            color: #ffffff;
            padding: 20px 24px;
        }
        .header h2 {
            margin: 0;
            font-size: 20px;
        }
        .body {
            padding: 24px;
        }
        .summary {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 16px;
            margin: 15px 0;
            font-size: 14px;
        }
        .summary p {
            margin: 4px 0;
        }
        .footer {
            background: #f8fafc;
            padding: 14px 24px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h2>Thank You for Your Travel Enquiry!</h2>
        </div>
        <div class="body">
            <p>Dear {{ $enquiry->name }},</p>
            <p>We have received your enquiry for <strong>{{ $enquiry->destination }}</strong>. Our team is currently reviewing your details and will get in touch with you shortly.</p>
            
            <div class="summary">
                <p><strong>Destination:</strong> {{ $enquiry->destination }}</p>
                <p><strong>Travel Date:</strong> {{ \Carbon\Carbon::parse($enquiry->travel_date)->format('F d, Y') }}</p>
                <p><strong>Travelers:</strong> {{ $enquiry->travelers }} Person(s)</p>
                <p><strong>Tour Type:</strong> {{ $enquiry->tour_type }}</p>
            </div>

            <p>Best regards,<br><strong>Open Sky Holidays Team</strong></p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Open Sky Holidays
        </div>
    </div>
</body>
</html>
