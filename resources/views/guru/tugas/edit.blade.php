<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Tugas / Perpanjang Waktu</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('guru.tugas.update', $tugas->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Judul Tugas</label>
                        <input type="text" name="judul" value="{{ $tugas->judul }}"
                            class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Instruksi</label>
                        <textarea name="deskripsi" class="shadow border rounded w-full py-2 px-3 text-gray-700" rows="4">{{ $tugas->deskripsi }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Waktu Mulai</label>
                            <input type="datetime-local" name="waktu_mulai"
                                value="{{ $tugas->waktu_mulai ? $tugas->waktu_mulai->format('Y-m-d\TH:i') : '' }}"
                                class="shadow border rounded w-full py-2 px-3 text-gray-700">
                        </div>
                        <div>
                            <label class="block text-red-700 text-sm font-bold mb-2">Deadline (Edit untuk
                                perpanjang)</label>
                            <input type="datetime-local" name="deadline"
                                value="{{ $tugas->deadline->format('Y-m-d\TH:i') }}"
                                class="shadow border border-red-300 rounded w-full py-2 px-3 text-gray-700" required>
                        </div>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded">Update
                        Tugas</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
