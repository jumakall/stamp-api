<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\User;
use App\Stamp;

class Pass extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'max_stamps'
    ];

    public function vendor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function stamps()
    {
        return $this->hasMany(Stamp::class);
    }

    public function customers()
    {
        return $this->belongsToMany(User::class, 'stamps'); //->using(Stamp::class);
    }
}
