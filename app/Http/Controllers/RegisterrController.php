<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class RegisterrController extends Controller
{
    //
    public function index()
    {
        return view('auth.register');
    }
    public function addRegister(Request $request)
    {
        // dd($request);
        $nama = $request->nama;
        $email = $request->email;
        $nik = $request->nik;
        $password = $request->password;
        $user = User::create([
            'name' => $nama,
            'nik' => $nik,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
        return response()->json($user);
    }
}
