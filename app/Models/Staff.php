<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    //
    // protected $connection = 'laravel7_new';
    protected $table = 'staff';
    protected $fillable = [
        'id_staff',
        'name_staff',
        'nik',
        'lahir',
        'tgl_lahir',
        'status',
        'created_date',
        'created_by',
        'update_date',
        'update_by',
        'void'
    ];
    protected $primarykey = 'id_staff';
    public $timestamps = false;
}
