<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\User;
use App\Pass;

class Stamp extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount', 'user_id', 'pass_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pass()
    {
        return $this->belongsTo(Pass::class);
    }
}
