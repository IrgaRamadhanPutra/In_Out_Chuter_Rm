<?php

namespace App\Models\Ekanban;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model; // Import kelas Model dari namespace yang sesuai
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class ekanban_user_tbl extends Model implements Authenticatable
{
    use AuthenticableTrait;

    // ...
    protected $connection = 'ekanban';
    protected $table = 'ekanban_user_tbl';

    /*
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'id', 'user', 'pass', 'group',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     *
     */
    protected $hidden = [
        'pass',
    ];
    public function username()
    {
        return 'user';
    }

    public $timestamps = false;
}
