<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $request->validate([
            'pasien_id' => 'required',
            'poli_id' => 'required',
            'tanggal_kunjungan' => 'required|date',
            'jalur' => 'required',
        ]);

        $poli = Poli::find($request->poli_id);
        $last = Pendaftaran::where('poli_id', $poli->id)
            ->whereDate('tanggal_kunjungan', $request->tanggal_kunjungan)
            ->count();

        $nomor_antrian = strtoupper($poli->nama_poli) . '-' . str_pad($last + 1, 3, '0', STR_PAD_LEFT);

        $pendaftaran = Pendaftaran::create([
            'pasien_id' => $request->pasien_id,
            'poli_id' => $request->poli_id,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'jalur' => $request->jalur,
            'nomor_antrian' => $nomor_antrian,
        ]);

        $pasien = $pendaftaran->pasien;
        $html = view('pendaftaran.ticket', compact('pendaftaran', 'pasien', 'poli'))->render();

        // Generate PDF dengan mPDF
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        $pdfContent = $mpdf->Output('', 'S'); // Output as string

        // Simpan di storage/app/public/tickets/
        $filename = 'tickets/ticket-' . $pendaftaran->id . '.pdf';
        Storage::disk('public')->put($filename, $mpdf->Output('', 'S'));

        return redirect()->back()
            ->with('success', 'Pendaftaran berhasil. Nomor Antrian Anda: ' . $nomor_antrian)
            ->with('pdf', 'storage/' . $filename);
    }
}
