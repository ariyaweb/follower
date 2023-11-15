<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'request_count',
        'follow_count',
        'status',
        'created_at'
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
