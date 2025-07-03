<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Resep Masakan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #FFF8F0;
            color: #333;
            font-family: 'Poppins', sans-serif;
        }

        header h2 {
            font-family: 'Montserrat', sans-serif;
            color: #2C2C2C;
            font-size: 3rem;
            font-weight: bold;
        }

        header h4 {
            font-family: 'Poppins', sans-serif;
            color: #FF7F50;
            font-size: 2rem;
            margin-top: -10px;
        }

        .card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .card-body {
            padding: 30px;
        }

        .recipe-title {
            color: #2C2C2C;
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #FF7F50;
        }

        .recipe-content {
            font-size: 1rem;
            line-height: 1.7;
            white-space: pre-line;
        }

        .recipe-section {
            margin-bottom: 20px;
        }

        .recipe-section h5 {
            color: #FF7F50;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 1.2rem;
        }

        .ingredients-list, .steps-list {
            padding-left: 0;
        }

        .ingredients-list li, .steps-list li {
            margin-bottom: 5px;
            padding-left: 0;
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
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background-color: #ff5e2d;
            text-decoration: none;
            color: #fff;
            transform: translateY(-2px);
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #f5c6cb;
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
            @foreach ($recipes as $index => $recipe)
                @php
                    if (str_contains($recipe, '=== RESEP')) {
                        $parts = preg_split('/===\s*RESEP\s*\d+:\s*/', $recipe, 2);
                        $judul = 'Resep ' . ($index + 1);
                        $content = end($parts);
                        
                        if (preg_match('/^([^=\n]+)\s*===/', $content, $matches)) {
                            $judul = 'Resep ' . ($index + 1) . ': ' . trim($matches[1]);
                            $content = preg_replace('/^[^=\n]+\s*===\s*/', '', $content);
                        }
                    } else {
                        $lines = explode("\n", $recipe);
                        $judul = trim($lines[0]) ?: 'Resep ' . ($index + 1);
                        $content = implode("\n", array_slice($lines, 1));
                    }
                    
                    $content = trim($content);
                @endphp
                
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="recipe-title">{{ $judul }}</h3>
                        
                        @if(str_contains($content, 'Error:'))
                            <div class="error-message">
                                {{ $content }}
                            </div>
                        @else
                            <div class="recipe-content">{{ $content }}</div>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center">
                <div class="card">
                    <div class="card-body">
                        <p class="fs-4 mb-0">Maaf, resep tidak tersedia saat ini.</p>
                        <p class="text-muted">Silakan coba lagi atau periksa input Anda.</p>
                    </div>
                </div>
            </div>
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