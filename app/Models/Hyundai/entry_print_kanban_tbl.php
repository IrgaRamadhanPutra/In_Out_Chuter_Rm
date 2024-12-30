<?php

namespace App\Models\Hyundai;

use Illuminate\Database\Eloquent\Model;

class entry_print_kanban_tbl extends Model
{
    //
    protected $connection = 'hyundai';
    protected $table = 'entry_print_kanban';
    protected $fillable = [
        'id', 'ekanban_no', 'seq', 'mpname', 'created_by', 'creation_date', 'last_updated_by', 'last_updated_date', 'kanban_qty'
    ];
    protected $primaryKey = 'id';
    public $timestamps = false;
}
