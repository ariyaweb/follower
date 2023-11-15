<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowTransaction extends Model
{
    use HasFactory;

    protected $table = 'follow_transactions';

    protected $fillable = [
        'follower_id',
        'following_id',
        'reward',
        'follow_at'
    ];


}
