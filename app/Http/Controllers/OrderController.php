<?php

namespace App\Http\Controllers;

use App\Http\Requests\orders\OrderCreateRequest;
use App\Models\User;
use App\Models\Wallet;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    private $orders;

    public function __construct(OrderRepository $orders)
    {
        $this->orders = $orders;
    }

    public function create(OrderCreateRequest $request)
    {
        // check token
        $check_token = $this->checkToken($request->header('token'));

        if(!$check_token['status'])
        return response()->json([
            'status' => false,
            'message' => 'توکن ارسالی نادرست میباشد'
        ]);

        // validation data
        $validated = $request->validated();

        // check coin's
        $coin_count = $validated['request_count'] * 4;

        $balance = DB::table('wallets')->where('username',$check_token['username'])->pluck('balance')->first();
        if($balance < $coin_count) {
            return response()->json([
                'status' => false,
                'data' => [
                    'message' => "تعداد سکه های مورد نیاز برای ثبت سفارش $coin_count میباشد."
                ]
            ]);
        }
        $new_balance = $balance - $coin_count;
        // save order on database
        $order = $this->orders->CreateOrder($validated,$check_token['username'],$new_balance);

        // return response json
        return response()->json([
            $order
        ]);

    }

    public function checkToken($token)
    {
        $check = DB::table('users')->where('token', $token)->first();

        if($check == null) {
            $status = false;
            $username = null;
        } else {
            $status = true;
            $username = $check->username;
        }
        return collect(['status' => $status, 'username' => $username]);
    }
}
