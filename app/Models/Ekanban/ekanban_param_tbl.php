<?php

namespace App\Models\Ekanban;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ekanban_param_tbl extends Model
{

    // Specify the table associated with the model
    protected $connection = 'ekanban';
    protected $table = 'ekanban_param_tbl';

    protected $fillable = [
        'production_line',
        'ekanban_no',
        'okanban_no',
        'item_code',
        'oitem_code',
        'part_no',
        'part_name',
        'model',
        'customer',
        'lot_size',
        'qty_kanban',
        'lead_time',
        'line_code',
        'nextline_code',
        'line_code_pw',
        'nextline_code_pw',
        'part_status',
        'box_type',
        'created_by',
        'creation_date',
        'last_updated_by',
        'last_updated_date',
        'kanban_type',
        'bf_process',
        'base_unit',
        'sloc',
    ];
    protected $primaryKey = 'id';

    // Disable the timestamps if your table does not have created_at and updated_at columns
    public $timestamps = false;

    // Specify the fillable fields for mass assignment

}
