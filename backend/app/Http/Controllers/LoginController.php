<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function submit(Request $request) {
        $request->validate([
            'name' => 'required|min:3',
            'password' => 'required_if:name,==,admin'
        ]);
        $user = User::firstOrCreate([
            'name' => $request->name
        ]);

        if ($request->name === 'admin') {
            return Hash::check($request->password, $user->password) ?
                response()->json(['token' => $user->createToken('Token Name')->plainTextToken, 'isAdmin' => true], 200)
                :
                response()->json(['message' => 'Could not process a user with that password'], 401);
        }
        if(!$user) {
                return response()->json(['message' => 'Could not process a user with that name'], 401);
            } else {
                return response()->json(['token' => $user->createToken('Token Name')->plainTextToken, 'isAdmin' => false], 200);

        }
    }
}
