<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OpenAIController extends Controller
{
    public function generate(Request $request)
    {
        // Ambil data dari form
        $bahan = $request->input('bahan');
        $bahanNon = $request->input('bahan_non');
        $alat = $request->input('alat');
        $alatNon = $request->input('alat_non');
        $jenisMasakan = $request->input('jenis_masakan');
        $gayaMasakan = $request->input('gaya_masakan');
        $waktu = $request->input('waktu');
        $porsi = $request->input('porsi');
        $sertakanGizi = $request->input('sertakan_gizi') === '1';

        // Proses bahan yang tidak disukai untuk mendeteksi kata "berlebih"
        $bahanNonProcessed = $this->processBahanNonDisukai($bahanNon);

        // Hitung faktor pengali untuk takaran
        $basePorsi = 4; // Asumsi resep standar untuk 4 porsi
        $multiplier = $porsi / $basePorsi;

        // Prompt yang lebih tegas dan konsisten
        $messageContent = "Buatkan 5 resep masakan lengkap berdasarkan data berikut:\n\n";
        $messageContent .= "Bahan tersedia: $bahan\n";
        $messageContent .= "Tidak suka/Hindari: $bahanNonProcessed\n";
        $messageContent .= "Alat tersedia: $alat\n";
        $messageContent .= "Alat tidak tersedia: $alatNon\n";
        $messageContent .= "Jenis masakan: $jenisMasakan\n";
        $messageContent .= "Gaya masakan: $gayaMasakan\n";
        $messageContent .= "Waktu: $waktu menit\n";
        $messageContent .= "Porsi: $porsi orang\n\n";
        
        $messageContent .= "INSTRUKSI WAJIB:\n";
        $messageContent .= "1. Abaikan SEMUA bahan berbahaya/beracun tanpa menyebutkannya\n";
        $messageContent .= "2. Buat resep menggunakan HANYA bahan yang aman\n";
        $messageContent .= "3. Tetap buat 5 resep lengkap meskipun ada bahan berbahaya asal bahan berbahaya tidak masuk ke resep\n";
        $messageContent .= "4. Buat resep TANPA harus menggunakan ALAT TIDAK TERSEDIA\n";
        $messageContent .= "5. Buat resep WAJIB MEMPERHATIKAN HAL YANG TIDAK DISUKA:\n";
        $messageContent .= "    - Jika ada '[bahan] berlebih' (contoh: minyak berlebih, santan berlebih), gunakan bahan tersebut SEMINIMAL MUNGKIN\n";
        $messageContent .= "    - Jika ada bahan tanpa kata 'berlebih', JANGAN gunakan bahan tersebut sama sekali\n";
        $messageContent .= "    - Prioritas: kurangi drastis penggunaan bahan yang disebutkan 'berlebih'\n";
        $messageContent .= "6. Buat resep WAJIB MEMAKSIMALKAN ALAT TERSEDIA\n";
        $messageContent .= "7. TIDAK BOLEH menulis penolakan atau peringatan\n";
        $messageContent .= "8. DILARANG membuat resep dengan bahan selain bahan makanan, contoh: aspal, semen, paku, sapu, dll\n";
        $messageContent .= "9. KHUSUS untuk bahan yang tidak disukai dengan kata 'berlebih': gunakan teknik memasak yang meminimalkan penggunaan bahan tersebut\n";
        
        // Instruksi yang lebih spesifik untuk takaran
        $messageContent .= "10. SANGAT PENTING - TAKARAN BAHAN HARUS SESUAI DENGAN JUMLAH PORSI ($porsi orang):\n";
        $messageContent .= "    - Jika resep standar untuk 4 orang, maka untuk $porsi orang harus dikalikan " . round($multiplier, 2) . "\n"; // angka 2 nya itu tu buat pembulatan desimal, biar ga kebanyakan kek 0.333333333 jadi 0.3
        $messageContent .= "    - Contoh: resep 4 orang butuh 500g daging, maka untuk $porsi orang butuh " . round(500 * $multiplier) . "g daging\n";
        $messageContent .= "    - Hitung dengan TEPAT setiap bahan sesuai proporsi porsi yang diminta\n";
        $messageContent .= "    - Jangan gunakan takaran standar, WAJIB disesuaikan dengan jumlah porsi\n\n";
        
        $messageContent .= "FORMAT WAJIB untuk setiap resep:\n";
        $messageContent .= "RESEP 1: [Nama Masakan] - $porsi Porsi\n";
        $messageContent .= "BAHAN:\n- [bahan + takaran yang sudah disesuaikan untuk $porsi porsi]\n- [bahan + takaran yang sudah disesuaikan untuk $porsi porsi]\n\n";
        $messageContent .= "CARA MEMASAK:\n1. [langkah detail]\n2. [langkah detail]\n3. [dst sampai selesai]\n\n";
        $messageContent .= "WAKTU MEMASAK: [estimasi waktu]\n\n";
        $messageContent .= "Ulangi format yang sama untuk RESEP 2, 3, 4, dan 5.";

        if ($sertakanGizi) {
            $messageContent .= "NILAI GIZI (untuk $porsi porsi):\n";
            $messageContent .= "- Kalori: [angka] kkal ([persen]%)\n";
            $messageContent .= "- Karbohidrat: [angka] g ([persen]%)\n";
            $messageContent .= "- Protein: [angka] g ([persen]%)\n";
            $messageContent .= "- Lemak: [angka] g ([persen]%)\n";
            $messageContent .= "- Serat: [angka] g ([persen]%)\n";
            $messageContent .= "- Gula: [angka] g ([persen]%)\n\n";
            
            $messageContent .= "11. INSTRUKSI NILAI GIZI (WAJIB JIKA DIMINTA):\n";
            $messageContent .= "    - HITUNG nilai gizi untuk TOTAL $porsi porsi (bukan per porsi)\n";
            $messageContent .= "    - TEMPATKAN bagian 'NILAI GIZI:' TEPAT SETELAH 'WAKTU MEMASAK:'\n";
            $messageContent .= "    - JANGAN taruh nilai gizi di tempat lain!\n";
            $messageContent .= "    - Persentase berdasarkan AKG dewasa: Kalori 2100kkal, Karbo 275g, Protein 60g, Lemak 67g, Serat 25g, Gula max 50g\n";
            $messageContent .= "    - Format angka: bulat tanpa desimal (contoh: 450 kkal, bukan 450.5 kkal)\n";
        } 
        
        // roleplay
        $systemMessage = "Anda adalah chef profesional yang SELALU membuat resep dengan takaran yang TEPAT sesuai jumlah porsi. ";
        $systemMessage .= "WAJIB hitung ulang setiap takaran bahan sesuai jumlah porsi yang diminta. ";
        $systemMessage .= "PENTING: Jika ada bahan yang tidak disukai dengan kata 'berlebih' (contoh: minyak berlebih, santan berlebih), ";
        $systemMessage .= "gunakan bahan tersebut dalam jumlah SANGAT MINIMAL atau cari alternatif teknik memasak yang tidak memerlukan bahan tersebut banyak. ";
        $systemMessage .= "Jangan gunakan takaran standar. Abaikan bahan berbahaya secara diam-diam tanpa menyebutkan penolakan. ";
        $systemMessage .= "Fokus pada bahan aman dan buat resep yang enak dengan takaran yang proporsional.";

        // Kirim request ke OpenAI
        $response = Http::timeout(60)->withHeaders([
            'Authorization' => 'Bearer ' . config('services.openai.key'),
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'system', 
                    'content' => $systemMessage
                ],
                ['role' => 'user', 'content' => $messageContent],
            ],
            'max_tokens' => 3000,
            'temperature' => 0.7,
        ]);

        $data = $response->json();

        if (isset($data['choices'][0]['message']['content'])) {
            $fullRecipe = $data['choices'][0]['message']['content'];
            
            $recipes = preg_split('/\bRESEP\s+\d+:/i', $fullRecipe, -1, PREG_SPLIT_NO_EMPTY);
            
            if (count($recipes) > 0 && trim($recipes[0]) === '') {
                array_shift($recipes);
            }
            
            $cleanRecipes = [];
            foreach ($recipes as $key => $recipe) {
                $recipe = trim($recipe);
                if (!empty($recipe) && strlen($recipe) > 30) {
                    $cleanRecipes[] = "RESEP " . ($key + 1) . ":\n" . $recipe;
                }
            }
            
            if (empty($cleanRecipes)) {
                $fallbackRecipes = preg_split('/\n\s*\n\s*\n/', $fullRecipe);
                foreach ($fallbackRecipes as $key => $recipe) {
                    $recipe = trim($recipe);
                    if (strlen($recipe) > 50) {
                        $cleanRecipes[] = "RESEP " . ($key + 1) . ":\n" . $recipe;
                    }
                }
            }
            
            $recipes = !empty($cleanRecipes) ? $cleanRecipes : ["RESEP LENGKAP:\n" . $fullRecipe];
            
        } else {
            $error = $data['error']['message'] ?? 'Unknown error';
            $recipes = ["Error: $error\n\nMohon coba lagi atau periksa API key Anda."];
        }

        return view('tampil_resep', compact('recipes'));
    }

    public function formInput()
    {
        return view('halaman_utama', );
    }

    private function processBahanNonDisukai($bahanNon)
    {
        if (empty($bahanNon)) {
            return $bahanNon;
        }

        // Deteksi kata "berlebih" dan berikan instruksi yang lebih spesifik
        $processed = $bahanNon;
        
        // Kata kunci yang menunjukkan "berlebih" atau "terlalu banyak"
        $berlebihKeywords = ['berlebih', 'terlalu banyak', 'berlebihan', 'kebanyakan', 'terlalu'];
        
        foreach ($berlebihKeywords as $keyword) {
            if (stripos($processed, $keyword) !== false) {
                // Ganti dengan instruksi yang lebih jelas
                $processed = str_ireplace($keyword, 'MINIMAL/SEDIKIT', $processed);
            }
        }

        // Tambahkan instruksi khusus untuk bahan yang sering berlebih
        $commonIngredients = [
            'minyak' => 'gunakan minyak seminimal mungkin (1-2 sdm max) atau gunakan teknik kukus/rebus/panggang/bakar',
            'santan' => 'gunakan santan encer atau ganti dengan susu low-fat, cooking creame, fiber creame',
            'gula' => 'gunakan pemanis alami minimal atau tanpa gula',
            'garam' => 'gunakan garam secukupnya (1/2 sdt max)',
            'mentega' => 'gunakan mentega tipis atau ganti dengan cooking spray'
        ];

        foreach ($commonIngredients as $ingredient => $instruction) {
            if (stripos($processed, $ingredient) !== false) {
                $processed .= "\n→ INSTRUKSI KHUSUS: " . $instruction;
            }
        }

        return $processed;
    }
}