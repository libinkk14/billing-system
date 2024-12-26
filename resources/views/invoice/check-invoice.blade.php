<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Check</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .card {
            border: none;
            border-radius: 10px;
        }

        .card-header {
            background: linear-gradient(45deg, #007bff, #0056b3);
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .card-header h4 {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container mt-5 d-flex justify-content-center">
        <div class="card shadow-lg" style="width: 100%; max-width: 500px;">
            <div class="card-header text-white text-center">
                <h4>Invoice Check</h4>
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
            <div class="card-body">
                <form id="invoiceCheckForm" method="POST" action="{{ route('check.invoice.post') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="invoiceNumber" class="form-label">Invoice Number</label>
                        <input type="text" class="form-control" id="invoiceNumber" name="invoiceNumber"
                            placeholder="Enter Invoice Number" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
