<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 3px solid #3b82f6; padding-bottom: 20px; }
        .header h1 { color: #3b82f6; margin: 0; font-size: 32px; }
        .header p { margin: 5px 0; color: #666; }
        .info-section { display: table; width: 100%; margin-bottom: 30px; }
        .info-left, .info-right { display: table-cell; width: 50%; vertical-align: top; }
        .info-right { text-align: right; }
        .info-box { background: #f9fafb; padding: 15px; border-radius: 5px; margin-bottom: 10px; }
        .info-box h3 { margin: 0 0 10px 0; color: #3b82f6; font-size: 14px; }
        .info-box p { margin: 3px 0; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th { background: #3b82f6; color: white; padding: 12px; text-align: left; }
        td { padding: 10px; border-bottom: 1px solid #e5e7eb; }
        .text-right { text-align: right; }
        .totals { margin-top: 20px; }
        .totals table { width: 300px; float: right; }
        .totals td { border: none; padding: 8px; }
        .totals .grand-total { background: #3b82f6; color: white; font-weight: bold; font-size: 16px; }
        .footer { margin-top: 50px; padding-top: 20px; border-top: 2px solid #e5e7eb; text-align: center; color: #666; }
        .status-badge { display: inline-block; padding: 5px 15px; border-radius: 20px; font-weight: bold; font-size: 14px; }
        .status-paid { background: #10b981; color: white; }
        .status-unpaid { background: #f59e0b; color: white; }
        .status-partial { background: #3b82f6; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>INVOICE</h1>
            <p>{{ $invoice->invoice_number }}</p>
            <span class="status-badge status-{{ $invoice->status }}">
                {{ strtoupper($invoice->status) }}
            </span>
        </div>

        <div class="info-section">
            <div class="info-left">
                <div class="info-box">
                    <h3>DARI:</h3>
                    <p><strong>EMPATECH ID</strong></p>
                    <p>Jl. Banyusari, Karawang, Jawa Barat</p>
                    <p>Phone: 085814108224</p>
                    <p>Email: contact@empatech.id</p>
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

        <div class="info-section">
            <div class="info-left">
                <p><strong>Project:</strong> {{ $project->name }}</p>
                <p><strong>Project Code:</strong> {{ $project->code }}</p>
            </div>
            <div class="info-right">
                <p><strong>Tanggal Terbit:</strong> {{ $invoice->issue_date->format('d M Y') }}</p>
                <p><strong>Tanggal Jatuh Tempo:</strong> {{ $invoice->due_date->format('d M Y') }}</p>
                @if($invoice->paid_date)
                <p><strong>Tanggal Pembayaran:</strong> {{ $invoice->paid_date->format('d M Y') }}</p>
                @endif
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th class="text-right">Kuantitas</th>
                    <th class="text-right">Harga</th>
                    <th class="text-right">Jumlah</th>
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
                    <td class="text-right">Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</td>
                </tr>
                @if($invoice->discount > 0)
                <tr>
                    <td>Discount:</td>
                    <td class="text-right">- Rp {{ number_format($invoice->discount, 0, ',', '.') }}</td>
                </tr>
                @endif
                @if($invoice->tax > 0)
                <tr>
                    <td>Pajak:</td>
                    <td class="text-right">Rp {{ number_format($invoice->tax, 0, ',', '.') }}</td>
                </tr>
                @endif
                <tr class="grand-total">
                    <td>TOTAL:</td>
                    <td class="text-right">Rp {{ number_format($invoice->total, 0, ',', '.') }}</td>
                </tr>
                @if($invoice->paid_amount > 0)
                <tr>
                    <td>Jumlah yang Dibayar:</td>
                    <td class="text-right">Rp {{ number_format($invoice->paid_amount, 0, ',', '.') }}</td>
                </tr>
                <tr style="font-weight: bold; color: #ef4444;">
                    <td>Tersisa:</td>
                    <td class="text-right">Rp {{ number_format($invoice->remaining_amount, 0, ',', '.') }}</td>
                </tr>
                @endif
            </table>
        </div>

        @if($invoice->notes)
        <div style="clear: both; margin-top: 30px;">
            <h3>Catatan:</h3>
            <p>{{ $invoice->notes }}</p>
        </div>
        @endif

        <div class="footer">
            <p><strong>Informasi Pembayaran:</strong></p>
            <p>Bank: BRI | No Rekening: 410601014154504 | Atas Nama: Pian Permana</p>
            <p style="margin-top: 20px;">Thank you for your business!</p>
        </div>
    </div>
</body>
</html>