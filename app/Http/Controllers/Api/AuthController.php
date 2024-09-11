<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function login(Request $request){
    $credentials = $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
      $user = User::where('email',$credentials['email'])->first();
      $token = $user->createToken($user->name)->plainTextToken;
      return response()->json([
        'user' => $user,
        'status_code' => 200,
        'status_message' => 'utilisateur connecter',
        'token' => $token
      ]);
    }else{
      return response()->json([
        'status_code' => 403,
        'status_message' => 'information de connection non valide'
      ]);
    }
  }

  public function logout(){
    Auth::user()->tokens()->delete();
    return response()->json([
      'status_code' => 200,
      'status_message' => 'utilisateur deconnecter',
    ]);
  }
}
