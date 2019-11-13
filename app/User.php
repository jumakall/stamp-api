<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Pass;
use App\Stamp;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'terms_accepted_at', 'api_token', 'code'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Automatically hash password before saving to database.
     * 
     * @var string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = app()->make('hash')->make($value);
    }

    public function vendor_passes()
    {
        return $this->hasMany(Pass::class);
    }

    public function stamps()
    {
        return $this->hasMany(Stamp::class);
    }

    public function passes()
    {
        return $this->belongsToMany(Pass::class, 'stamps'); //->using(Stamp::class);
    }
}
