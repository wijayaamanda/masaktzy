<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MASAKTZY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Caveat&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #FFF8F0;
            color: #333;
            font-family: 'Poppins', sans-serif;
        }

        header h2, header h4 {
            font-family: 'Ubuntu', cursive;
            color: #2C2C2C;
        }

        header h2 {
            font-size: 3rem;
            font-weight: bold;
        }

        header h4 {
            font-size: 2rem;
            margin-top: -10px;
        }

        img {
            max-width: 180px;
        }

        .form-control {
            background-color: #ffffff;
            border: 2px solid #FFDAB9;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 16px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .form-control:focus {
            border-color: #FF7F50;
            box-shadow: 0 0 0 0.2rem rgba(255,127,80,0.25);
        }

        .btn-primary {
            background-color: #FF7F50;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 16px;
        }

        .btn-primary:hover {
            background-color: #ff5e2d;
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
        *{
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Header -->
    <header class="text-center py-5">
        <h2>BINGUNG MAU MASAK APA HARI INI?</h2>
        <h4>MASAKTZY SOLUSINYA</h4>
        <div class="mb-4">
            <img src="{{ asset('img/maskot.png') }}" alt="Maskot Masaktzy" class="img-fluid" width="200">
        </div>
    </header>

    <!-- Form Section -->
    <div class="container mb-5">
        <form action="/generate" method="POST" class="mx-auto" style="max-width: 600px;">
            @csrf
            <div class="mb-3">
                <input type="text" name="bahan" class="form-control" placeholder="Bahan yang dimiliki">
            </div>
            <div class="mb-3">
                <input type="text" name="bahan_non" class="form-control" placeholder="Bahan yang tidak disukai">
            </div>
            <div class="mb-3">
                <input type="text" name="alat" class="form-control" placeholder="Alat yang dimiliki">
            </div>
            <div class="mb-3">
                <input type="text" name="alat_non" class="form-control" placeholder="Alat yang tidak dimiliki">
            </div>
            <div class="mb-3">
                <input type="text" name="jenis_masakan" class="form-control" placeholder="Jenis Masakan">
            </div>
            <div class="mb-3">
                <input type="text" name="gaya_masakan" class="form-control" placeholder="Gaya masakan (Indonesia / Western / Chinese / dll)">
            </div>
            <div class="mb-3">
                <input type="text" name="waktu" class="form-control" placeholder="Estimasi waktu memasak (menit)">
            </div>
            <div class="mb-3">
                <input type="text" name="porsi" class="form-control" placeholder="Jumlah porsi">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Cari rekomendasi resep</button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer class="mt-auto py-4">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div><strong>Fakultas Teknologi Informasi - Informatika</strong></div>
            <div class="d-flex flex-column flex-md-row gap-3 text-left">
                <div>
                    <p class="fw-bold">MASAKTZY</p>
                    <p>Amanda Ayu Titising Wijaya</p>
                    <p>210711486</p>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input[type="text"]');
            const submitBtn = form.querySelector('button[type="submit"]');

            // Fungsi cek semua input terisi
            function validateInputs() {
            for (let input of inputs) {
                if (input.value.trim() === '') {
                return false;
                }
            }
            return true;
            }

            // Set tombol disable saat awal
            submitBtn.disabled = true;

            // Cek setiap kali user input
            inputs.forEach(input => {
            input.addEventListener('input', () => {
                submitBtn.disabled = !validateInputs();
            });
            });

            // Cek sebelum submit, kalau ada yang kosong munculkan alert dan cegah submit
            form.addEventListener('submit', function (e) {
            if (!validateInputs()) {
                e.preventDefault();
                alert('Harap isi semua kolom sebelum mengirim formulir!');
            }
            });
        });
    </script>
</body>
</html>
