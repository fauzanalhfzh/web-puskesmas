<?php

namespace Database\Seeders;

use App\Models\Poli;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $poliList = [
            'Poli Umum',
            'Poli Gigi',
            'Poli KIA',
            'Poli Lansia',
            'Poli MTBS',
            'Poli Gizi',
            'Poli TB',
            'Poli Vaksinasi',
        ];

        foreach ($poliList as $namaPoli) {
            Poli::create([
                'nama_poli' => $namaPoli,
            ]);
        }
    }
}
