<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use Notifiable;

    protected $fillable = [
        'code', 'name', 'brands', 'last_in', 'last_out', 'stocks', 'max_stocks', 'min_stocks', 'status', 'username', 'user_id','price'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
