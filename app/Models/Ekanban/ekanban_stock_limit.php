<?php

namespace App\Models\Ekanban;

use Illuminate\Database\Eloquent\Model;

class ekanban_stock_limit extends Model
{
    //
    protected $connection = 'ekanban';
    protected $table = 'ekanban_stock_limit';
    protected $fillable = [
        'id', 'chutter_address', 'period', 'itemcode', 'part_number', 'part_name', 'part_type', 'cust_code', 'min', 'max',
        'is_active', 'action_name', 'action_user', 'action_date'
    ];
    protected $primaryKey = 'id';
    public $timestamps = false;
}
