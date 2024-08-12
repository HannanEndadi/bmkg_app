<?php

namespace App\Http\Controllers;

use App\Charts\AsetChart;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(AsetChart $chart)
    {
        $borrowingsPerWeek = $this->getBorrowingsPerWeek();
        $user = auth()->user();
    
        $data = [
            'chart' => $chart->build($borrowingsPerWeek),
            'totalUsers' => User::count(),
            'totalBarangs' => Barang::count(),
            'totalRiwayatsA' => Transaksi::count(),
            'totalRiwayats' => Transaksi::where('created_by', $user->name)->count(),
            'riwayats' => Transaksi::join('users', 'transaksis.created_by', '=', 'users.name')
                ->where('status', 'Dipinjam')
                ->where(function ($query) use ($user) {
                    $query->where(function ($subquery) use ($user) {
                        $subquery->where('created_by', $user->name)
                                 ->orWhere('users.is_admin', false)
                                 ->orWhere('users.is_superadmin', false);
                    });
                })
                ->get(),
            'riwayatsa' => Transaksi::join('users', 'transaksis.created_by', '=', 'users.name')
                ->where('status', 'Dipinjam')
                ->where(function ($query) use ($user) {
                    $query->where(function ($subquery) use ($user) {
                        $subquery->where('created_by', $user->name)
                                 ->orWhere('users.is_admin', true)
                                 ->orWhere('users.is_superadmin', true);
                    });
                })
                ->get(),
        ];
    
        return view('dashboard', $data);
    }

    private function getBorrowingsPerWeek()
    {
        // Dapatkan bulan dan tahun saat ini
        $currentMonth = now()->format('m');
        $currentYear = now()->format('Y');

        $weekLabels = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'];
        $totalBorrowings = [0, 0, 0, 0];
        $totalReturns = [0, 0, 0, 0];
    
        // Loop melalui setiap minggu dan hitung total peminjaman
        foreach ($weekLabels as $weekIndex => $weekLabel) {
            // Tentukan rentang tanggal untuk setiap minggu
            $startDay = ($weekIndex * 7) + 1; // Awal minggu
            $endDay = min(($weekIndex + 1) * 7, now()->endOfMonth()->day); // Akhir minggu
    
            $startDate = now()->setDate($currentYear, $currentMonth, $startDay)->startOfDay();
            $endDate = now()->setDate($currentYear, $currentMonth, $endDay)->endOfDay();
    
            // Query model 'Riwayat' untuk menghitung jumlah peminjaman dalam minggu ini
            $totalBorrowings[$weekIndex] = Transaksi::whereBetween('created_at', [$startDate, $endDate])
            ->count();
            $totalReturns[$weekIndex] = Transaksi::whereBetween('updated_at', [$startDate, $endDate])
            ->count();
        }
    
        return [
            'weekLabels' => $weekLabels,
            'totalBorrowings' => $totalBorrowings,
            'totalReturns' => $totalReturns,
        ];
    }
}
