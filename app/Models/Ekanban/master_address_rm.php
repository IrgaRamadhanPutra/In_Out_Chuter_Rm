<?php

namespace App\Models\Ekanban;

use Illuminate\Database\Eloquent\Model;

class master_address_rm extends Model
{
    // Define the table associated with this model
    protected $connection = 'ekanban';
    protected $table = 'master_address_rm';

    // Define the primary key for the table
    protected $primaryKey = 'id';

    // Disable timestamps if the table does not have `created_at` and `updated_at`
    public $timestamps = false;

    // Define the fields that can be mass assigned
    protected $fillable = [
        'chuter_address',
        'itemcode',
        'part_no',
        'part_name',
        'part_type',
        'process_code',
        'cust_code',
        'supplier',
        'kanban_type',
        'action_name',
        'created_date',
        'upate_date',
        'upadate_by',
        'void',
        'size'
    ];

    // Optionally, you can cast the date fields to datetime objects
    protected $casts = [
        'created_date' => 'datetime',
        'upate_date' => 'datetime',
        'void' => 'datetime',
    ];
}
