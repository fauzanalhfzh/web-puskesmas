<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua poli dan hitung jumlah pendaftar masing-masing
        $poliCounts = Poli::withCount('pendaftaran')->get();

        return view('welcome', compact('poliCounts'));
    }
}
