<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        .invoice-container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            font-size: 24px;
            text-align: center;
            margin: 0;
            color: #333;
        }

        .company-info {
            text-align: center;
            margin-bottom: 20px;
        }

        .company-info p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        table th {
            background: #f4f4f9;
            font-weight: bold;
        }

        .invoice-summary {
            text-align: right;
            font-size: 14px;
        }

        .grand-total {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }

        .customer-invoice-table th,
        .customer-invoice-table td {
            font-size: 14px;
            text-align: 
        }

        .customer-invoice-table th {
            background: #e9f5ff;
            text-align: center;
        }

    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="company-info">
            <h1>Glaube</h1>
            <p>Email: info@glaube.com</p>
            <p>Phone: +1 234 567 890</p>
            <p>Address: 123 Main Street, City, Calicut</p>
        </div>

        <table class="customer-invoice-table">
            <thead>
                <tr>
                    <th colspan="2">Customer Details</th>
                    <th colspan="2">Invoice Details</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Name:</strong></td>
                    <td>{{ $data['customer']['name'] }}</td>
                    <td><strong>Invoice Number:</strong></td>
                    <td>{{ $data['invoice']['invoice_number'] }}</td>
                </tr>
                <tr>
                    <td><strong>Phone:</strong></td>
                    <td>{{ $data['customer']['phone'] }}</td>
                    <td><strong>Invoice Date:</strong></td>
                    <td>{{ $data['invoice']['invoice_date'] }}</td>
                </tr>
                <tr>
                    <td><strong>Address:</strong></td>
                    <td>{{ $data['customer']['address'] }}</td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <table>
            <thead>
                <tr>
                    <th>Service Name</th>
                    <th>Hours Used</th>
                    <th>Rate (per hour)</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['invoice_items'] as $item)
                <tr>
                    <td>{{ $item['service_name'] }}</td>
                    <td>{{ $item['hours_used'] }}</td>
                    <td>{{ $item['rate_per_hour'] }}</td>
                    <td>{{ $item['total'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="invoice-summary">
            <p>Invoice Amount: {{ $data['invoice']['sub_total'] }}</p>
            <p>VAT (5%): {{ $data['invoice']['tax_amount'] }}</p>
            <p>Discount: {{ $data['invoice']['total_discount'] ?? '0.00' }}</p>
            <p class="grand-total">Grand Total: {{ $data['invoice']['grand_total'] }}</p>
        </div>
    </div>
</body>

</html>
