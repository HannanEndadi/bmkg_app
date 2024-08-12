<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangs = Barang::all(); 
        
        return view('data.barang', ['barangs' => $barangs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->only(['kode', 'nama', 'tipe','jumlah']);

        if (auth()->check()) {
            $validatedData['user_id'] = auth()->user()->id;
        } else {
            return redirect('/login')->with('error', 'Mohon Login Untuk Menambahkan Data Barang');
        }


        Barang::create($validatedData);

        return redirect('/barang')->with('success', 'Data Barang Baru Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        $validatedData = $request->only(['kode', 'nama', 'tipe','jumlah']);


        Barang::where('kode', $barang->kode)
            ->update($validatedData);
        
        return redirect('/barang')->with('success', 'Data Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();
    
        return redirect('/barang')->with('success', 'Data Barang Berhasil Dihapus');
    }
}
