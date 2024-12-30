<?php

namespace App\Models\Ekanban;

use Illuminate\Database\Eloquent\Model;

class Ekanban_chutteraddressing_tbl extends Model
{
    //
    protected $connection = 'ekanban';
    protected $table = 'ekanban_chutteraddressing_tbl';
    protected $fillable = [
        'id', 'chutter_code', 'job_number', 'kanban_no', 'part_no', 'part_name', 'model', 'cust_code', 'prev_process', 'qty_kbn', 'item_code', 'image_url', 'register_user', 'register_date', 'update_user', 'update_date'
    ];
    protected $primaryKey = 'id';
    public $timestamps = false;
}
