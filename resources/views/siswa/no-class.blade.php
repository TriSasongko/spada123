<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Dashboard') }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-red-50 border border-red-200 rounded-lg p-6 text-center">
                <h3 class="text-lg font-bold text-red-700">Akun Belum Mendapat Kelas</h3>
                <p class="mt-2 text-red-600">
                    Halo {{ Auth::user()->name }}, akun Anda belum dimasukkan ke dalam Kelas oleh Administrator.
                    <br>Silakan hubungi Tata Usaha atau Admin Sekolah untuk di-setting kelasnya.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
