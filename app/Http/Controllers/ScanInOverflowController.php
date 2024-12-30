<?php

namespace App\Http\Controllers;

use App\Ekanban\Chuter_overflow_in_out_log;
use App\Models\Ekanban\ekanban_fg_tbl;
use App\Models\Ekanban\ekanban_fgin_tbl;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScanInOverflowController extends Controller
{
    //
    public function index()
    {
        return view('scan-in-overflow.index');
    }

    public function validasi_itemcode_fgin(Request $request)
    {
        // dd($request);
        $getSquence = $request->getSquence;
        $getItemcode = $request->getItemcode;
        $getKanban =$request->getKanban;

        $getChutterforfgin = ekanban_fgin_tbl::where('item_code', $getItemcode)
            ->where('seq', $getSquence)
            ->select('chutter_address')
            ->first();

            if ($getChutterforfgin == null) {
                // Data is not present in the table
                $response = ["message" => "data_not"];
            } elseif ($getChutterforfgin->chutter_address === null) {
                // Chutter address column is null, validate against chuter_overflow_in_out_log
                $get_out_overflow = Chuter_overflow_in_out_log::where('kanban_no', $getKanban)
                    ->where('seq', $getSquence)
                    ->select('out_datetime')
                    ->first();

                if ($get_out_overflow !== null) {
                    // Data found in chuter_overflow_in_out_log
                    $response = ["message" => "out_overflow"];
                } else {
                    // No data found in chuter_overflow_in_out_log
                    $response = ["message" => "null"];
                }
            } elseif ($getChutterforfgin->chutter_address === 'OVERFLOW') {
                // Chutter address is 'OVERFLOW'
                $response = ["message" => "Already"];
            } else {
                // Chutter address is not null
                $response = ["message" => "not_null"];
            }

            // Return the response as JSON
            return response()->json($response);
        // dd($response);
        return response()->json($response);
    }

    public function add_overflow(Request $request)
    {
        // Set timezone
        date_default_timezone_set("Asia/Jakarta");

        // Mulai transaksi
        DB::beginTransaction();

        try {
            // Tetapkan nilai overflow
            $overflow = "OVERFLOW";

            // Ambil input dari request
            $partNos = $request->input('part_no');
            $quantities = $request->input('Qty');
            $sequences = $request->input('Squence');
            $kanbanNos = $request->input('Kanban');

            // Update chutter address dengan Eloquent
            foreach ($kanbanNos as $index => $kanbanNo) {
                ekanban_fgin_tbl::where('kanban_no', $kanbanNo)
                    ->where('seq', $sequences[$index])
                    ->update(['chutter_address' => $overflow]);
            }

            // Siapkan data untuk diinsert ke ChuterOverflowInOutLog
            $inDate = Carbon::now();
            $createdBy = Auth::user()->user;
            $dataToInsert = [];

            foreach ($kanbanNos as $index => $kanbanNo) {
                $dataToInsert[] = [
                    'kanban_no' => $kanbanNo,
                    'seq' => $sequences[$index],
                    'in_datetime' => $inDate,
                    'created_by' => $createdBy,
                ];
            }

            // Insert data ke ChuterOverflowInOutLog
            Chuter_overflow_in_out_log::insert($dataToInsert);

            // Commit transaksi
            DB::connection('ekanban')->commit();

            // Kembalikan response JSON
            return response()->json(['message' => 'Successful'], 200);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::connection('ekanban')->rollback();

            // Kembalikan response error
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 400);
        }
    }

}
