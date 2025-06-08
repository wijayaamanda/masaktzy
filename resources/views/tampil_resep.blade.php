<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Resep Masakan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Caveat&family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <style>
        body {
            background-color: #FFF8F0;
            color: #333;
            font-family: 'Poppins', sans-serif;
        }

        header h2 {
            font-family: 'Ubuntu', cursive;
            color: #2C2C2C;
            font-size: 3rem;
            font-weight: bold;
        }

        header h4 {
            font-family: 'Ubuntu', cursive;
            color: #FF7F50;
            font-size: 2rem;
            margin-top: -10px;
        }

        .card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 20px;
            font-size: 1.1rem;
            white-space: pre-wrap;
            line-height: 1.6;
        }

        footer {
            background-color: #2C2C2C;
            color: white;
            padding-top: 30px;
            padding-bottom: 20px;
        }

        footer .fw-bold {
            color: #fff;
        }

        .btn-back {
            background-color: #FF7F50;
            color: #fff;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }

        .btn-back:hover {
            background-color: #ff5e2d;
            text-decoration: none;
            color: #fff;
        }

        * {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <header class="text-center py-5">
        <h2>Resep Masakan yang Dihasilkan</h2>
        <h4>Berikut adalah resep yang dapat kamu coba!</h4>
    </header>

    <main class="container mb-5">
        @if(isset($recipes) && count($recipes) > 0)
            @foreach ($recipes as $recipe)
                @php
                    $parts = explode("\n", $recipe, 2);
                    $judul = $parts[0] ?? 'Judul Resep';
                    $isi = $parts[1] ?? '';
                @endphp
                <div class="card mb-4">
                    <div class="card-body">
                        <h3>{{ $judul }}</h3>
                        <pre>{{ $isi }}</pre>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-center fs-4">Maaf, resep tidak tersedia.</p>
        @endif

        <div class="text-center">
            <a href="{{ route('form_input') }}" class="btn-back">Kembali ke Halaman Utama</a>
        </div>
    </main>

    <footer class="mt-auto py-4">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div><strong>MASAKTZY</strong></div>
            <div class="d-flex flex-column flex-md-row gap-3 text-left">
                <div>
                    <p class="fw-bold">MASAKTZY</p>
                    <p>Amanda Ayu Titising Wijaya</p>
                    <p>Universitas Atma Jaya Yogyakarta</p>
                </div>
                <div>
                    <p class="fw-bold">Made With</p>
                    <p>OpenAI</p>
                    <p>Laravel</p>
                </div>
                <div>
                    <p class="fw-bold">ABOUT</p>
                    <p>Terms & Conditions</p>
                    <p>Privacy Policy</p>
                </div>
            </div>
        </div>
        <div class="text-center mt-3">
            <small>Copyright © 2025 MASAKTZY.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
