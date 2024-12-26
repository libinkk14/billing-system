<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        h2 {
            color: #343a40;
            font-weight: 700;
            text-shadow: 2px 2px 3px rgba(0, 0, 0, 0.1);
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 10px;
        }

        .form-label {
            font-weight: bold;
            color: #495057;
        }

        .btn-primary {
            background: linear-gradient(to right, #007bff, #0056b3);
            border: none;
            color: #fff;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #0056b3, #003d80);
        }

        .btn-danger {
            background: linear-gradient(to right, #dc3545, #a71d2a);
            border: none;
            color: #fff;
        }

        .btn-danger:hover {
            background: linear-gradient(to right, #a71d2a, #70171f);
        }

        .table {
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f3f5;
        }

        #serviceTable th {
            background-color: #343a40;
            color: #fff;
        }

        #serviceTable tbody td input {
            background-color: #f8f9fa;
        }

        .form-check-label {
            color: #495057;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-center ">Glaube Billing Page</h2>
            <div class="d-flex justify-content-end align-items-center mb-4">
                <a href="{{ route('check.invoice') }}" class="btn btn-info me-3"><i class="fa fa-search"></i> Check Invoice</a>
                <a href="{{ route('create.service') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Service</a>
            </div>            
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
                <a href="{{ session('invoice_link') }}" class="btn btn-link" target="_blank">Download Invoice</a>
            </div>
        @endif
        <form method="POST" action="{{ route('store.invoice') }}">
            @csrf
            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="customerName" class="form-label">Customer Name</label>
                    <input type="text" id="customerName" name="customer_name" class="form-control"
                        placeholder="Enter Customer Name">
                </div>
                <div class="col-md-6">
                    <label for="invoiceDate" class="form-label">Invoice Date</label>
                    <input type="date" id="invoiceDate" name="invoice_date" class="form-control"
                        value="{{ $today }}">
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="customer_number" class="form-label">Customer Number</label>
                    <input type="text" id="customer_number" name="customer_phone" class="form-control"
                        placeholder="Enter Customer Number" >
                </div>
                <div class="col-md-6">
                    <label for="customerAddress" class="form-label">Customer Address</label>
                    <input type="text" id="customerAddress" name="customer_address" class="form-control"
                        placeholder="Enter Customer Address">
                </div>
            </div>
            <div class="mb-3">
                <label for="additionalNotes" class="form-label">Additional Notes</label>
                <textarea id="additionalNotes" name="additional_notes" class="form-control" rows="3"
                    placeholder="Enter any additional notes"></textarea>
            </div>

            <div class="mb-3">
                <div class="service-header mb-3 d-flex justify-content-between align-items-center">
                    <h4>Service Details</h4>
                    <button type="button" id="addRow" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                </div>
                <table class="table table-bordered" id="serviceTable">
                    <thead>
                        <tr>
                            <th>Select Service</th>
                            <th>Price</th>
                            <th>Hours</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="service[]" id="service" class="form-control service-select">
                                    <option value="">Select service</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}" data-price="{{ $service->hourly_rate }}">
                                            {{ $service->service_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="number" class="form-control price" name="price[]" placeholder="Price"
                                    min="0"></td>
                            <td><input type="number" class="form-control hours" name="hours[]" placeholder="Hours"
                                    min="0"></td>
                            <td><input type="text" class="form-control total" name="total[]" placeholder="Total"
                                    readonly></td>
                            <td><button type="button" class="btn btn-danger removeRow"><i
                                        class="fa fa-trash"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mb-3 row">
                <div class="col-md-4">
                    <label for="invoiceAmount" class="form-label">Invoice Amount</label>
                    <input type="text" id="invoiceAmount" name="invoice_amount" class="form-control" readonly>
                </div>
                <div class="col-md-4">
                    <label for="discountAmount" class="form-label">Discount Amount</label>
                    <input type="number" id="discountAmount" name="total_discount" class="form-control"
                        min="0">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Enable VAT (5%)</label>
                    <div class="form-check">
                        <input type="checkbox" id="enableVat" name="enable_vat" class="form-check-input">
                        <label for="enableVat" class="form-check-label">Enable</label>
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-md-4">
                    <label for="totalVat" class="form-label">Total VAT</label>
                    <input type="text" id="totalVat" name="total_vat" class="form-control" readonly>
                </div>
                <div class="col-md-4">
                    <label for="totalHours" class="form-label">Total Hours</label>
                    <input type="text" id="totalHours" name="total_hours" class="form-control" readonly>
                </div>
                <div class="col-md-4">
                    <label for="grandTotal" class="form-label">Grand Total</label>
                    <input type="text" id="grandTotal" name="grand_total" class="form-control" readonly>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Save</button>
            <button type="button" class="btn btn-secondary">Cancel</button>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#addRow').click(function() {
                let newRow = `<tr>
            <td>
                <select name="service[]" class="form-control service-select">
                    <option value="">Select service</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}" data-price="{{ $service->hourly_rate }}">
                            {{ $service->service_name }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" class="form-control price" name="price[]" placeholder="Price" min="0" ></td>
            <td><input type="number" class="form-control hours" name="hours[]" placeholder="Hours" min="0"></td>
            <td><input type="text" class="form-control total" name="total[]" placeholder="Total" readonly></td>
            <td><button type="button" class="btn btn-danger removeRow"><i class="fa fa-trash"></i></button></td>
        </tr>`;
                $('#serviceTable tbody').append(newRow);
            });

            $(document).on('change', '.service-select', function() {
                let price = $(this).find('option:selected').data('price');
                let row = $(this).closest('tr');
                row.find('.price').val(price || 0);
                calculateRowTotal(row);
                calculateInvoice();
            });

            $(document).on('input', '.hours', function() {
                let row = $(this).closest('tr');
                calculateRowTotal(row);
                calculateInvoice();
            });

            $('#discountAmount, #enableVat').on('input change', calculateInvoice);

            function calculateRowTotal(row) {
                let price = parseFloat(row.find('.price').val()) || 0;
                let hours = parseFloat(row.find('.hours').val()) || 0;
                row.find('.total').val((price * hours).toFixed(2));
            }

            function calculateInvoice() {
                let invoiceAmount = 0;
                let totalHours = 0; 
                $('.total').each(function() {
                    invoiceAmount += parseFloat($(this).val()) || 0;
                });
                $('.hours').each(function() {
                    totalHours += parseFloat($(this).val()) || 0;
                });

                let discount = parseFloat($('#discountAmount').val()) || 0;
                let enableVat = $('#enableVat').is(':checked');
                let vat = enableVat ? invoiceAmount * 0.05 : 0;

                $('#invoiceAmount').val(invoiceAmount.toFixed(2));
                $('#totalVat').val(vat.toFixed(2));
                $('#grandTotal').val((invoiceAmount - discount + vat).toFixed(2));
                $('#totalHours').val(totalHours.toFixed(2));
            }

            $(document).on('click', '.removeRow', function() {
                $(this).closest('tr').remove();
                calculateInvoice(); 
            });
        });
    </script>
</body>

</html>
