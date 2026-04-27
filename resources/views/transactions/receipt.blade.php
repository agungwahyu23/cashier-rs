<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #007bff;
        }
        .header p {
            margin: 5px 0 0;
            color: #777;
        }
        .info-section {
            margin-bottom: 30px;
        }
        .info-table {
            width: 100%;
        }
        .info-table td {
            padding: 5px 0;
        }
        .label {
            font-weight: bold;
            width: 120px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            text-align: left;
            padding: 10px;
            text-transform: uppercase;
            font-size: 10px;
            color: #666;
        }
        .table td {
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        .text-right {
            text-align: right;
        }
        .totals {
            width: 300px;
            margin-left: auto;
        }
        .total-row {
            padding: 10px 0;
        }
        .total-label {
            font-weight: bold;
        }
        .grand-total {
            background-color: #007bff;
            color: white;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-style: italic;
            color: #888;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            font-size: 10px;
        }
        .bg-success { background-color: #28a745; }
        .bg-danger { background-color: #dc3545; }
    </style>
</head>
<body>
    <div class="header">
        <h1>RS DELTA SURYA</h1>
        <p>Jl. Pahlawan No. 9, Sidoarjo | Telp: (031) 8961560</p>
        <p>BUKTI PEMBAYARAN TRANSAKSI</p>
    </div>

    <div class="info-section">
        <table class="info-table">
            <tr>
                <td class="label">No. Invoice</td>
                <td>: {{ $transaction->invoice_number }}</td>
                <td class="label">Tanggal</td>
                <td>: {{ $transaction->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td class="label">Asuransi</td>
                <td>: {{ $transaction->insurance->name ?? $transaction->insurance_name }}</td>
                <td class="label">Status</td>
                <td>: <span class="badge {{ $transaction->status == 'paid' ? 'bg-success' : 'bg-danger' }}">{{ strtoupper($transaction->status) }}</span></td>
            </tr>
        </table>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Tindakan Medis</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Potongan</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaction->details as $detail)
            <tr>
                <td>{{ $detail->procedure_name }}</td>
                <td class="text-right">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                <td class="text-right">{{ $detail->qty }}</td>
                <td class="text-right">Rp {{ number_format($detail->discount_per_item, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <div class="total-row">
            <span class="total-label">Subtotal :</span>
            <span style="float: right">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
        </div>
        <div class="total-row text-success" style="color: #28a745">
            <span class="total-label">Diskon Voucher :</span>
            <span style="float: right">- Rp {{ number_format($transaction->total_discount, 0, ',', '.') }}</span>
        </div>
        <div class="grand-total">
            <span>GRAND TOTAL</span>
            <span style="float: right">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="footer">
        <p>Terima kasih atas kepercayaan Anda kepada RS Delta Surya.</p>
        <p>Dokumen ini adalah bukti sah pembayaran elektronik.</p>
    </div>
</body>
</html>
