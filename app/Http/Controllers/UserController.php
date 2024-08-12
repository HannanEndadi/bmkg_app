<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        // where('is_admin', false)
        //       ->where('is_superadmin', false)
        //       ->get();

        return view('data.users', ['users' => $users]);

    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->only(['name', 'username', 'password']);

        if (auth()->check()) {
            $validatedData['user_id'] = auth()->user()->id;
        } else {
            return redirect('/login')->with('error', 'Mohon Login Untuk Menambahkan Data User');
        }


        User::create($validatedData);

        return redirect('/users')->with('success', 'Data User Baru Berhasil Ditambahkan');
    }
//Tes
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
    public function update(Request $request, User $user)
    {
        $validatedData = $request->only(['username', 'name', 'password']);

        $validatedData['password'] = Hash::make($request->password);

        User::where('id', $user->id)
            ->update($validatedData);
        
        return redirect('/users')->with('success', 'Data Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect('/users')->with('success', 'Data User Berhasil Dihapus');
    }
}
