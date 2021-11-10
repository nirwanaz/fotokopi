<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Admin as User;

class AdminController extends Controller
{
    //
    private function findUserByUsername($username) {
        $user = User::where('username', '=', $username)->first();
        return $user;
    }

    public function login(Request $request) {
        $found = false;
        $validateData = $request->validate([
            'username'  => 'required',
            'passwd'    => 'required'
        ]);

        $user = $this->findUserByUsername($validateData['username']);
        //check passwd
        if ($user->passwd == $validateData['passwd']) {
            //create token
            $user->token = Str::random(20);
            $user->save();
            $found = true;
        }

        if ($found) {
            $found = [
                'id' => $user->id,
                'token' => $user->token
            ];
        }

        return response()->json($found);
    }

    public function getUser($token) {
        $user = User::where('token', '=', $token)->first();

        return $user->toJson();
    }

    public function register(Request $request) {
        $validateData = $request->validate([
            'name'      => 'required',
            'username'  => 'required',
            'passwd'    => 'required'
        ]);

        $user = User::create([
            'name'      => $validateData['name'],
            'username'  => $validateData['username'],
            'passwd'    => $validateData['passwd']
        ]);

        $msg = [
            'success' => true,
            'message' => 'User has been created'
        ];

        return response()->json($msg);
    }
}
