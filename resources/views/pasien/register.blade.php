    @extends('layouts.app')

    @section('content')
        <section class="py-20 bg-white">
            <div class="container mx-auto px-6">
                <div class="max-w-3xl mx-auto">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-900">Registrasi Pasien Baru</h2>
                        <p class="text-gray-600 mt-2">Daftarkan diri Anda untuk membuat akun pasien.</p>
                    </div>
                    <form action="{{ route('pasien.register.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700">Nomor Induk Kependudukan
                                (NIK)</label>
                            <input type="text" id="nik" name="nik" value="{{ old('nik') }}" required
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md">
                            @error('nik')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                                required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md">
                            @error('nama_lengkap')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md">
                            @error('email')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" id="password" name="password" required
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md">
                            @error('password')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi
                                Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                            <select id="jenis_kelamin" name="jenis_kelamin" required
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md">
                                <option value="">-- Pilih --</option>
                                <option value="Laki-Laki" {{ old('jenis_kelamin') == 'Laki-Laki' ? 'selected' : '' }}>
                                    Laki-Laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                value="{{ old('tanggal_lahir') }}" required
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md">
                            @error('tanggal_lahir')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                            <input type="text" id="alamat" name="alamat" value="{{ old('alamat') }}" required
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md">
                            @error('alamat')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="no_telepon" class="block text-sm font-medium text-gray-700">Nomor Telepon
                                (Opsional)</label>
                            <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md">
                            @error('no_telepon')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit"
                                class="w-full md:w-auto inline-flex justify-center py-3 px-8 border border-transparent shadow-sm text-base font-medium rounded-full text-white bg-blue-600 hover:bg-blue-700">Registrasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    @endsection
