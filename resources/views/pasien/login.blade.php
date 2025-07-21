@extends('layouts.app')

@section('content')
<section class="py-20 bg-white flex mb-64">
    <div class="container mx-auto px-6">
        <div class="max-w-md mx-auto">
            <h2 class="text-3xl font-bold mb-6 text-center">Login Pasien</h2>
            <form method="POST" action="{{ route('login.submit') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md">
                </div>
                <div class="text-center">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-full">Login</button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-700">Belum punya akun?</p>
                <a href="{{ route('pasien.register') }}" class="mt-2 inline-block bg-gray-200 text-gray-800 px-4 py-2 rounded-full hover:bg-gray-300">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
