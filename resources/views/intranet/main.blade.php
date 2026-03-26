@extends("intranet.intranet")

@section("title", "dashboard")

@section("content")

    <div class="container my-5">
        <h1 class="text-center mb-4">KRD Fichtenried Intranet</h1>
        <p class="text-center mb-5 text-muted">Wählen Sie eine der Optionen, um auf ein spezifisches Dashboard zuzugreifen.</p>



    </div>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
        }

        .card {
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .card-title {
            color: #1d72b8;
        }

        .btn-primary {
            background-color: #1d72b8;
            border: none;
            border-radius: 25px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #155a8a;
            transform: translateY(-2px);
        }

        .card-body {
            padding: 30px;
        }

        .container {
            max-width: 1200px;
        }

        .row {
            margin-top: 50px;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .text-center h1 {
            font-size: 2.5rem;
            font-weight: bold;
        }
    </style>

@endsection
