<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Profil Saya') }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-blue-600 hover:underline flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900">Informasi Profil</h3>
                    <p class="mt-1 text-sm text-gray-600">Update nama, email, dan foto profil Anda.</p>

                    <form method="post" action="{{ route('my.profile.update') }}" enctype="multipart/form-data"
                        class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <div class="flex items-center space-x-4">
                            <div class="shrink-0">
                                @if (Auth::user()->avatar)
                                    <img class="h-16 w-16 object-cover rounded-full border"
                                        src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Foto Profil">
                                @else
                                    <div
                                        class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-xl font-bold">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Ganti Foto</label>
                                <input type="file" name="avatar"
                                    class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                @error('avatar')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                required>
                        </div>

                        <button type="submit"
                            class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700">Simpan
                            Perubahan</button>
                    </form>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900">Ganti Password</h3>
                    <p class="mt-1 text-sm text-gray-600">Pastikan akun Anda aman dengan password yang kuat.</p>

                    <form method="post" action="{{ route('my.profile.password') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('put')

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Password Saat Ini</label>
                            <input type="password" name="current_password"
                                class="border-gray-300 rounded-md shadow-sm mt-1 block w-full">
                            @error('current_password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Password Baru</label>
                            <input type="password" name="password"
                                class="border-gray-300 rounded-md shadow-sm mt-1 block w-full">
                            @error('password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation"
                                class="border-gray-300 rounded-md shadow-sm mt-1 block w-full">
                        </div>

                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">Ganti
                            Password</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
