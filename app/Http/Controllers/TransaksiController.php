<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function pinjam()
    {
        $pinjams = Barang::all(); 
        
        return view('transaksi.peminjaman' , ['pinjams' => $pinjams]);
    }

    public function getDataBarang($id)
    {
        $barang = Barang::findOrFail($id);

        return response()->json($barang);
    }

    public function storePinjam(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
    
            // Dapatkan data barang dengan kode yang sama
            $barang = Barang::where('kode', $request->kode)->first();
    
            if (!$barang) {
                return redirect('/peminjaman')->with('error', 'Barang tidak ditemukan');
            }

            if ($request->jumlah > $request->stok) {
                return redirect('/peminjaman')->with('error', 'Jumlah yang diminta melebihi stok yang tersedia');
            }
            // Update jumlah di model Barang
            $barang->update(['jumlah' => $request->stok - $request->jumlah]);
    
            // Simpan transaksi baru
            $validatedData = $request->only(['kode', 'nama', 'tipe', 'jumlah', 'status']);
            $validatedData['user_id'] = $user->id;
            $validatedData['created_by'] = $user->name; 
            $validatedData['updated_at'] = null; 
    
            Transaksi::create($validatedData);
    
            return redirect('/peminjaman')->with('success', 'Peminjaman Barang Berhasil');
        } else {
            return redirect('/')->with('error', 'Mohon Login Untuk Melakukan Peminjaman Barang');
        }
    }


    public function kembali()
    {
        $kembalis = Transaksi::where('status', 'Dipinjam')->get();
        
        return view('transaksi.pengembalian' , ['kembalis' => $kembalis]);
    }
    public function getDataBarangKembali($id)
    {
        $kembali = Transaksi::findOrFail($id);

        return response()->json($kembali);
    }

    public function storeKembali(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
    
            // Dapatkan data barang dengan kode yang sama
            $barang = Barang::where('kode', $request->kode)->first();
            $riwayat = Transaksi::where('kode', $request->kode)->latest()->first();
    
            if (!$barang) {
                return redirect('/pengembalian')->with('error', 'Barang tidak ditemukan');
            }
    
            // Update jumlah di model Barang
            $barang->update(['jumlah' => $barang->jumlah + $request->jumlah]);
    
            // Simpan transaksi baru
            $validatedData = [
                'status' => $request->status,
                'updated_by' => $user->name,
            ];
    
            // Update status dan updated_by hanya pada record tertentu
            Transaksi::where('kode', $request->kode)
                ->where('tipe', $request->tipe)
                ->where('jumlah', $request->jumlah)
                ->where('created_at', $riwayat->created_at)
                ->update($validatedData);
    
            return redirect('/pengembalian')->with('success', 'Pengembalian Barang Berhasil');
        } else {
            return redirect('/')->with('error', 'Mohon Login Untuk Melakukan Pengembalian Barang');
        }
    }
    

    public function riwayat()
    {
         $user = auth()->user();

         if ($user->is_admin === 1) {
            $riwayats = Transaksi::all();
        } else if($user->is_superadmin === 1){
            $riwayats = Transaksi::all();
        }else {
            $riwayats = Transaksi::where('created_by', $user->name)
                ->get();
        }
    
        return view('transaksi.riwayat', ['riwayats' => $riwayats]);
    }
}
