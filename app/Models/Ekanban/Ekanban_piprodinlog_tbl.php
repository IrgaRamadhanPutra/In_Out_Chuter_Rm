<?php

namespace App\Models\Ekanban;

use Illuminate\Database\Eloquent\Model;

class Ekanban_piprodinlog_tbl extends Model
{
    //
    protected $connection = 'ekanban';
    protected $table = 'ekanban_piprodinlog_tbl';
    protected $fillable = [
        'id', 'ekanban_no', 'seq', 'mpname', 'created_by', 'creation_date', 'last_updated_by', 'last_updated_date', 'pwfgoutlog_tbl_id', 'kanban_qty', 'reset', 'reset_uid'
    ];
    protected $primaryKey = 'id';
    public $timestamps = false;
}
