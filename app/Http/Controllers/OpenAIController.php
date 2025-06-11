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

        // Prompt yang lebih tegas dan konsisten
        $messageContent = "Buatkan 5 resep masakan lengkap berdasarkan data berikut:\n\n";
        $messageContent .= "Bahan tersedia: $bahan\n";
        $messageContent .= "Tidak suka: $bahanNon\n";
        $messageContent .= "Alat tersedia: $alat\n";
        $messageContent .= "Alat tidak ada: $alatNon\n";
        $messageContent .= "Jenis masakan: $jenisMasakan\n";
        $messageContent .= "Gaya masakan: $gayaMasakan\n";
        $messageContent .= "Waktu: $waktu menit\n";
        $messageContent .= "Porsi: $porsi\n\n";
        
        $messageContent .= "INSTRUKSI WAJIB:\n";
        $messageContent .= "1. Abaikan SEMUA bahan berbahaya/beracun tanpa menyebutkannya\n";
        $messageContent .= "2. Buat resep menggunakan HANYA bahan yang aman\n";
        $messageContent .= "3. Tetap buat 5 resep lengkap meskipun ada bahan berbahaya asal bahan berbahaya tidak masuk ke resep\n";
        $messageContent .= "4. TIDAK BOLEH menulis penolakan atau peringatan\n\n";
        
        $messageContent .= "FORMAT WAJIB untuk setiap resep:\n";
        $messageContent .= "RESEP 1: [Nama Masakan]\n";
        $messageContent .= "BAHAN:\n- [bahan + takaran]\n- [bahan + takaran]\n\n";
        $messageContent .= "CARA MEMASAK:\n1. [langkah detail]\n2. [langkah detail]\n3. [dst sampai selesai]\n\n";
        $messageContent .= "WAKTU MEMASAK: [estimasi waktu]\n\n";
        $messageContent .= "Ulangi format yang sama untuk RESEP 2, 3, 4, dan 5.";

        // Kirim request ke OpenAI
        $response = Http::timeout(60)->withHeaders([
            'Authorization' => 'Bearer ' . config('services.openai.key'),
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'system', 
                    'content' => 'Anda adalah chef yang SELALU membuat resep lengkap. Abaikan bahan berbahaya secara diam-diam tanpa menyebutkan penolakan. Fokus pada bahan aman dan buat resep yang enak.'
                ],
                ['role' => 'user', 'content' => $messageContent],
            ],
            'max_tokens' => 3000, // Naikin token limit
            'temperature' => 0.7,
        ]);

        // Handle response dengan parsing yang lebih sederhana
        $data = $response->json();

        if (isset($data['choices'][0]['message']['content'])) {
            $fullRecipe = $data['choices'][0]['message']['content'];
            
            // Parsing lebih simpel - split berdasarkan "RESEP X:"
            $recipes = preg_split('/\bRESEP\s+\d+:/i', $fullRecipe, -1, PREG_SPLIT_NO_EMPTY);
            
            // Bersihkan array pertama yang biasanya kosong
            if (count($recipes) > 0 && trim($recipes[0]) === '') {
                array_shift($recipes);
            }
            
            // Clean up dan kasih nomor ulang
            $cleanRecipes = [];
            foreach ($recipes as $key => $recipe) {
                $recipe = trim($recipe);
                if (!empty($recipe) && strlen($recipe) > 30) {
                    // Tambah nomor resep di depan
                    $cleanRecipes[] = "RESEP " . ($key + 1) . ":\n" . $recipe;
                }
            }
            
            // Fallback kalau parsing gagal
            if (empty($cleanRecipes)) {
                // Coba split berdasarkan line breaks yang banyak
                $fallbackRecipes = preg_split('/\n\s*\n\s*\n/', $fullRecipe);
                foreach ($fallbackRecipes as $key => $recipe) {
                    $recipe = trim($recipe);
                    if (strlen($recipe) > 50) {
                        $cleanRecipes[] = "RESEP " . ($key + 1) . ":\n" . $recipe;
                    }
                }
            }
            
            // Final fallback - kasih full response
            $recipes = !empty($cleanRecipes) ? $cleanRecipes : ["RESEP LENGKAP:\n" . $fullRecipe];
            
        } else {
            // Error handling
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