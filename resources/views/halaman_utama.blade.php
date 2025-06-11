<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MASAKTZY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #FFF8F0;
            color: #333;
            font-family: 'Poppins', sans-serif;
        }

        header h2, header h4 {
            font-family: 'Montserrat', sans-serif;
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

        /* Enhanced Form Styles */
        .form-container {
            background: #FFFEF9;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 30px rgba(255, 127, 80, 0.1);
            border: 1px solid rgba(255, 218, 185, 0.3);
        }

        .input-group-animated {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-control {
            background-color: #ffffff;
            border: 2px solid #FFDAB9;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 16px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .form-control:focus {
            border-color: #FF7F50;
            box-shadow: 0 0 0 0.2rem rgba(255,127,80,0.25), 0 4px 15px rgba(255,127,80,0.1);
            transform: translateY(-2px);
            background-color: #ffffff;
        }

        .form-control:hover:not(:focus) {
            border-color: #FFB499;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        /* Success and Error States */
        .form-control.success {
            border-color: #28a745;
            background: linear-gradient(135deg, #ffffff 0%, #f8fff8 100%);
        }

        .form-control.error {
            border-color: #dc3545;
            background: linear-gradient(135deg, #ffffff 0%, #fff8f8 100%);
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-3px); }
            20%, 40%, 60%, 80% { transform: translateX(3px); }
        }

        .btn-primary {
            background-color: #FF7F50;
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            background-color: #ff5e2d;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 127, 80, 0.3);
        }

        .btn-primary:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-primary:disabled:hover {
            background-color: #cccccc;
            transform: none;
            box-shadow: none;
        }

        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
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

        * {
            transition: all 0.3s ease;
        }

        /* Custom Alert Styles */
        .custom-alert {
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
            z-index: 9999;
            font-weight: 500;
            transform: translateX(100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .custom-alert.show {
            transform: translateX(0);
        }

        /* Form Animation on Load */
        .form-container {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Input Focus Ring Animation */
        .input-group-animated::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border: 2px solid #FF7F50;
            border-radius: 12px;
            opacity: 0;
            transform: scale(0.95);
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .input-group-animated:focus-within::after {
            opacity: 0.3;
            transform: scale(1.02);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .form-container {
                margin: 1rem;
                padding: 1.5rem;
            }
            
            header h2 {
                font-size: 2.5rem;
            }
            
            header h4 {
                font-size: 1.5rem;
            }
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
        <div class="form-container mx-auto" style="max-width: 600px;">
            <form action="/generate" method="POST" id="recipeForm">
                @csrf
                <div class="input-group-animated">
                    <input type="text" name="bahan" class="form-control" placeholder="Bahan yang dimiliki" required>
                </div>
                <div class="input-group-animated">
                    <input type="text" name="bahan_non" class="form-control" placeholder="Hal yang tidak disukai atau dihindari">
                </div>
                <div class="input-group-animated">
                    <input type="text" name="alat" class="form-control" placeholder="Alat yang dimiliki" required>
                </div>
                <div class="input-group-animated">
                    <input type="text" name="alat_non" class="form-control" placeholder="Alat yang tidak dimiliki">
                </div>
                <div class="input-group-animated">
                    <input type="text" name="jenis_masakan" class="form-control" placeholder="Jenis Masakan (Dessert / Camilan / Main Course / Lauk / dll)" required>
                </div>
                <div class="input-group-animated">
                    <input type="text" name="gaya_masakan" class="form-control" placeholder="Gaya masakan (Indonesia / Western / Chinese / dll)" required>
                </div>
                <div class="input-group-animated">
                    <input type="text" name="waktu" class="form-control" placeholder="Estimasi waktu memasak (menit)" required>
                </div>
                <div class="input-group-animated">
                    <input type="text" name="porsi" class="form-control" placeholder="Jumlah porsi" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <span class="btn-text">Cari rekomendasi resep</span>
                    </button>
                </div>
            </form>
        </div>
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
            const form = document.getElementById('recipeForm');
            const inputs = form.querySelectorAll('input[type="text"]');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = submitBtn.querySelector('.btn-text');
            let isSubmitting = false;

            // Enhanced validation function with visual feedback
            function validateInputs() {
                let allValid = true;
                inputs.forEach(input => {
                    const value = input.value.trim();
                    const isRequired = input.hasAttribute('required');
                    
                    if (isRequired && value === '') {
                        allValid = false;
                        input.classList.remove('success');
                        input.classList.add('error');
                    } else if (value !== '') {
                        input.classList.remove('error');
                        input.classList.add('success');
                    } else {
                        input.classList.remove('error', 'success');
                    }
                });
                return allValid;
            }

            // Set initial button state
            submitBtn.disabled = true;

            // Real-time validation with animations
            inputs.forEach(input => {
                input.addEventListener('input', () => {
                    const isValid = validateInputs();
                    submitBtn.disabled = !isValid || isSubmitting;
                    
                    // Add subtle bounce animation when button becomes enabled
                    if (isValid && !isSubmitting && submitBtn.disabled !== false) {
                        submitBtn.style.animation = 'bounce 0.6s ease';
                        setTimeout(() => {
                            submitBtn.style.animation = '';
                        }, 600);
                    }
                });

                // Enhanced focus effects
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-2px)';
                });

                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                });
            });

            // Enhanced form submission
            form.addEventListener('submit', function (e) {
                if (!validateInputs()) {
                    e.preventDefault();
                    
                    // Show shake animation for form
                    form.style.animation = 'shake 0.5s ease-in-out';
                    setTimeout(() => {
                        form.style.animation = '';
                    }, 500);
                    
                    showCustomAlert('Harap isi semua kolom yang diperlukan!');
                    return;
                }

                // Prevent double submission
                if (isSubmitting) {
                    e.preventDefault();
                    return;
                }

                isSubmitting = true;
                submitBtn.disabled = true;
                
                // Show loading state with animation
                btnText.innerHTML = '<span class="loading"></span>Mencari resep...';
                submitBtn.style.background = '#cccccc';
            });

            // Custom alert function
            function showCustomAlert(message) {
                const alertDiv = document.createElement('div');
                alertDiv.className = 'custom-alert';
                alertDiv.textContent = message;
                document.body.appendChild(alertDiv);

                // Animate in
                setTimeout(() => {
                    alertDiv.classList.add('show');
                }, 10);

                // Animate out and remove
                setTimeout(() => {
                    alertDiv.classList.remove('show');
                    setTimeout(() => {
                        if (document.body.contains(alertDiv)) {
                            document.body.removeChild(alertDiv);
                        }
                    }, 300);
                }, 3000);
            }

            // Add bounce animation keyframes
            const style = document.createElement('style');
            style.textContent = `
                @keyframes bounce {
                    0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
                    40% { transform: translateY(-5px); }
                    60% { transform: translateY(-3px); }
                }
            `;
            document.head.appendChild(style);
        });
    </script>
</body>
</html>