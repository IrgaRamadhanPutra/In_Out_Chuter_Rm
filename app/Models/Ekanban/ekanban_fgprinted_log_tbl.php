<?php

namespace App\Models\Ekanban;

use Illuminate\Database\Eloquent\Model;

class ekanban_fgprinted_log_tbl extends Model
{
    //
    protected $connection = 'ekanban';
    protected $table = 'ekanban_fgprinted_log_tbl';
    protected $fillable = [
        'id','ekanban_no','itemcode','seq','mpname','kanban_qty','created_by','creation_date'
    ];
    protected $primaryKey = 'id';
    public $timestamps = false;
}
