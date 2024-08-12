<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
    
        $field = 'username'; 
    
        $user = null;
        if($field === 'username'){
            $user = Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']]);
        }
    
        if ($user) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }
        
        return back()->with('loginError', 'Login Gagal!');
    }
    
    
    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect('/');
    }
}
