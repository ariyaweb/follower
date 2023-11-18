<?php

namespace App\Repositories;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderRepository
{
    public function CreateOrder($data,$username,$new_balance)
    {
        // save data
        $save = Order::insert(array(
            'user_id' => $data['user_id'],
            'request_count' => $data['request_count'],
            'follow_count' => 0,
            'status' => 0,
            'created_at' => Carbon::now()
        ));

        // update wallet balance
        $update_balance = DB::table('wallets')->where('username',$username)->update(array(
           'balance' => $new_balance
        ));

        // return response
        if ($save && $update_balance) {
            $data_res = [
                'message' => 'سفارش جدید با موفقیت ثبت شد',
            ];
            return collect(array('status' => true, 'data' => $data_res));
        } else {
            return collect(array('status' => false,'message' => 'خطا در ذخیره اطلاعات لطفا چند لحظه دیگر تلاش کنید'));
        }
    }

}
