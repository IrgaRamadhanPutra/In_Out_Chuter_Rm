<?php

namespace App\Http\Controllers;

use App\Models\Ekanban\Chuter_overflow_in_out_log;
use App\Models\Ekanban\ekanban_fgin_tbl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ScanOutOverflowController extends Controller
{
    //
    public function index()
    {
        return view('scan-out-overflow.index');
    }

    public function validasi_data_overflow(Request $request)
    {
        $getKanban = $request->getKanban;
        $getSquence = $request->getSquence;

        $overflow = "OVERFLOW";
        $get_data_over = ekanban_fgin_tbl::where('kanban_no', $getKanban)
            ->where('seq', $getSquence)
            ->where('chutter_address', $overflow)
            ->select('chutter_address')
            ->first();

        return response()->json(['get_data_over' => $get_data_over ? $get_data_over->chutter_address : ""]);
    }

    public function validasi_data_out_overflow(Request $request)
    {
        // Retrieve input values from the request
        $getKanban = $request->getKanban;
        $getSquence = $request->getSquence;

        // Query the database for the specified kanban and sequence
        $get_data_out_over = Chuter_overflow_in_out_log::where('kanban_no', $getKanban)
            ->where('seq', $getSquence)
            ->select('seq')
            ->first();

        // Prepare the response as a JSON object with a consistent structure
        return response()->json(['get_data_out_over' => $get_data_out_over ? $get_data_out_over->seq : ""]);
    }


    public function validasi_fifo_out_overflow(Request $request)
    {
        // dd($request);
        $getKanban = $request->getKanban;
        $getSquence = $request->getSquence;
        $overflow = "OVERFLOW";
        $getDateforinput = ekanban_fgin_tbl::leftJoin('ekanban_piprodinlog_tbl', function ($join) {
            $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_piprodinlog_tbl.ekanban_no')
                ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_piprodinlog_tbl.seq');
        })
            ->leftJoin('hyundai.entry_print_kanban', function ($join) {
                $join->on('ekanban_fgin_tbl.kanban_no', '=', 'entry_print_kanban.ekanban_no')
                    ->on('ekanban_fgin_tbl.seq', '=', 'entry_print_kanban.seq');
            })
            ->leftJoin('ekanban_fgprinted_log_tbl', function ($join) {
                $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_fgprinted_log_tbl.ekanban_no')
                    ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_fgprinted_log_tbl.seq');
            })
            ->selectRaw('COALESCE(ekanban_piprodinlog_tbl.creation_date, entry_print_kanban.creation_date, ekanban_fgprinted_log_tbl.creation_date) as creation_date')
            ->where('ekanban_fgin_tbl.kanban_no', '=', $getKanban)
            ->where('ekanban_fgin_tbl.seq', '=', $getSquence)
            ->whereNull('ekanban_fgin_tbl.last_updated_date')
            ->where('ekanban_fgin_tbl.chutter_address', $overflow)
            ->first();

        // cutoff date kanbaan pada kolom
        $cutOffdate = '2024-05-10';

        $getDatafordatabase = ekanban_fgin_tbl::leftJoin('ekanban_piprodinlog_tbl', function ($join) {
            $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_piprodinlog_tbl.ekanban_no')
                ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_piprodinlog_tbl.seq');
        })
            ->leftJoin('hyundai.entry_print_kanban', function ($join) {
                $join->on('ekanban_fgin_tbl.kanban_no', '=', 'entry_print_kanban.ekanban_no')
                    ->on('ekanban_fgin_tbl.seq', '=', 'entry_print_kanban.seq');
            })
            ->leftJoin('ekanban_fgprinted_log_tbl', function ($join) {
                $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_fgprinted_log_tbl.ekanban_no')
                    ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_fgprinted_log_tbl.seq');
            })
            ->selectRaw('COALESCE(ekanban_piprodinlog_tbl.creation_date, entry_print_kanban.creation_date, ekanban_fgprinted_log_tbl.creation_date) as creation_date')
            ->where('ekanban_fgin_tbl.kanban_no', $getKanban)
            ->whereNull('ekanban_fgin_tbl.last_updated_date')
            ->where('ekanban_fgin_tbl.chutter_address', $overflow)
            ->where('ekanban_fgin_tbl.creation_date', '>', $cutOffdate) // Use '>' comparison here
            ->orderBy('ekanban_fgin_tbl.creation_date', 'asc')
            ->first();
        // dd($getDatafordatabase);
        $creationDate = $getDateforinput->creation_date;

        // Mengekstrak tanggal dari "creation_date"
        $dateParts = explode(" ", $creationDate);
        $dateInput = $dateParts[0];
        // dd($)
        $creationDate1 = $getDatafordatabase->creation_date;

        // Mengekstrak tanggal dari "creation_date"
        $dateParts = explode(" ", $creationDate1);
        $dateBase = $dateParts[0];
        // dd($dateBase);
        if ($dateInput === $dateBase) {
            // Data cocok, gunakan data dari $selectedData
            $response = ["message" => "success"];
        } else {
            // Data tidak cocok
            $response = ["message" => "error",  "date" => $dateBase];
        }
        // dd($response);
        return response()->json($response);
        // dd($get_data_out_over);
        return response()->json();
    }

    public function add_out_overflow(Request $request)
    {
        // Set the default timezone
        date_default_timezone_set("Asia/Jakarta");

        // Begin database transaction
        DB::beginTransaction();

        try {
            // $out_overflow = "OVERFLOW_OUT";
            $out_overflow = "";

            // Retrieve inputs from the request
            $partNos = $request->input('part_no');
            $quantities = $request->input('Qty');
            $sequences = $request->input('Squence');
            $kanbanNos = $request->input('Kanban');

            // Update chutter address in ekanban_fgin_tbl
            foreach ($kanbanNos as $index => $kanbanNo) {
                ekanban_fgin_tbl::where('kanban_no', $kanbanNo)
                    ->where('seq', $sequences[$index])
                    ->update(['chutter_address' => $out_overflow]);
            }

            // Current date and time
            $outDate = Carbon::now();

            // Update chutter address and out_datetime in Chuter_overflow_in_out_log
            foreach ($kanbanNos as $index => $kanbanNo) {
                Chuter_overflow_in_out_log::where('kanban_no', $kanbanNo)
                    ->where('seq', $sequences[$index])
                    ->update([
                        'out_datetime' => $outDate
                    ]);
            }

            // Commit the transaction
            DB::commit();

            // Return a success response
            return response()->json(['message' => 'successfully'], 200);
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollback();

            // Return an error response
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 400);
        }
    }

}
