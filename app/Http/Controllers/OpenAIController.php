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

        // Hitung faktor pengali untuk takaran
        $basePorsi = 4; // Asumsi resep standar untuk 4 porsi
        $multiplier = $porsi / $basePorsi;

        // Prompt yang lebih tegas dan konsisten
        $messageContent = "Buatkan 5 resep masakan lengkap berdasarkan data berikut:\n\n";
        $messageContent .= "Bahan tersedia: $bahan\n";
        $messageContent .= "Tidak suka: $bahanNon\n";
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
        $messageContent .= "5. Buat resep WAJIB MEMPERHATIKAN HAL YANG TIDAK DISUKA, DILARANG GUNAKAN baham makanan pada hal yang tidak disuka\n";
        $messageContent .= "6. Buat resep WAJIB MEMAKSIMALKAN ALAT TERSEDIA\n";
        $messageContent .= "7. TIDAK BOLEH menulis penolakan atau peringatan\n";
        $messageContent .= "8. DILARANG membuat resep dengan bahan selain bahan makanan, contoh: aspal, semen, paku, sapu, dll\n";
        $messageContent .= "9. Perhatikan takaran bahan setiap resep dalam kasus tertentu yang disertakan pada HAL YANG TIDAK DISUKAI\n";
        
        // Instruksi yang lebih spesifik untuk takaran
        $messageContent .= "10. SANGAT PENTING - TAKARAN BAHAN HARUS SESUAI DENGAN JUMLAH PORSI ($porsi orang):\n";
        $messageContent .= "    - Jika resep standar untuk 4 orang, maka untuk $porsi orang harus dikalikan " . round($multiplier, 2) . "\n";
        $messageContent .= "    - Contoh: resep 4 orang butuh 500g daging, maka untuk $porsi orang butuh " . round(500 * $multiplier) . "g daging\n";
        $messageContent .= "    - Hitung dengan TEPAT setiap bahan sesuai proporsi porsi yang diminta\n";
        $messageContent .= "    - Jangan gunakan takaran standar, WAJIB disesuaikan dengan jumlah porsi\n\n";
        
        $messageContent .= "FORMAT WAJIB untuk setiap resep:\n";
        $messageContent .= "RESEP 1: [Nama Masakan] - $porsi Porsi\n";
        $messageContent .= "BAHAN:\n- [bahan + takaran yang sudah disesuaikan untuk $porsi porsi]\n- [bahan + takaran yang sudah disesuaikan untuk $porsi porsi]\n\n";
        $messageContent .= "CARA MEMASAK:\n1. [langkah detail]\n2. [langkah detail]\n3. [dst sampai selesai]\n\n";
        $messageContent .= "WAKTU MEMASAK: [estimasi waktu]\n\n";
        $messageContent .= "Ulangi format yang sama untuk RESEP 2, 3, 4, dan 5.";

        // System message yang lebih tegas
        $systemMessage = "Anda adalah chef profesional yang SELALU membuat resep dengan takaran yang TEPAT sesuai jumlah porsi. ";
        $systemMessage .= "WAJIB hitung ulang setiap takaran bahan sesuai jumlah porsi yang diminta. ";
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
        return view('halaman_utama');
    }
}