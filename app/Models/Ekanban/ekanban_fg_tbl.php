<?php

namespace App\Models\Ekanban;

use Illuminate\Database\Eloquent\Model;

class ekanban_fg_tbl extends Model
{
    //
    //
    protected $connection = 'ekanban';
    protected $table = 'ekanban_fg_tbl';
    protected $fillable = [
        'id', 'part_no', 'item_code', 'stock_awal', 'in', 'out', 'balance', 'stock_opname', 'mpname', 'created_by', 'creation_date', 'last_updated_by', 'last_updated_date'
    ];
    protected $primaryKey = 'id';
    public $timestamps = false;
}
