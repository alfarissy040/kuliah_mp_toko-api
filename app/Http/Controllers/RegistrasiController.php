<?php

namespace App\Http\Controllers;

use App\Models\Registrasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegistrasiController extends Controller
{
    public function registrasi(Request $request)
    {
        $validatedData = $this->validate($request, [
            "name"=> "required",
            "email"=> "required|email",
            "password"=> "required",
        ]);

        $validatedData["password"] = Hash::make($validatedData["password"]);

        Registrasi::create($validatedData);
        return $this->responHasil(200, true, "Registrasi berhasil");
    }
}
