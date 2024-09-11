<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
  public function index(){
    $users = User::select('name','id')->where('id', '!=' , Auth::user()->id)->get();
    return response()->json($users);
  }

  public function show(User $user){
    $users = User::select('name','id')->where('id', '!=' , Auth::user()->id)->get();
    $authUser = Auth::user();
    return response()->json([
      'users' => $users,
      'user' => $user,
      'messages' => Message::whereRaw("((from_id = $authUser->id AND to_id = $user->id) OR (from_id = $user->id AND to_id = $authUser->id))")
      ->orderByDesc('created_at')
      ->get()
      ->reverse()
    ]);
  } 

  public function store(User $user, Request $request){
    Message::create([
      'from_id' => Auth::user()->id,
      'to_id' => $user->id,
      'content' => $request->get('content'),
      'read_at' => Carbon::now()
    ]);

    return response()->json([
      'status_code' => 200,
      'status_message' => 'message envoyer',
    ]);  
  }

}
