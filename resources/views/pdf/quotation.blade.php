<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quotation {{ $quotation->quotation_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 3px solid #10b981; padding-bottom: 20px; }
        .header h1 { color: #10b981; margin: 0; font-size: 32px; }
        .header p { margin: 5px 0; color: #666; }
        .info-section { display: table; width: 100%; margin-bottom: 30px; }
        .info-left, .info-right { display: table-cell; width: 50%; vertical-align: top; }
        .info-right { text-align: right; }
        .info-box { background: #f0fdf4; padding: 15px; border-radius: 5px; margin-bottom: 10px; }
        .info-box h3 { margin: 0 0 10px 0; color: #10b981; font-size: 14px; }
        .info-box p { margin: 3px 0; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th { background: #10b981; color: white; padding: 12px; text-align: left; }
        td { padding: 10px; border-bottom: 1px solid #e5e7eb; }
        .text-right { text-align: right; }
        .totals { margin-top: 20px; }
        .totals table { width: 300px; float: right; }
        .totals td { border: none; padding: 8px; }
        .totals .grand-total { background: #10b981; color: white; font-weight: bold; font-size: 16px; }
        .footer { margin-top: 50px; padding-top: 20px; border-top: 2px solid #e5e7eb; text-align: center; color: #666; }
        .package-badge { display: inline-block; padding: 5px 15px; border-radius: 20px; font-weight: bold; font-size: 14px; background: #10b981; color: white; }
        .validity { background: #fef3c7; padding: 10px; border-radius: 5px; margin: 20px 0; text-align: center; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>QUOTATION</h1>
            <p>{{ $quotation->quotation_number }}</p>
            <span class="package-badge">{{ strtoupper($quotation->package_type) }} PACKAGE</span>
        </div>

        <div class="info-section">
            <div class="info-left">
                <div class="info-box">
                    <h3>FROM:</h3>
                    <p><strong>Web Development Agency</strong></p>
                    <p>Jl. Example No. 123, Jakarta</p>
                    <p>Phone: 081234567890</p>
                    <p>Email: contact@webagency.com</p>
                </div>
            </div>
            <div class="info-right">
                <div class="info-box">
                    <h3>TO:</h3>
                    <p><strong>{{ $client->name }}</strong></p>
                    <p>{{ $client->company }}</p>
                    <p>{{ $client->address }}</p>
                    <p>Phone: {{ $client->phone }}</p>
                    <p>Email: {{ $client->email }}</p>
                </div>
            </div>
        </div>

        @if($quotation->valid_until)
        <div class="validity">
            This quotation is valid until: {{ $quotation->valid_until->format('d F Y') }}
        </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-right">Quantity</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $item['description'] }}</td>
                    <td class="text-right">{{ $item['quantity'] }}</td>
                    <td class="text-right">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item['quantity'] * $item['price'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <table>
                <tr>
                    <td>Subtotal:</td>
                    <td class="text-right">Rp {{ number_format($quotation->subtotal, 0, ',', '.') }}</td>
                </tr>
                @if($quotation->discount > 0)
                <tr>
                    <td>Discount:</td>
                    <td class="text-right">- Rp {{ number_format($quotation->discount, 0, ',', '.') }}</td>
                </tr>
                @endif
                @if($quotation->tax > 0)
                <tr>
                    <td>Tax:</td>
                    <td class="text-right">Rp {{ number_format($quotation->tax, 0, ',', '.') }}</td>
                </tr>
                @endif
                <tr class="grand-total">
                    <td>TOTAL:</td>
                    <td class="text-right">Rp {{ number_format($quotation->total, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        @if($quotation->notes)
        <div style="clear: both; margin-top: 30px;">
            <h3>Terms & Conditions:</h3>
            <p>{{ $quotation->notes }}</p>
        </div>
        @endif

        <div style="clear: both; margin-top: 30px; background: #f9fafb; padding: 20px; border-radius: 5px;">
            <h3>Payment Terms:</h3>
            <ul>
                <li>50% down payment upon agreement</li>
                <li>50% final payment upon project completion</li>
                <li>Payment can be made via bank transfer</li>
            </ul>
        </div>

        <div class="footer">
            <p><strong>Bank Information:</strong></p>
            <p>Bank: BCA | Account Number: 1234567890 | Account Name: Web Development Agency</p>
            <p style="margin-top: 20px;">We look forward to working with you!</p>
        </div>
    </div>
</body>
</html>