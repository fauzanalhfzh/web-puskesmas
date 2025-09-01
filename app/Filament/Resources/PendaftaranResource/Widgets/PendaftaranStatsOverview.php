<?php

namespace App\Filament\Resources\PendaftaranResource\Widgets;

use App\Models\Pendaftaran;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Poli;

class PendaftaranStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Ambil semua data poli dan hitung jumlah pasien di tiap poli
        $poliStats = Poli::withCount('pendaftaran')->get();

        // Ambil jumlah pasien PBJS dan Umum
        $pbjsCount = Pendaftaran::where('jalur', 'BPJS')->count();
        $umumCount = Pendaftaran::where('jalur', 'Umum')->count();


        $stats = [];

        // Menambahkan statistik untuk pasien PBJS dan Umum
        $stats[] = Stat::make("Pasien BPJS", number_format($pbjsCount));
        $stats[] = Stat::make("Pasien Umum", number_format($umumCount));


        foreach ($poliStats as $poli) {
            $stats[] = Stat::make("Pasien di Poli {$poli->nama_poli}", number_format($poli->pendaftaran_count));
        }

        return $stats;
    }
}
