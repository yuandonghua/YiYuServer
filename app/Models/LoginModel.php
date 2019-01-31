<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class LoginModel extends Authenticatable implements JWTSubject  
{
    use Notifiable;

    const STATUS_NORMAL = 1; // 登录状态：正常
    const STATUS_CANCEL = 0; // 登录状态：注销

    protected $table = 'login';


    protected $fillable = [
        'user_id', 'account', 'type', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token', 'password', 'created_at', 'updated_at'
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * 查询条件account
     */
    public function scopeWhereAccount($query, $account)
    {
        return $query->where('account', $account);
    }
    
    /**
     * 查询条件type
     */
    public function scopeWhereType($query, $type)
    {
        return $query->where('type', $type);
    }

    

}


