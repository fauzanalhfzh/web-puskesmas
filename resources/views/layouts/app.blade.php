<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Puskesmas Citangkil II</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800 min-h-screen">

    <!-- Header / Navbar -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-2xl font-bold text-blue-600">Puskesmas Citangkil II</a>
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ url('/') }}#beranda" class="text-gray-600 hover:text-blue-600">Beranda</a>
                <a href="{{ url('/') }}#layanan" class="text-gray-600 hover:text-blue-600">Layanan</a>
                <a href="{{ url('/') }}#jadwal" class="text-gray-600 hover:text-blue-600">Jadwal Dokter</a>
                <a href="{{ url('/') }}#kontak" class="text-gray-600 hover:text-blue-600">Kontak</a>
                <a href="{{ url('/pendaftaran') }}" class="text-gray-600 hover:text-blue-600">Antrian Online</a>
            </div>
            <div class="flex items-center space-x-4">
                @auth('pasien')
                    <span class="text-gray-700">Halo, {{ Auth::guard('pasien')->user()->nama_lengkap }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="bg-red-600 text-white px-4 py-2 rounded-full hover:bg-red-700">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700">Login</a>
                @endauth
                </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-12">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; {{ date('Y') }} Puskesmas Citangkil II. Semua Hak Cipta Dilindungi.</p>
        </div>
    </footer>

</body>

</html>
