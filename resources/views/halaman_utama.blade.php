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

        .form-control, .form-select {
            background-color: #ffffff;
            border: 2px solid #FFDAB9;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 16px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .form-control:focus, .form-select:focus {
            border-color: #FF7F50;
            box-shadow: 0 0 0 0.2rem rgba(255,127,80,0.25), 0 4px 15px rgba(255,127,80,0.1);
            transform: translateY(-2px);
            background-color: #ffffff;
        }

        .form-control:hover:not(:focus), {
            border-color: #FFB499;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .form-select:hover:not(:focus) {
            border-color: #FFB499;
            background-color: #FFF4EC;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(255,127,80,0.1);
        }

        .form-select option:hover {
            background-color: #FFE5D4; /* coral soft */
            color: #2C2C2C;
        }
        .form-select {
            background-color: #FFFEF9;
            border: 2px solid #FFDAB9;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 16px;
            color: #999;
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg fill='%23FF7F50' viewBox='0 0 140 140' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M70 90L20 40h100z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 14px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .form-select:focus {
            border-color: #FF7F50;
            box-shadow: 0 0 0 0.2rem rgba(255,127,80,0.2), 0 4px 15px rgba(255,127,80,0.1);
            color: #2C2C2C;
        }

        .form-select:not([value=""]) {
            color: #2C2C2C;
        }

        /* Styling untuk dropdown option list */
        .form-select option {
            background-color: #fffef9;
            color: #2C2C2C;
            padding: 10px;
            font-size: 15px;
            border-radius: 8px;
        }

        /* Placeholder-style option (yang disabled) */
        .form-select option[value=""] {
            color: #bbb;
            font-style: italic;
        }

        /* Custom Checkbox Styling */
        .checkbox-container {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .checkbox-container:hover {
            transform: translateY(-1px);
        }

        .custom-checkbox {
            position: relative;
            width: 20px;
            height: 20px;
            margin-right: 12px;
        }

        .custom-checkbox input[type="checkbox"] {
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
            position: absolute;
            z-index: 2;
        }

        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 20px;
            width: 20px;
            background-color: #ffffff;
            border: 2px solid #FFDAB9;
            border-radius: 6px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .custom-checkbox:hover .checkmark {
            border-color: #FFB499;
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(255,127,80,0.1);
        }

        .custom-checkbox input:checked ~ .checkmark {
            background-color: #FF7F50;
            border-color: #FF7F50;
            box-shadow: 0 0 0 0.2rem rgba(255,127,80,0.25);
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
            left: 6px;
            top: 2px;
            width: 6px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .custom-checkbox input:checked ~ .checkmark:after {
            display: block;
            animation: checkmark 0.3s ease-in-out;
        }

        @keyframes checkmark {
            0% {
                transform: rotate(45deg) scale(0);
            }
            50% {
                transform: rotate(45deg) scale(1.2);
            }
            100% {
                transform: rotate(45deg) scale(1);
            }
        }

        .checkbox-label {
            font-size: 16px;
            color: #333;
            font-weight: 500;
            user-select: none;
        }

        /* Success and Error States */
        .form-control.success, .form-select.success {
            border-color: #28a745;
            background: linear-gradient(135deg, #ffffff 0%, #f8fff8 100%);
        }
        .form-control.error, .form-select.error {
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
                    <input type="text" name="alat" id="alatInput" class="form-control" placeholder="Alat yang dimiliki" required>
                </div>
                <div class="input-group-animated">
                    <input type="text" name="alat_non" id="alatNonInput" class="form-control" placeholder="Alat yang tidak dimiliki">
                </div>
                <div class="input-group-animated">
                    <select name="jenis_masakan" class="form-select" required>
                        <option value="" disabled selected>Pilih jenis masakan</option>
                        <option value="Makanan Utama">Makanan Utama</option>
                        <option value="Makanan Penutup">Makanan Pembuka</option>
                        <option value="Camilan">Camilan</option>
                        <option value="Lauk">Lauk</option>
                        <option value="Makanan Pembuka">Makanan Pembuka</option>
                        <option value="Sup">Sup</option>
                        <option value="Salad">Salad</option>
                        <option value="Minuman">Minuman</option>
                        <option value="Sarapan">Sarapan</option>
                        <option value="Makanan Pendamping">Makanan Pendamping</option>
                    </select>
                </div>
                <div class="input-group-animated">
                    <select name="gaya_masakan" class="form-select" required>
                        <option value="" disabled selected>Pilih gaya masakan</option>
                        <option value="Indonesia">Indonesia</option>
                        <option value="Western">Western</option>
                        <option value="Chinese">Chinese</option>
                        <option value="Japanese">Japanese</option>
                        <option value="Korean">Korean</option>
                        <option value="Thai">Thai</option>
                        <option value="Indian">Indian</option>
                        <option value="Middle Eastern">Middle Eastern</option>
                        <option value="Mediterranean">Mediterranean</option>
                        <option value="Italian">Italian</option>
                        <option value="Mexican">Mexican</option>
                        <option value="French">French</option>
                        <option value="Asian Fusion">Asian Fusion</option>
                        <option value="Continental">Continental</option>
                    </select>
                </div>
                <div class="input-group-animated">
                    <input type="number" name="waktu" class="form-control" placeholder="Estimasi waktu memasak (menit)" min="1" required>
                </div>
                <div class="input-group-animated">
                    <input type="number" name="porsi" class="form-control" placeholder="Jumlah porsi" min="1" required>
                </div>
                <!-- Checkbox buat nilai gizi pake yang centang yak -->
                <div class="checkbox-container">
                    <label class="custom-checkbox">
                        <input type="checkbox" name="sertakan_gizi" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <span class="checkbox-label">Sertakan nilai gizi</span>
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
            const inputs = form.querySelectorAll('input[type="text"], input[type="number"], select');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = submitBtn.querySelector('.btn-text');
            const alatInput = document.getElementById('alatInput');
            const alatNonInput = document.getElementById('alatNonInput');
            let isSubmitting = false;

            // mastiin input angka cuma bisa angka doang, dan nolak karakter aneh atau salah ketik kayak huruf, simbol, atau angka plus Shift
            const numberInputs = form.querySelectorAll('input[type="number"]');
            numberInputs.forEach(input => {
                input.addEventListener('keypress', function(e) {
                    if ([46, 8, 9, 27, 13, 110, 190].indexOf(e.keyCode) !== -1 ||
                        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                        (e.keyCode >= 35 && e.keyCode <= 40)) {
                        return;
                    }
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });

                // buat cegah user paste selain nomor
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const paste = (e.clipboardData || window.clipboardData).getData('text');
                    if (/^\d+$/.test(paste)) {
                        this.value = paste;
                        this.dispatchEvent(new Event('input'));
                    }
                });

                // ini tu mstiin nilainya positif
                input.addEventListener('input', function() {
                    const value = parseInt(this.value);
                    const min = parseInt(this.getAttribute('min'));
                    
                    if (value < min) {
                        this.value = min;
                    }
                });
            });

            // filter buat input text yang cuma boleh huruf, spasi, dan koma
            const textOnlyInputs = form.querySelectorAll(
                'input[name="bahan"], input[name="bahan_non"], input[name="alat"], input[name="alat_non"]'
            );
            textOnlyInputs.forEach(input => {
                input.addEventListener('keypress', function(e) {
                    // izinin spasi, delete, dll
                    if ([8, 9, 13, 27, 37, 38, 39, 40, 46].indexOf(e.keyCode) !== -1 ||
                        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                        (e.keyCode >= 35 && e.keyCode <= 40)) {
                        return;
                    }

                    const char = String.fromCharCode(e.keyCode);
                    // cuma allow huruf (a-z, A-Z), spasi, dan koma
                    if (!/^[a-zA-Z\s,]$/.test(char)) {
                        e.preventDefault();
                    }
                });

                // filter paste buat cuma allow huruf, spasi, dan koma
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const paste = (e.clipboardData || window.clipboardData).getData('text');
                    // cuma allow huruf, spasi, dan koma
                    const filteredPaste = paste.replace(/[^a-zA-Z\s,]/g, '');
                    this.value = filteredPaste;
                    this.dispatchEvent(new Event('input'));
                });
            });

            // fungsi buat normalisasi text (lowercase, trim, hapus spasi berlebihan)
            function normalizeText(text) {
                return text.toLowerCase().trim().replace(/\s+/g, ' ');
            }

            // fungsi buat cek apakah ada overlap antara alat yang dimiliki dan tidak dimiliki
            function checkAlatOverlap() {
                const alatValue = normalizeText(alatInput.value);
                const alatNonValue = normalizeText(alatNonInput.value);
                
                if (alatValue === '' || alatNonValue === '') {
                    return false; // ga ada overlap kalo salah satu kosong
                }

                // split by comma dan normalize setiap item
                const alatItems = alatValue.split(',').map(item => normalizeText(item)).filter(item => item !== '');
                const alatNonItems = alatNonValue.split(',').map(item => normalizeText(item)).filter(item => item !== '');

                // cek apakah ada item yang sama
                for (let alatItem of alatItems) {
                    for (let alatNonItem of alatNonItems) {
                        if (alatItem === alatNonItem) {
                            return true; // ada overlap
                        }
                    }
                }
                return false; // ga ada overlap
            }

            function validateInputs() {
                let allValid = true;
                
                // cek overlap alat dulu
                const hasOverlap = checkAlatOverlap();
                if (hasOverlap) {
                    allValid = false;
                    alatNonInput.classList.remove('success');
                    alatNonInput.classList.add('error');
                } else if (alatNonInput.value.trim() !== '') {
                    alatNonInput.classList.remove('error');
                    alatNonInput.classList.add('success');
                } else {
                    alatNonInput.classList.remove('error', 'success');
                }

                // Update warna dropdown ketika berubah
            const selectInputs = form.querySelectorAll('select');
            selectInputs.forEach(select => {
                select.addEventListener('change', function() {
                    if (this.value !== '') {
                        this.style.color = '#333';
                    } else {
                        this.style.color = '#666';
                    }
                });
            });

            inputs.forEach(input => {
                    // skip alat_non karena udah dicek di atas
                    if (input.id === 'alatNonInput') return;
                    
                    const value = input.value.trim();
                    const isRequired = input.hasAttribute('required');
                    
                    if (isRequired && value === '') {
                        allValid = false;
                        input.classList.remove('success');
                        input.classList.add('error');
                    } else if (value !== '') {
                        // mastiin input angkanya valid
                        if (input.type === 'number') {
                            const numValue = parseInt(value);
                            const min = parseInt(input.getAttribute('min'));
                            
                            if (isNaN(numValue) || numValue < min) {
                                allValid = false;
                                input.classList.remove('success');
                                input.classList.add('error');
                            } else {
                                input.classList.remove('error');
                                input.classList.add('success');
                            }
                        } else {
                            input.classList.remove('error');
                            input.classList.add('success');
                        }
                    } else {
                        input.classList.remove('error', 'success');
                    }
                });
                return allValid;
            }

            submitBtn.disabled = true;

            // ini tu dipake buat nanganin input, jadi tiap user ketik atau ubah inputan bakal di cek ama kode ini
            // dia juga bakalan cek tombol submit uda bole aktif belom, kalo blom bakalan ada animasi bounce
            inputs.forEach(input => {
                input.addEventListener('input', () => {
                    const isValid = validateInputs();
                    submitBtn.disabled = !isValid || isSubmitting;
                    
                    if (isValid && !isSubmitting && submitBtn.disabled !== false) {
                        submitBtn.style.animation = 'bounce 0.6s ease';
                        setTimeout(() => {
                            submitBtn.style.animation = '';
                        }, 600);
                    }
                });

                //ini dipake buat yang dropdown itu, dia ubah nilai sblmnya ke nilai inputan
                input.addEventListener('change', () => {
                    const isValid = validateInputs();
                    submitBtn.disabled = !isValid || isSubmitting;
                    
                    if (isValid && !isSubmitting && submitBtn.disabled !== false) {
                        submitBtn.style.animation = 'bounce 0.6s ease';
                        setTimeout(() => {
                            submitBtn.style.animation = '';
                        }, 600);
                    }
                });

                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-2px)';
                });

                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                });
            });

            form.addEventListener('submit', function (e) {
                const hasOverlap = checkAlatOverlap();
                
                if (hasOverlap) {
                    e.preventDefault();
                    
                    form.style.animation = 'shake 0.5s ease-in-out';
                    setTimeout(() => {
                        form.style.animation = '';
                    }, 500);
                    
                    showCustomAlert('Alat yang tidak dimiliki tidak boleh sama dengan alat yang dimiliki!');
                    return;
                }

                if (!validateInputs()) {
                    e.preventDefault();
                    
                    form.style.animation = 'shake 0.5s ease-in-out';
                    setTimeout(() => {
                        form.style.animation = '';
                    }, 500);
                    
                    showCustomAlert('Harap isi semua kolom yang diperlukan dengan benar!');
                    return;
                }

                if (isSubmitting) {
                    e.preventDefault();
                    return;
                }

                isSubmitting = true;
                submitBtn.disabled = true;
                
                btnText.innerHTML = '<span class="loading"></span>Mencari resep...';
                submitBtn.style.background = '#cccccc';
            });

            function showCustomAlert(message) {
                const alertDiv = document.createElement('div');
                alertDiv.className = 'custom-alert';
                alertDiv.textContent = message;
                document.body.appendChild(alertDiv);

                setTimeout(() => {
                    alertDiv.classList.add('show');
                }, 10);

                setTimeout(() => {
                    alertDiv.classList.remove('show');
                    setTimeout(() => {
                        if (document.body.contains(alertDiv)) {
                            document.body.removeChild(alertDiv);
                        }
                    }, 300);
                }, 3000);
            }

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