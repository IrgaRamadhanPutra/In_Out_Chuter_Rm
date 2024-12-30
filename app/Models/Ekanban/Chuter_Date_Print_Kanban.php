<?php

namespace App\Models\Ekanban;

use Illuminate\Database\Eloquent\Model;

class Chuter_Date_Print_Kanban extends Model
{
    //
    protected $connection = 'ekanban';
    protected $table = 'chuter_date_print_kanban';
    protected $fillable = [
        'id', 'kanban_no','seq', 'kanban_print','qty', 'created_date', 'created_by'
    ];
    protected $primaryKey = 'id';
    public $timestamps = false;
}
