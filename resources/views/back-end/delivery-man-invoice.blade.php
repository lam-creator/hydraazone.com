<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice For Delivery Man</title>

    <style>
        body {
            font-family: monospace;
            background: #f5f5f5;
            margin: 0;
            padding: 10px;
        }

        .invoice {
            width: 100%;
            max-width: 302px;
            margin: auto;
            background: #fff;
            padding: 10px;
        }

        .center { text-align: center; }
        .logo { font-weight: bold; font-size: 18px; }
        .small { font-size: 11px; color: #000000; }

        .divider {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th, td { padding: 4px 0; border: 1px solid #000000 !important; }

        th { border: 1px solid #000000 !important; }

        td:nth-child(2),
        td:nth-child(3),
        td:nth-child(4),
        th:nth-child(2),
        th:nth-child(3),
        th:nth-child(4) {
            text-align: right;
        }

        .total { font-weight: bold; }

        .footer {
            text-align: center;
            font-size: 11px;
            margin-top: 10px;
        }

        .print-btn {
            width: 100%;
            margin-bottom: 10px;
            padding: 6px;
            cursor: pointer;
        }

        @media print {
            .print-btn { display: none; }
            body { background: #fff; padding: 0; }
        }
    </style>
</head>

<body>

<div class="invoice">

    <button onclick="window.print()" class="print-btn">Print</button>

    @php
    $WebsiteData = App\Models\WebsiteSettings::first();
    @endphp


    {{-- HEADER --}}
    <div class="center">
        <div class="logo">{{ $WebsiteData->company_name }}</div>
        <div class="small">ESTD 2026</div>
    </div>

    <div class="divider"></div>

    <div class="small center">
        {{ $WebsiteData->company_address }}
    </div>

    <div class="divider"></div>

    {{-- ORDER INFO --}}
    <div class="row">
        <span>Invoice:</span>
        <span>#{{ $order->id }}</span>
    </div>

    <div class="row">
        <span>Date:</span>
        <span>{{ \Carbon\Carbon::parse($order->date)->format('d M Y') }}</span>
    </div>

    <div class="row">
        <span>Zone:</span>
        <span>{{ $order->city->name ?? '' }}</span>
    </div>

    <div class="divider"></div>

    {{-- CUSTOMER --}}
    <div class="small">
        <strong>Customer:</strong> {{ $order->name ?? 'N/A' }}<br>
        <strong>Mobile:</strong> {{ $order->mobile ?? 'N/A' }}<br>
        <strong>Address:</strong> {{ $order->address ?? 'N/A' }}<br>
        <strong>Note:</strong> {{ $order->order_note ?? 'N/A' }}
    </div>

    <div class="divider"></div>

    {{-- ITEMS --}}
    <table>
        <thead>
        <tr>
            <th class="border: 1px solid #000000 !important;">Item</th>
            <th class="border: 1px solid #000000 !important;">Qty</th>
            <th class="border: 1px solid #000000 !important;">Rate</th>
            <th class="border: 1px solid #000000 !important;">Total</th>
        </tr>
        </thead>
        <tbody>
        @php $subtotal = 0; @endphp

        @foreach($order->items as $item)
            @php
                $lineTotal = $item->quantity * $item->price;
                $subtotal += $lineTotal;
            @endphp
            <tr>
                <td class="border: 1px solid #000000 !important;">{{ $item->product->name ?? '' }}</td>
                <td class="border: 1px solid #000000 !important;">{{ $item->quantity }}</td>
                <td class="border: 1px solid #000000 !important;">{{ $item->price }}</td>
                <td class="border: 1px solid #000000 !important;">{{ $lineTotal }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="divider"></div>

    {{-- TOTALS --}}
    <div class="row total">
        <span>Subtotal</span>
        <span>{{ number_format($subtotal, 2) }}</span>
    </div>

    <div class="row">
        <span>Delivery</span>
        <span>{{ number_format($order->shipping, 2) }}</span>
    </div>

    <div class="row">
        <span>Discount</span>
        <span>(-) {{ number_format($order->discount_amount, 2) }}</span>
    </div>

    <div class="divider"></div>

    <div class="row total">
        <span>Total</span>
        <span>
            {{ number_format($order->total_amount, 2) }}
        </span>
    </div>

    <div class="divider"></div>

    {{-- FOOTER --}}
    <div class="footer">
        Thank you for choosing {{ $WebsiteData->company_name }}<br>
        This is a computer-generated invoice.<br>
        Please check products at delivery.<br><br>
        Support: {{ $WebsiteData->support_phone }}
    </div>

</div>

</body>
</html>
