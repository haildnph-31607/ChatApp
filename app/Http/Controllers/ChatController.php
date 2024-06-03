<?php

namespace App\Http\Controllers;

use App\Events\ChatSolution;
use App\Events\UserOnlined;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ChatController extends Controller
{
    public function chat()
    {
        $users = User::where('id', '<>', Auth::user()->id)->get();
        return view('chat.chatapp', compact('users'));
    }
    public function send(Request $request)
    {
        broadcast(new UserOnlined($request->user(), $request->message));
        return json_encode([
            'success' => 'done',
        ]);
    }
    public function chatSolution($id){
         $user = User::find($id);
        return view("chat.chatSolution",compact('user'));
    }

    public function profileView($id){

    }
    public function Message(Request $request ,$id){
        broadcast(new ChatSolution($request->user(),User::find($id),$request->message));
        return response()->json('MSG DONE');

    }
}
