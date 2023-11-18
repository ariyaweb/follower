<?php

namespace App\Repositories;

use App\Models\FollowTransaction;
use App\Models\Order;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderRepository
{
    public function FollowUser($following_id, $follower_id)
    {
        $check_request = Order::where([['user_id', $following_id],['status',0]])->first();
        if($check_request == null)
        {
            return collect(array('status' => false,'message' => 'اطلاعات ارسالی نادرست میباشد'));
        }

        // save follower transaction
        $save_follower = FollowTransaction::insert(array(
            'follower_id' => $follower_id,
            'following_id' => $following_id,
            'reward' => 2,
            'follow_at' => Carbon::now()
        ));

        // update order request
        $order_info = Order::where([['status','0'],['user_id', $following_id]])->first();
        if(($order_info->follow_count + 1) == $order_info->request_count){
            $status = 1;
        }else {
            $status = 0;
        }

        DB::table('orders')->where('id',$order_info->id)->update(array(
           'follow_count' => $order_info->follow_count + 1,
            'status' => $status
        ));

        if($save_follower) {
            return collect(array('status' => true,'message' => 'عملیات با موفقیت انجام شد'));
        } else {
            return collect(array('status' => false,'message' => 'خطای داخلی سرور لطفا چند لحظه دیگر تلاش کنید'));
        }
    }

    public function OrderList()
    {
        return Order::where('status',0)->get();
    }

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
