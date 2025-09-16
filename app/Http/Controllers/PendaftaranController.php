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
        $pendaftaran = Pendaftaran::all();
        return view('pendaftaran.create', compact('pasien', 'polis', 'pendaftaran'));
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

        // Cek jika jalur BPJS, pastikan hanya sekali per hari
        if ($request->jalur === 'bpjs') {
            $cekBPJS = Pendaftaran::where('pasien_id', $request->pasien_id)
                ->whereDate('tanggal_kunjungan', $request->tanggal_kunjungan)
                ->where('jalur', 'bpjs')
                ->exists();

            if ($cekBPJS) {
                return redirect()->back()
                    ->with('error', 'Pendaftaran BPJS hanya bisa dilakukan satu kali dalam sehari.');
            }
        }

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


        // Hitung umur berdasarkan tanggal lahir pasien
        $umur = \Carbon\Carbon::parse($pasien->tanggal_lahir)->age;

        // Buat HTML tiket dari view
        $html = view('pendaftaran.ticket', compact('pendaftaran', 'pasien', 'poli', 'umur'))->render();

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
}
