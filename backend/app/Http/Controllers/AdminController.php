<?php

namespace App\Http\Controllers;

use App\Models\Quize;
use App\Models\Result;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function userList(Request $request) {
        $results = Result::with('user:users.id,name')->where('isDone', 1)->get();
        return $results;
    }

    public function reset(Request $request) {
        $result = $request->user()->result()->delete();
        return true;
    }

}
