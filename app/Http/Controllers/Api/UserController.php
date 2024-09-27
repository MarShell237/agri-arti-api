<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $users = User::all();
      return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $data = $request->validate([
              'name' => 'required|max:100',
              'email' => 'required|email|unique:users',
              'password' => 'required|min:4',
              'address' => 'required',
              'picture' => 'required | image',
              'phone' => 'required'
              ]);

      $data['picture'] = $request->file('picture')->store('public/user');
      $user = User::create($data);

      // On retourne les informations du nouvel utilisateur en JSON
      return response()->json([
        'user'=>$user,
        'status_code' => 201,
        'status_message' => 'utilisateur enregistrer avec success'
      ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
          'status_code' => 200,
          'status_message' => 'utilisateur supprimer avec success'
        ], 201);
    }
}
