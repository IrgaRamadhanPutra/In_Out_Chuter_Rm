<?php

namespace App\Models\Ekanban;

use Illuminate\Database\Eloquent\Model;

class ekanban_transrm_chuter_out extends Model
{
    // Specify the table name if it's not the pluralized form of the model name
    protected $connection = 'ekanban';
    protected $table = 'ekanban_transrm_chuter_out';

    // Define the primary key if it's not 'id'
    protected $primaryKey = 'id';

    // If the primary key is not an integer, you can specify its type
    public $incrementing = true;
    protected $keyType = 'bigint';

    // Disable timestamps if 'created_at' and 'updated_at' are not used
    public $timestamps = false;

    // Specify the fillable fields for mass assignment
    protected $fillable = [
        'bpb_no',
        'part_name',
        'item_code',
        'kanban_no',
        'seq',
        'qty',
        'mpname',
        'from_sloc',
        'to_sloc',
        'created_by',
        'creation_date',
        'last_updated_by',
        'last_updated_date',
        'doc_no',
        'chutter_address'
    ];

    // You can add any additional relationships, accessors, or methods below
}
