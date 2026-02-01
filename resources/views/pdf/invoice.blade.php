<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
            color: #333;
        }

        .header {
            width: 100%;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #f9ce34;
            text-transform: uppercase;
        }

        /* Brand Color */
        .company-info {
            float: right;
            text-align: right;
            font-size: 12px;
            color: #666;
        }

        .invoice-details {
            margin-bottom: 30px;
            width: 100%;
        }

        .invoice-details td {
            vertical-align: top;
            width: 33%;
        }

        .title {
            font-size: 11px;
            font-weight: bold;
            color: #999;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table.items th {
            background: #f8f8f8;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
        }

        table.items td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .totals {
            width: 40%;
            float: right;
        }

        .totals table {
            width: 100%;
            border-collapse: collapse;
        }

        .totals td {
            padding: 5px;
        }

        .totals .final {
            font-size: 16px;
            font-weight: bold;
            color: #000;
            border-top: 2px solid #eee;
            padding-top: 10px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 12px;
            color: #aaa;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            color: white;
        }

        .bg-green {
            background-color: #22c55e;
        }

        .bg-yellow {
            background-color: #eab308;
        }

        .bg-gray {
            background-color: #64748b;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="logo">RC GO</div>
        <div class="company-info">
            <strong>RC GO Indonesia</strong><br>
            Jl. Raya RC No. 123<br>
            Jakarta, Indonesia 12345<br>
            support@rcgo.id
        </div>
        <div style="clear: both;"></div>
    </div>

    <table class="invoice-details">
        <tr>
            <td>
                <div class="title">Billed To</div>
                <strong>{{ $order->user->name }}</strong><br>
                {{ $order->user->email }}<br>
                {{ $order->user->phone ?? '-' }}
            </td>
            <td>
                <div class="title">Shipped To</div>
                @php
                    $note = $order->note;
                    $address = $note;
                    if (preg_match('/Alamat: (.*)/', $note, $match))
                        $address = $match[1];
                @endphp
                {{ $address }}
            </td>
            <td class="text-right">
                <div class="title">Invoice Number</div>
                <strong>INV-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</strong><br>
                <br>
                <div class="title">Invoice Date</div>
                {{ $order->created_at->format('d M Y') }}<br>
                <br>
                <div class="title">Status</div>
                @if($order->status == 'paid' || $order->status == 'processing' || $order->status == 'shipped' || $order->status == 'completed')
                    <span class="badge bg-green">PAID</span>
                @else
                    <span class="badge bg-yellow">{{ strtoupper($order->status) }}</span>
                @endif
            </td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th width="50%">Item Description</th>
                <th width="15%" class="text-center">Qty</th>
                <th width="15%" class="text-right">Price</th>
                <th width="20%" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
                <tr>
                    <td>
                        @if($item->package)
                            <strong>{{ $item->package->name }}</strong><br>
                            <span style="color: #666; font-size: 12px;">Package Item</span>
                        @elseif($item->addon)
                            <strong>{{ $item->addon->name }}</strong><br>
                            <span style="color: #666; font-size: 12px;">Add-on Item</span>
                        @else
                            Unknown Item
                        @endif
                    </td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td>Subtotal</td>
                <td class="text-right">Rp
                    {{ number_format($order->orderItems->sum(fn($i) => $i->price * $i->quantity), 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Shipping Cost</td>
                <td class="text-right">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="final">Total</td>
                <td class="text-right final">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <div style="clear: both;"></div>

    <div style="margin-top: 40px; border-top: 1px solid #eee; padding-top: 20px;">
        <div class="title">Payment Method</div>
        <div>
            @if($order->payment_channel)
                {{ $order->payment_channel }}
                ({{ $order->status == 'paid' || $order->status == 'completed' ? 'Paid' : 'Pending' }})
            @else
                Manual Transfer / Other
            @endif
        </div>
    </div>

    <div class="footer">
        Thank you for your business!<br>
        Generate on {{ now()->format('d M Y H:i') }}
    </div>

</body>

</html>