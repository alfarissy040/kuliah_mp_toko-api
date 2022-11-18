<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberToken;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            "email"=> "required|email",
            "password"=> "required",
        ]);

        $email = $request->input("email");
        $password = $request->input("password");
        $member = Member::where("email", $email)->first();

        if(empty($member)){
            return $this->responHasil(404, false, "email tidak ditemukan");
        }
        if(!Hash::check($password, $member->password)){
            return $this->responHasil(404, false, "password tidak valid");
        }
        $data = [
            "auth_key" => Hash::make(md5(date("Y-m-d H:i:s"), rand(9, 99999))),
            "member_id" => $member->id,
        ];
        
        try {
            MemberToken::create($data);
            return $this->responHasil(200, true, $data);
        } catch (Exception $e) {
            return $this->responHasil(500, false, $e);
        }

    }
}
