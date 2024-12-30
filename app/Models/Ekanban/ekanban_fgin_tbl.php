<?php

namespace App\Models\Ekanban;

use Illuminate\Database\Eloquent\Model;

class ekanban_fgin_tbl extends Model
{
    //
    protected $connection = 'ekanban';
    protected $table = 'ekanban_fgin_tbl';
    protected $fillable = [
        'id', 'part_no', 'item_code', 'kanban_no', 'chutter_address', 'seq', 'qty', 'mpname', 'created_by', 'creation_date', 'last_updated_by', 'last_updated_date', 'fg_trans', 'date_export', 'reset', 'reset_uid',
        'to_no','kanban_print'
    ];
    protected $primaryKey = 'id';
    public $timestamps = false;

    // public static function getDataForDatabase($getItemcode)
    // {
    //     // Query pertama
    //     $getDataForDatabase = self::where('item_code', $getItemcode)
    //         ->whereNull('last_updated_date')
    //         ->where('chutter_address', '!=', '')
    //         ->leftJoin('ekanban_piprodinlog_tbl', function ($join) {
    //             $join->on('kanban_no', '=', 'ekanban_piprodinlog_tbl.ekanban_no')
    //                 ->on('seq', '=', 'ekanban_piprodinlog_tbl.seq');
    //         })
    //         ->select('kanban_no', 'ekanban_piprodinlog_tbl.creation_date')
    //         ->orderBy('ekanban_piprodinlog_tbl.seq', 'asc')
    //         ->first();

    //     // Jika getDataForDatabase pertama kosong atau creation_date kosong, gunakan getDataForDatabase kedua
    //     if ($getDataForDatabase === null || $getDataForDatabase->creation_date === null) {
    //         $getDataForDatabase = self::where('item_code', $getItemcode)
    //             ->whereNull('last_updated_date')
    //             ->where('chutter_address', '!=', '')
    //             ->leftJoin('hyundai.entry_print_kanban', function ($join) {
    //                 $join->on('kanban_no', '=', 'hyundai.entry_print_kanban.ekanban_no')
    //                     ->on('seq', '=', 'hyundai.entry_print_kanban.seq');
    //             })
    //             ->select('kanban_no', 'hyundai.entry_print_kanban.creation_date')
    //             ->orderBy('hyundai.entry_print_kanban.seq', 'asc')
    //             ->first();
    //     }

    //     return $getDataForDatabase;
    // }


    // public static function getDataForInput($getItemcode, $getSquence)
    // {
    //     // Data dari tabel ekanban_fgin_tbl yang di-join dengan ekanban_piprodinlog_tbl
    //     $getDataForInput = self::where('item_code', $getItemcode)
    //         ->where('seq', $getSquence)
    //         ->where('chutter_address', '!=', '')
    //         ->leftJoin('ekanban_piprodinlog_tbl', function ($join) {
    //             $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_piprodinlog_tbl.ekanban_no')
    //                 ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_piprodinlog_tbl.seq');
    //         })
    //         ->select('kanban_no', 'chutter_address', 'ekanban_piprodinlog_tbl.seq', 'ekanban_piprodinlog_tbl.creation_date')
    //         ->orderBy('seq', 'asc')
    //         ->first();

    //     // Jika data untuk inputan null atau creation_date null, gunakan data dari tabel hyundai.entry_print_kanban
    //     if ($getDataForInput === null || $getDataForInput->creation_date === null) {
    //         $getDataForInput = self::where('item_code', $getItemcode)
    //             ->where('seq', $getSquence)
    //             ->whereNull('last_updated_date')
    //             ->where('chutter_address', '!=', '')
    //             ->leftJoin('hyundai.entry_print_kanban', function ($join) {
    //                 $join->on('ekanban_fgin_tbl.kanban_no', '=', 'hyundai.entry_print_kanban.ekanban_no')
    //                     ->on('ekanban_fgin_tbl.seq', '=', 'hyundai.entry_print_kanban.seq');
    //             })
    //             ->select('part_no', 'item_code', 'hyundai.entry_print_kanban.ekanban_no', 'hyundai.entry_print_kanban.seq', 'chutter_address', 'hyundai.entry_print_kanban.creation_date')
    //             ->orderBy('hyundai.entry_print_kanban.seq', 'asc')
    //             ->first();
    //     }

    //     return $getDataForInput;
    // }
    public static function getDataForDatabase($getItemcode, $getKanban)
    {
        // Your logic for fetching data from the database goes here
        $data = self::where('ekanban_fgin_tbl.item_code', $getItemcode)
            ->where('ekanban_fgin_tbl.kanban_no', $getKanban)
            ->whereNull('ekanban_fgin_tbl.last_updated_date')  // Specify the table alias for last_updated_date
            ->where('ekanban_fgin_tbl.chutter_address', '!=', '')
            ->leftJoin('ekanban_piprodinlog_tbl', function ($join) {
                $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_piprodinlog_tbl.ekanban_no')
                    ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_piprodinlog_tbl.seq');
            })
            ->select('ekanban_fgin_tbl.kanban_no', 'ekanban_piprodinlog_tbl.creation_date')
            ->first();

        // If data for input is null or creation_date is null, use data from hyundai.entry_print_kanban
        if ($data === null || $data->creation_date === null) {
            $data = self::where('ekanban_fgin_tbl.item_code', $getItemcode)
                ->whereNull('ekanban_fgin_tbl.last_updated_date')  // Specify the table alias for last_updated_date
                ->where('ekanban_fgin_tbl.chutter_address', '!=', '')
                ->leftJoin('hyundai.entry_print_kanban', function ($join) {
                    $join->on('ekanban_fgin_tbl.kanban_no', '=', 'hyundai.entry_print_kanban.ekanban_no')
                        ->on('ekanban_fgin_tbl.seq', '=', 'hyundai.entry_print_kanban.seq');
                })
                ->select('hyundai.entry_print_kanban.ekanban_no', 'hyundai.entry_print_kanban.creation_date')
                ->orderBy('hyundai.entry_print_kanban.seq', 'asc')
                ->first();
        }

        return $data;
    }
}
