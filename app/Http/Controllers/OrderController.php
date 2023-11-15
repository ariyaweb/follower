<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $token = $request->header('token');
        return response()->json([
            'status' => false,
            'token' => $token
        ]);
    }
}
