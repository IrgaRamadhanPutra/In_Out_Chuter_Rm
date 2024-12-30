<?php

namespace App\Models\Ekanban;

use Illuminate\Database\Eloquent\Model;

class Master_access_chuter extends Model
{
    //
    protected $connection = "ekanban";
    protected $table = "master_access_chuter";
    protected $fillable = [
        'id', 'user', 'access_cust', 'created_by', 'created_date', 'update_by', 'update_date', 'status'
    ];
    protected $primaryKey = 'id';
    public $timestamps = false;
}
