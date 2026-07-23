<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Tour Booking Inquiry Received</title>
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
            background: #0284c7;
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
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .table td {
            padding: 10px 12px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }
        .label {
            font-weight: 600;
            color: #64748b;
            width: 35%;
        }
        .val {
            color: #0f172a;
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
            <h2>New Tour Booking Inquiry Received</h2>
        </div>
        <div class="body">
            <p>Hello Admin,</p>
            <p>A new customer has submitted a tour booking inquiry:</p>
            <table class="table">
                <tr>
                    <td class="label">Tour Package:</td>
                    <td class="val"><strong>{{ $tourInquiry->tour?->title ?? 'N/A' }}</strong></td>
                </tr>
                <tr>
                    <td class="label">Customer Name:</td>
                    <td class="val">{{ $tourInquiry->name }}</td>
                </tr>
                <tr>
                    <td class="label">Email Address:</td>
                    <td class="val"><a href="mailto:{{ $tourInquiry->email }}">{{ $tourInquiry->email }}</a></td>
                </tr>
                <tr>
                    <td class="label">Phone Number:</td>
                    <td class="val">{{ $tourInquiry->phone }}</td>
                </tr>
                <tr>
                    <td class="label">Travel Date:</td>
                    <td class="val">{{ \Carbon\Carbon::parse($tourInquiry->travel_date)->format('F d, Y') }}</td>
                </tr>
                <tr>
                    <td class="label">No. of Travelers:</td>
                    <td class="val">{{ $tourInquiry->travelers }} {{ Str::plural('Person', $tourInquiry->travelers) }}</td>
                </tr>
            </table>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Open Sky Holidays. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
