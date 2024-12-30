<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    //
    protected $table = 'kategori';
    protected $fillable = [
        'id_kategori',
        'name_kategori',
        'created_by',
        'created_date',
        'update_date',
        'update_by',
        'voided',
        'status',
    ];
    protected $primarykey = 'id';
    public $timestamps = false;
}
