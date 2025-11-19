<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RekapAbsensiExport implements FromView, ShouldAutoSize
{
    protected $students;
    protected $absensis;
    protected $kelas;
    protected $mapel;
    protected $bulan;
    protected $tahun;

    public function __construct($students, $absensis, $kelas, $mapel, $bulan, $tahun)
    {
        $this->students = $students;
        $this->absensis = $absensis;
        $this->kelas = $kelas;
        $this->mapel = $mapel;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        return view('guru.absensi.excel', [
            'students' => $this->students,
            'absensis' => $this->absensis,
            'kelas' => $this->kelas,
            'mapel' => $this->mapel,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
        ]);
    }
}
