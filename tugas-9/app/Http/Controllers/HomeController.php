<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Tugas;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        try {
            // Get all jadwal sorted by hari
            $jadwals = Jadwal::all();
            
            // Define hari order
            $hariOrder = [
                'Senin' => 1,
                'Selasa' => 2,
                'Rabu' => 3,
                'Kamis' => 4,
                'Jumat' => 5,
                'Sabtu' => 6,
                'Minggu' => 7,
            ];
            
            // Sort jadwal by hari and jam_mulai
            $jadwals = $jadwals->sort(function($a, $b) use ($hariOrder) {
                $hariA = $hariOrder[$a->hari] ?? 999;
                $hariB = $hariOrder[$b->hari] ?? 999;
                
                if ($hariA === $hariB) {
                    return strcmp($a->jam_mulai, $b->jam_mulai);
                }
                return $hariA - $hariB;
            });

            // Group jadwal by hari
            $jadwalByHari = $jadwals->groupBy('hari');

            // Get tugas only if user is logged in
            $tugas = collect([]);
            $isLoggedIn = session()->has('user_id');
            
            if ($isLoggedIn) {
                $tugas = Tugas::orderBy('deadline', 'asc')->get();
            }

            return view('home', compact('jadwalByHari', 'tugas', 'isLoggedIn'));
        } catch (\Exception $e) {
            // If there's an error, show a friendly message
            return response()->view('errors.custom', [
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}