<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Query\Builder;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'phone', 'birth_date', 'address', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', // 'remember_token',
    ];

    public function inventories()
    {
        return $this->hasMany('App\Models\Inventory');
    }

    public function sales()
    {
        return $this->hasMany('App\Models\Sales');
    }
}
