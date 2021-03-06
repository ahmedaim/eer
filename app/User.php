<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * open request attributes and return new instance
     * @param array $attributes
     * @return static
     */
    public static function open(array $attributes)    {
        return new static($attributes);
    }

    /**
     *  Get all admins related to specific user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function admins()

    {
        return $this->hasMany(Admin::class , 'idUser') ;
    }

    /**
     *  Get all customers related to specific user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customers()
    {
        return $this->hasMany(Customer::class , 'idUser') ;
    }

    /**
     *  Get all consultants related to specific user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function consultants()
    {
        return $this->hasMany(Consultant::class , 'idUser') ;
    }


}
