<?php

namespace App\Filament\Resources\PasienResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Pasien;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JumlahPasienChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        // Ambil data pasien, kelompokkan berdasarkan bulan
        $pasienPerBulan = Pasien::selectRaw('MONTH(created_at) as bulan, COUNT(*) as jumlah')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('jumlah', 'bulan');

        // Buat array 12 bulan default
        $data = [];
        $labels = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = Carbon::create()->month($i)->format('M');
            $data[] = $pasienPerBulan[$i] ?? 0; // jika tidak ada data, isi 0
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pasien',
                    'data' => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    public function getColumnSpan(): int|string
    {
        return 'full'; // atau bisa juga pakai 12
    }


    protected function getMaxHeight(): string
    {
        return '400px';
    }
}
