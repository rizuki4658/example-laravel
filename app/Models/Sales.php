<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use Notifiable;

    protected $fillable = [
        'name', 'item_id', 'item_code', 'item_name', 'price', 'qty', 'status', 'username', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}

