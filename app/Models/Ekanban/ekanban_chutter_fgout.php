<?php

namespace App\Models\Ekanban;

use Illuminate\Database\Eloquent\Model;

class ekanban_chutter_fgout extends Model
{
    //
    protected $connection = 'ekanban';
    protected $table = 'ekanban_chutter_fgout';
    protected $fillable = [
        'id', 'part_no', 'item_code', 'kanban_no', 'seq', 'qty', 'mpname', 'created_by', 'creation_date', 'last_updated_by', 'last_updated_date', 'fg_trans', 'date_export', 'reset', 'reset_uid'
    ];
    protected $primaryKey = 'id';
    public $timestamps = false;
}
