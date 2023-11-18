<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;

class UserRepository
{
    public function CreateUser($data): mixed
    {
        // create token
        $token = uuid_create();

        // save user data
        $save = User::insert(array(
            'username' => $data['username'],
            'token' => $token,
            'register_at' => Carbon::now()
        ));

        // save wallet data for user
        $save_wallet = Wallet::insert(array(
            'username' => $data['username'],
            'balance' => 4
        ));

        // return response
        if ($save && $save_wallet) {
            $data_res = [
                'message' => 'کاربر جدید با موفقیت ثبت شد',
                'token' => $token
            ];
            return collect(array('status' => true, 'data' => $data_res));
        } else {
            return collect(array('status' => false,'message' => 'خطا در ذخیره اطلاعات لطفا چند لحظه دیگر تلاش کنید'));
        }
    }
}
