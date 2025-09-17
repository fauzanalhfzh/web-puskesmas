    @extends('layouts.app')

    @section('content')
    <section id="beranda" class="relative text-white">
        <img src="{{ asset('images/puskesmas-bg.jpeg') }}" alt="Dokter dan Pasien" class="w-full h-[60vh] object-cover">
        <div class="absolute inset-0  bg-opacity-50 flex items-center">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Layanan Kesehatan Terpercaya untuk Anda</h1>
                <p class="text-lg mb-8">Daftarkan diri Anda untuk mendapatkan nomor antrian secara online dan hindari
                    menunggu lama.</p>
                <a href="{{ route('login') }}"
                    class="bg-white text-blue-600 font-bold px-8 py-3 rounded-full hover:bg-gray-200 transition duration-300">Daftar
                    Online Sekarang</a>
            </div>
        </div>
    </section>

    <section id="layanan" class="py-20">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Layanan Unggulan Kami</h2>
                <p class="text-gray-600 mt-2">Kami menyediakan berbagai layanan kesehatan untuk masyarakat.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($poliCounts as $poli)
                <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                    <div class="mb-4 text-blue-600">
                        <!-- Ganti icon sesuai jenis poli kalau mau -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c1.657 0 3-1.343 3-3S13.657 2 12 2 9 3.343 9 5s1.343 3 3 3zm0 2c-2.21 0-4 1.79-4 4v1h8v-1c0-2.21-1.79-4-4-4zm6 6H6v4h12v-4z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">{{ $poli->nama_poli }}</h3>
                    <p class="text-gray-600">{{ $poli->deskripsi ?? 'Deskripsi layanan belum tersedia.' }}</p>
                    <p class="mt-4 text-sm text-gray-500">Jumlah pendaftar: <strong>{{ $poli->pendaftaran_count }}</strong></p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="jadwal" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Jadwal Praktik Dokter</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-md rounded-lg">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="py-3 px-6 text-left">Poli</th>
                            <th class="py-3 px-6 text-left">Dokter</th>
                            <th class="py-3 px-6 text-left">Hari</th>
                            <th class="py-3 px-6 text-left">Jam Praktik</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <tr class="border-b">
                            <td class="py-3 px-6">Poli Umum</td>
                            <td class="py-3 px-6">dr. Budi Santoso</td>
                            <td class="py-3 px-6">Senin - Jumat</td>
                            <td class="py-3 px-6">08:00 - 14:00</td>
                        </tr>
                        <tr class="bg-gray-50 border-b">
                            <td class="py-3 px-6">Poli Gigi</td>
                            <td class="py-3 px-6">drg. Citra Lestari</td>
                            <td class="py-3 px-6">Senin, Rabu, Jumat</td>
                            <td class="py-3 px-6">09:00 - 12:00</td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-3 px-6">Poli KIA</td>
                            <td class="py-3 px-6">Bidan Anisa Putri, A.Md.Keb</td>
                            <td class="py-3 px-6">Senin - Sabtu</td>
                            <td class="py-3 px-6">08:00 - 14:00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section id="kontak" class="py-20">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Hubungi Kami</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h3 class="text-2xl font-semibold mb-4">Puskesmas Citangkil II</h3>
                    <p class="mb-2"><strong>Alamat:</strong> Lebakdenok, Citangkil, Cilegon, Banten 42442
                    </p>
                    <p class="mb-2"><strong>Telepon:</strong> (0254) 123-456</p>
                    <p class="mb-2"><strong>Email:</strong> info@puskesmascitangkil2.go.id</p>
                </div>
                <div class="w-full h-80 rounded-lg overflow-hidden shadow-lg">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15871.054285288426!2d106.00600004763125!3d-6.027155403332135!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e418faa62b0828f%3A0xd2322096c919c216!2sPUSKESMAS%20CITANGKIL%20II!5e0!3m2!1sen!2sid!4v1753096835834!5m2!1sen!2sid"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>
    @endsection