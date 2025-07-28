<?php

namespace App\Filament\Resources\PendaftaranResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Poli;

class PendaftaranStatsOverview extends BaseWidget
{
   protected function getStats(): array
    {
        // Ambil semua data poli dan hitung jumlah pasien di tiap poli
        $poliStats = Poli::withCount('pendaftaran')->get();

        $stats = [];

        foreach ($poliStats as $poli) {
            $stats[] = Stat::make("Pasien di Poli {$poli->nama_poli}", number_format($poli->pendaftaran_count));
        }

        return $stats;
    }
}
