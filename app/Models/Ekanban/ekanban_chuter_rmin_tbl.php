<?php

namespace App\Models\Ekanban;

use Illuminate\Database\Eloquent\Model;

class ekanban_chuter_rmin_tbl extends Model
{
    //
    protected $connection = 'ekanban';
    protected $table = 'ekanban_chuter_rmin_tbl';
    protected $fillable = [
        'id',
        'part_name',
        'item_code',
        'kanban_no',
        'chutter_address',
        'seq',
        'qty',
        'mpname',
        'created_by',
        'creation_date',
        'last_updated_by',
        'last_updated_date',
        'status'
    ];
    protected $primaryKey = 'id';
    public $timestamps = false;
}
