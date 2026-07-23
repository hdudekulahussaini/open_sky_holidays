<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Travel Enquiry Received</title>
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
        .note {
            background: #f8fafc;
            border-left: 4px solid #0284c7;
            padding: 14px;
            margin-top: 20px;
            font-size: 14px;
            border-radius: 4px;
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
            <h2>New Travel Enquiry Received</h2>
        </div>
        <div class="body">
            <p>Hello Admin,</p>
            <p>A new customer has submitted a travel enquiry:</p>
            <table class="table">
                <tr>
                    <td class="label">Name:</td>
                    <td class="val">{{ $enquiry->name }}</td>
                </tr>
                <tr>
                    <td class="label">Email:</td>
                    <td class="val"><a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a></td>
                </tr>
                <tr>
                    <td class="label">Phone:</td>
                    <td class="val">{{ $enquiry->phone }}</td>
                </tr>
                <tr>
                    <td class="label">Destination:</td>
                    <td class="val"><strong>{{ $enquiry->destination }}</strong></td>
                </tr>
                <tr>
                    <td class="label">Travel Date:</td>
                    <td class="val">{{ \Carbon\Carbon::parse($enquiry->travel_date)->format('F d, Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Travelers:</td>
                    <td class="val">{{ $enquiry->travelers }} Person(s)</td>
                </tr>
                <tr>
                    <td class="label">Tour Type:</td>
                    <td class="val">{{ $enquiry->tour_type }}</td>
                </tr>
            </table>

            @if($enquiry->message)
                <div class="note">
                    <strong>Message:</strong><br>
                    {{ $enquiry->message }}
                </div>
            @endif
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Open Sky Holidays
        </div>
    </div>
</body>
</html>
