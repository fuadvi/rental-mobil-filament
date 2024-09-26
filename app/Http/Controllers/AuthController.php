<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Traits\ResponFormater;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

  use ResponFormater;

   public function signin(LoginRequest $request)
   {
      $user = User::whereEmail($request->email)->first();

      if(!$user || !Hash::check($request->password, $user->password))
      {
        return $this->error("Password Or Email Not Found!", 400);
      }

     $token =  $user->createToken("token")->plainTextToken;

     return $this->success(
      "Berhasil Login",
      [
          "token" => $token
        ],
     Response::HTTP_OK
    );
   }

   public function signup(RegisterRequest $request)
   {

    $data = $request->validated();
    $data['password'] =  Hash::make($data['password']);

    User::create($data);

    return $this->success("berhasil mendaftar akun", null, Response::HTTP_CREATED);
   }
}
