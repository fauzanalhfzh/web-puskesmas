<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Storage;

class PendaftaranController extends Controller
{
    public function create()
    {
        $pasien = Auth::guard('pasien')->user();
        $polis = Poli::all();
        return view('pendaftaran.create', compact('pasien', 'polis'));
    }
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'pasien_id' => 'required',
            'poli_id' => 'required',
            'tanggal_kunjungan' => 'required|date',
            'jalur' => 'required',
        ]);

        $poli = Poli::findOrFail($request->poli_id);
        $nomor_antrian = null;
        $pendaftaran = null;

        // Gunakan transaksi untuk menghindari race condition
        DB::transaction(function () use ($request, $poli, &$nomor_antrian, &$pendaftaran) {
            // Ambil pendaftaran terakhir berdasarkan poli dan tanggal kunjungan
            $lastPendaftaran = Pendaftaran::where('poli_id', $poli->id)
                ->whereDate('tanggal_kunjungan', $request->tanggal_kunjungan)
                ->lockForUpdate() // Kunci data agar tidak bentrok saat banyak pendaftar
                ->orderBy('created_at', 'desc')
                ->first();

            if ($lastPendaftaran) {
                $lastNumber = (int) substr($lastPendaftaran->nomor_antrian, strrpos($lastPendaftaran->nomor_antrian, '-') + 1);
                $nextNumber = $lastNumber + 1;
            } else {
                $nextNumber = 1;
            }

            $kodePoli = strtoupper(preg_replace('/\s+/', '', $poli->nama_poli)); // Hilangkan spasi
            $nomor_antrian = $kodePoli . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // Simpan data pendaftaran
            $pendaftaran = Pendaftaran::create([
                'pasien_id' => $request->pasien_id,
                'poli_id' => $poli->id,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'jalur' => $request->jalur,
                'nomor_antrian' => $nomor_antrian,
            ]);
        });

        // Ambil data pasien untuk ditampilkan di tiket
        $pasien = $pendaftaran->pasien;

        // Buat HTML tiket dari view
        $html = view('pendaftaran.ticket', compact('pendaftaran', 'pasien', 'poli'))->render();

        // Buat PDF dengan mPDF
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        $pdfContent = $mpdf->Output('', 'S'); // Output sebagai string

        // Simpan file PDF ke storage/public/tickets
        $filename = 'tickets/ticket-' . $pendaftaran->id . '.pdf';
        Storage::disk('public')->put($filename, $pdfContent);

        return redirect()->back()
            ->with('success', 'Pendaftaran berhasil. Nomor Antrian Anda: ' . $nomor_antrian)
            ->with('pdf', 'storage/' . $filename);
    }
    // Berdasarkan Tanggal 
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'pasien_id' => 'required',
    //         'poli_id' => 'required',
    //         'tanggal_kunjungan' => 'required|date',
    //         'jalur' => 'required',
    //     ]);

    //     $poli = Poli::find($request->poli_id);
    //     $last = Pendaftaran::where('poli_id', $poli->id)
    //         ->whereDate('tanggal_kunjungan', $request->tanggal_kunjungan)
    //         ->count();

    //     $nomor_antrian = strtoupper($poli->nama_poli) . '-' . str_pad($last + 1, 3, '0', STR_PAD_LEFT);

    //     $pendaftaran = Pendaftaran::create([
    //         'pasien_id' => $request->pasien_id,
    //         'poli_id' => $request->poli_id,
    //         'tanggal_kunjungan' => $request->tanggal_kunjungan,
    //         'jalur' => $request->jalur,
    //         'nomor_antrian' => $nomor_antrian,
    //     ]);

    //     $pasien = $pendaftaran->pasien;
    //     $html = view('pendaftaran.ticket', compact('pendaftaran', 'pasien', 'poli'))->render();

    //     // Generate PDF dengan mPDF
    //     $mpdf = new Mpdf();
    //     $mpdf->WriteHTML($html);

    //     $pdfContent = $mpdf->Output('', 'S'); // Output as string

    //     // Simpan di storage/app/public/tickets/
    //     $filename = 'tickets/ticket-' . $pendaftaran->id . '.pdf';
    //     Storage::disk('public')->put($filename, $mpdf->Output('', 'S'));

    //     return redirect()->back()
    //         ->with('success', 'Pendaftaran berhasil. Nomor Antrian Anda: ' . $nomor_antrian)
    //         ->with('pdf', 'storage/' . $filename);
    // }
}
