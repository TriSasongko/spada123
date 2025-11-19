<x-app-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('siswa.ujian.submit', $ujian->id) }}" method="POST" id="form-ujian">
                @csrf

                <div class="bg-blue-600 text-white p-4 rounded mb-6 sticky top-0 z-10 flex justify-between items-center shadow">
                    <h1 class="font-bold text-lg">{{ $ujian->judul }}</h1>
                    <div class="font-mono text-xl font-bold" id="timer">00:00:00</div>
                </div>

                @foreach($soals as $index => $soal)
                    <div class="bg-white p-6 rounded shadow mb-4">
                        <p class="font-bold text-lg mb-3">{{ $index + 1 }}. {{ $soal->pertanyaan }}</p>

                        <div class="grid grid-cols-1 gap-2">
                            @foreach(['a','b','c','d','e'] as $opt)
                                <label class="flex items-center p-3 border rounded cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="jawaban[{{ $soal->id }}]" value="{{ $opt }}" class="mr-3">
                                    <span>{{ strtoupper($opt) }}. {{ $soal->{'opsi_'.$opt} }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded font-bold w-full text-lg hover:bg-green-700" onclick="return confirm('Yakin ingin mengumpulkan?')">
                    SELESAI & KUMPULKAN
                </button>
            </form>
        </div>
    </div>

    <script>
        // Timer Sederhana (Hitung mundur durasi ujian)
        // Catatan: Logic timer idealnya sinkron dengan server, ini versi simpel browser-based.
        let durasiMenit = {{ $ujian->durasi_menit }};
        let countDownDate = new Date().getTime() + (durasiMenit * 60 * 1000);

        let x = setInterval(function() {
            let now = new Date().getTime();
            let distance = countDownDate - now;

            let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("timer").innerHTML = hours + "h " + minutes + "m " + seconds + "s ";

            if (distance < 0) {
                clearInterval(x);
                alert("Waktu Habis! Jawaban akan dikirim otomatis.");
                document.getElementById("form-ujian").submit();
            }
        }, 1000);
    </script>
</x-app-layout>
