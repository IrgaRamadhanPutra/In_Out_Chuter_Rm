<?php

namespace App\Models\Ekanban;

use Illuminate\Database\Eloquent\Model;

class Chuter_overflow_in_out_log extends Model
{
    //
    protected $connection = 'ekanban';
    protected $table = 'chuter_overflow_in_out_log';
    protected $fillable = [
        'id', 'kanban_no','seq', 'in_datetime', 'out_datetime', 'created_by'
    ];
    protected $primaryKey = 'id';
    public $timestamps = false;
}
