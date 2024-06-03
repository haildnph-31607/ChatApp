<?php

namespace App\Http\Controllers;

use App\Events\UserCreated;
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
        return view('user.list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'avatar' => $request->image,
            'password' => Hash::make('password')
        ];
        $user = User::create($data);
        broadcast(new UserCreated($user));
        return json_encode($user);
    }

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
    public function edit(Request $request)
    {
       $userDetail =User::find($request->id);
        return json_encode($userDetail);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data =[
            'name' => $request->name,
            'email' => $request->email,
            'avatar' => $request->avatar,
            // 'id'=>$request->id

        ];

        User::where('id',$request->id)->update($data);
        return json_encode($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
         User::where('id',$request->id)->delete();
         return json_encode($request->id);
    }
}
