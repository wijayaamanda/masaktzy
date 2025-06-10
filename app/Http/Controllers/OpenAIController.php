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

        // Rangkai prompt buat OpenAI
        $messageContent = "Buatkan 5 resep masakan berdasarkan data berikut tanpa kalimat pembuka atau penutup. Jangan pernah menggunakan bahan yang beracun, ilegal, mengandung racun alami, atau yang secara medis dilarang dikonsumsi manusia. Jika pengguna memasukkan bahan seperti itu, abaikan bahan tersebut dan jangan masukkan ke resep. Setiap resep wajib menyertakan bahan yang akan digunakan termasuk bumbu\n";
        $messageContent .= "Bahan yang dimiliki: $bahan\n";
        $messageContent .= "Bahan yang tidak disukai: $bahanNon\n";
        $messageContent .= "Alat yang dimiliki: $alat\n";
        $messageContent .= "Alat yang tidak dimiliki: $alatNon\n";
        $messageContent .= "Jenis masakan: $jenisMasakan\n";
        $messageContent .= "Gaya masakan: $gayaMasakan\n";
        $messageContent .= "Estimasi waktu memasak: $waktu menit\n";
        $messageContent .= "Jumlah porsi: $porsi\n";
        $messageContent .= "Tuliskan dengan format seperti membuat buku resep dengan penomoran Resep 1:, Resep 2:, dst.";

        // Kirim request ke OpenAI
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.openai.key'),
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'Kamu adalah asisten chef pintar yang dapat membuat resep berdasarkan input dari pengguna.'],
                ['role' => 'user', 'content' => $messageContent],
            ],
        ]);

        // Ambil hasil dari OpenAI
        $data = $response->json();

        if (isset($data['choices'][0]['message']['content'])) {
            $fullRecipe = $data['choices'][0]['message']['content'];

            // Pecah resep berdasarkan "Resep X:"
            $recipes = preg_split('/\n?Resep\s*\d+:/i', $fullRecipe, -1, PREG_SPLIT_NO_EMPTY);

            // Bersihkan spasi kosong
            $recipes = array_map('trim', $recipes);

            // Tambah kembali label Resep 1:, Resep 2: dst agar jelas
            foreach ($recipes as $key => &$rec) {
                $rec = "Resep " . ($key + 1) . ":\n" . $rec;
            }
        } else {
            $recipes = ['Maaf, terjadi kesalahan dalam membuat resep.'];
        }

        return view('tampil_resep', compact('recipes'));
    }

    public function formInput()
    {
        return view('halaman_utama');
    }
}
