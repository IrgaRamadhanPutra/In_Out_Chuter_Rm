<?php

namespace App\Models\Ekanban;

use Illuminate\Database\Eloquent\Model;

class ekanban_rm_chuter_tbl extends Model
{

    protected $connection = 'ekanban';
    protected $table = 'ekanban_rm_chuter_tbl';
    protected $fillable = [
        'id',
        'part_name',
        'item_code',
        'stock_awal',
        'in',
        'out',
        'balance',
        'stock_opname',
        'mpname',
        'created_by',
        'creation_date',
        'last_updated_by',
        'last_updated_date'
    ];
    protected $primaryKey = 'id';
    public $timestamps = false;
}
