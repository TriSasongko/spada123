<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

// Ganti FromView menjadi FromCollection dan WithHeadings
class RekapNilaiExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $students;
    protected $tugasList;
    protected $ujianList;
    protected $kelas;
    protected $mapel;

    public function __construct($students, $tugasList, $ujianList, $kelas, $mapel)
    {
        $this->students = $students;
        $this->tugasList = $tugasList;
        $this->ujianList = $ujianList;
        $this->kelas = $kelas;
        $this->mapel = $mapel;
    }

    // Metode untuk mendefinisikan baris header
    public function headings(): array
    {
        $headings = ['NO', 'Nama Siswa'];

        // Tambahkan header Tugas
        foreach ($this->tugasList as $t) {
            $headings[] = 'Tgs: ' . $t->judul;
        }

        // Tambahkan header Ujian
        foreach ($this->ujianList as $u) {
            $headings[] = strtoupper($u->tipe_ujian) . ': ' . $u->judul;
        }

        $headings[] = 'Rata-rata';

        return $headings;
    }

    // Metode untuk mengambil data
    public function collection(): Collection
    {
        $data = [];
        foreach ($this->students as $index => $siswa) {
            $row = [$index + 1, $siswa->name];
            $total = 0;
            $count = 0;

            // Nilai Tugas
            foreach ($this->tugasList as $t) {
                $val = $t->pengumpulans->where('user_id', $siswa->id)->first()->nilai;
                $row[] = $val ?? 0;
                if ($val !== null) {
                    $total += $val;
                    $count++;
                }
            }

            // Nilai Ujian
            foreach ($this->ujianList as $u) {
                $valUjian = $u->ujianSiswas->where('user_id', $siswa->id)->first()->nilai;
                $row[] = $valUjian ?? 0;
                if ($valUjian !== null) {
                    $total += $valUjian;
                    $count++;
                }
            }

            // Rata-rata
            $row[] = $count > 0 ? round($total / $count, 1) : 0;

            $data[] = $row;
        }

        return new Collection($data);
    }
}
