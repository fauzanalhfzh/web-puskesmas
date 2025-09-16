@extends('layouts.app')

@section('content')
{{-- Notifikasi sukses --}}
@if (session('success'))
<div class="bg-green-100 text-green-800 p-4 rounded mb-4">
    {{ session('success') }}
    @if (session('pdf'))
    <br>
    <a href="{{ asset(session('pdf')) }}" target="_blank" class="text-blue-600 underline">Download Tiket Antrian
        PDF</a>
    @endif
</div>
@endif

{{-- Notifikasi error --}}
@if (session('error'))
<div class="bg-red-100 text-red-800 p-4 rounded mb-4">
    {{ session('error') }}
</div>
@endif

@auth('pasien')
<section id="pendaftaran" class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Form Pendaftaran Antrian Online</h2>
                <p class="text-gray-600 mt-2">Isi data di bawah ini untuk mendapatkan nomor antrian. Anda akan
                    menerima konfirmasi melalui WhatsApp.</p>
            </div>
            <form action="{{ route('pendaftaran.store') }}" method="POST" class="space-y-6">
                @csrf

                <input type="hidden" name="pasien_id" value="{{ $pasien->id }}">

                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700">Nomor Induk Kependudukan
                        (NIK)</label>
                    <input type="text" id="nik" name="nik" value="{{ $pasien->nik }}" readonly required
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap (Sesuai
                        KTP)</label>
                    <input type="text" id="nama" name="nama" value="{{ $pasien->nama_lengkap }}" readonly
                        required
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="poli_id" class="block text-sm font-medium text-gray-700">Pilih Poli</label>
                    <select id="poli_id" name="poli_id" required
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Tujuan Poli --</option>
                        @foreach ($polis as $poli)
                        <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="tanggal_kunjungan" class="block text-sm font-medium text-gray-700">Tanggal
                        Kunjungan</label>
                    <input type="date" id="tanggal_kunjungan" name="tanggal_kunjungan" required
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Jalur (Jenis Pasien)</label>
                    <div class="mt-2 flex items-center space-x-6">
                        <label class="flex items-center">
                            <input type="radio" name="jalur" value="bpjs"
                                class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                            <span class="ml-2 text-gray-700">BPJS</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="jalur" value="umum" checked
                                class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                            <span class="ml-2 text-gray-700">Umum</span>
                        </label>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit"
                        class="w-full md:w-auto inline-flex justify-center py-3 px-8 border border-transparent shadow-sm text-base font-medium rounded-full text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Dapatkan Nomor Antrian
                    </button>
                </div>
            </form>

        </div>
    </div>
</section>
@else
<div class="text-center py-20">
    <p class="text-gray-700">Silakan login terlebih dahulu untuk mendaftar antrian.</p>
    <a href="{{ route('pasien.login') }}"
        class="mt-4 inline-block bg-blue-600 text-white px-6 py-3 rounded-full hover:bg-blue-700">
        Login Pasien
    </a>
</div>
@endauth
@endsection