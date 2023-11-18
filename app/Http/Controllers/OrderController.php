<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    private $orders;

    public function __construct(OrderRepository $orders)
    {
        $this->orders = $orders;
    }

    public function create(Request $request)
    {
        $check = $this->checkToken($request->header('token'));
        if(!$check) {
            return response()->json([
                'status' => false,
                'data' => [
                    'message' => 'توکن ارسالی معتبر نمیباشد'
                ]
            ]);
        }

        $order = $this->orders->CreateOrder($request->all());

    }

    public function checkToken($token)
    {
        $check = User::where('token', $token)->first();
        return ($check == null) ? false : true;
    }
}
