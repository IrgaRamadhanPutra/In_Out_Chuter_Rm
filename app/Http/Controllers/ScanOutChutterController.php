<?php

namespace App\Http\Controllers;

use App\Models\Ekanban\chuter_in_out_log;
use App\Models\Ekanban\ekanban_chutter_fgout;
use App\Models\Ekanban\ekanban_fg_chuter_tbl;
use App\Models\Ekanban\ekanban_fgin_tbl;
use App\Models\Ekanban\Ekanban_fgout_tbl;
use App\Models\Ekanban\Ekanban_piprodinlog_tbl;
use App\Models\Ekanban\ekanban_stock_limit;
use App\Models\Ekanban\Master_access_chuter;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class ScanOutChutterController extends Controller
{
    //
    public function index()
    {
        return view('scan-out-chutter-rm.index');
    }
    public function validasi_access_account3(Request $request)
    {
        $cut_code = $request->getCustcode;

        $get_user = Auth::user()->user;
        $status = 'ACTIVE';
        // dd($cut_code);
        $validasi_custcode = Master_access_chuter::where('user', $get_user)
            ->where('status', $status)
            ->select('access_cust')
            ->first();

        // $response = []; // Initialize the response array

        // Validate that the result is not null and access_cust is not empty
        if ($validasi_custcode !== null && !empty($validasi_custcode->access_cust)) {
            // Split the access_cust string into an array
            $accessCustArray = explode(',', $validasi_custcode->access_cust);

            // Check if the cut_code is in the array
            if (in_array($cut_code, $accessCustArray)) {
                // Prepare the success response
                $response = ["message" => "success"];
            } else {
                // Prepare the error response if the code is not found
                $response = ["message" => "error", "detail" => "User Login No Access For This Customer"];
            }
        } else {
            // Prepare the error response if no record is found or access_cust is empty
            $response = ["message" => "error", "detail" => "No valid User Login"];
        }

        // Debugging: Dump the response array
        // dd($response);

        // Return the response as JSON
        return response()->json($response);
    }

    public function validasi_access_account4(Request $request)
    {
        $cut_code = $request->getCustcode;

        $get_user = Auth::user()->user;
        $status = 'ACTIVE';
        // dd($cut_code);
        $validasi_custcode = Master_access_chuter::where('user', $get_user)
            ->where('status', $status)
            ->select('access_cust')
            ->first();

        // $response = []; // Initialize the response array

        // Validate that the result is not null and access_cust is not empty
        if ($validasi_custcode !== null && !empty($validasi_custcode->access_cust)) {
            // Split the access_cust string into an array
            $accessCustArray = explode(',', $validasi_custcode->access_cust);

            // Check if the cut_code is in the array
            if (in_array($cut_code, $accessCustArray)) {
                // Prepare the success response
                $response = ["message" => "success"];
            } else {
                // Prepare the error response if the code is not found
                $response = ["message" => "error", "detail" => "User Login No Access For This Customer"];
            }
        } else {
            // Prepare the error response if no record is found or access_cust is empty
            $response = ["message" => "error", "detail" => "No valid User Login"];
        }

        // Debugging: Dump the response array
        // dd($response);

        // Return the response as JSON
        return response()->json($response);
    }

    public function validasi_itemcode_fgout(Request $request)
    {

        $getSquence = $request->getSquence;
        $getItemcode = $request->getItemcode;
        $validasi = ekanban_chutter_fgout::where('item_code', $getItemcode)
            ->where('seq', $getSquence)
            ->select('item_code', 'seq')
            ->first();
        if (is_null($validasi)) {
            $validasi = "";
        }
        // dd($validasi);
        return response()->json($validasi);
    }
    public function validasi_chuterr_address(Request $request)
    {
        $getSquence = $request->getSquence;
        $getItemcode = $request->getItemcode;
        $validasi_chutter_address = ekanban_fgin_tbl::where('item_code', $getItemcode)
            // ->where('chutter_address', '!=', '')
            ->where('seq', $getSquence)
            ->select('chutter_address')
            ->first();
        $validasi = ($validasi_chutter_address == null || $validasi_chutter_address->chutter_address == null) ? "" : $validasi_chutter_address->chutter_address;

        return response()->json($validasi);
    }

    public function validasi_fifo_lokal(Request $request)
    {

        $getSquence = $request->getSquence;
        $getItemcode = $request->getItemcode;
        $getKanban = $request->getKanban;

        // $getDatafordatabase = ekanban_fgin_tbl::leftJoin('ekanban_piprodinlog_tbl', function ($join) {
        //     $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_piprodinlog_tbl.ekanban_no')
        //         ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_piprodinlog_tbl.seq');
        // })
        // ->leftJoin('hyundai.entry_print_kanban', function ($join) {
        //     $join->on('ekanban_fgin_tbl.kanban_no', '=', 'entry_print_kanban.ekanban_no')
        //         ->on('ekanban_fgin_tbl.seq', '=', 'entry_print_kanban.seq');
        // })
        // ->leftJoin('ekanban_fgprinted_log_tbl', function ($join) {
        //     $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_fgprinted_log_tbl.ekanban_no')
        //         ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_fgprinted_log_tbl.seq');
        // })
        // ->select(
        //     'ekanban_fgin_tbl.kanban_no',
        //     DB::raw('COALESCE(ekanban_piprodinlog_tbl.creation_date, entry_print_kanban.creation_date, ekanban_fgprinted_log_tbl.creation_date) AS creation_date')
        // )
        // ->where('ekanban_fgin_tbl.chutter_address', '!=', '')
        // ->where('ekanban_fgin_tbl.item_code', $getItemcode)
        // ->whereNull('ekanban_fgin_tbl.last_updated_date')
        // ->where('ekanban_fgin_tbl.kanban_no', $getKanban)
        // ->orderBy(DB::raw('COALESCE(ekanban_piprodinlog_tbl.creation_date, entry_print_kanban.creation_date, ekanban_fgprinted_log_tbl.creation_date)'), 'asc')
        // ->first();

        // $getDataForInput = ekanban_fgin_tbl::leftJoin('ekanban_piprodinlog_tbl', function ($join) {
        //     $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_piprodinlog_tbl.ekanban_no')
        //         ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_piprodinlog_tbl.seq');
        // })
        //     ->leftJoin('hyundai.entry_print_kanban', function ($join) {
        //         $join->on('ekanban_fgin_tbl.kanban_no', '=', 'entry_print_kanban.ekanban_no')
        //             ->on('ekanban_fgin_tbl.seq', '=', 'entry_print_kanban.seq');
        //     })
        //     ->leftJoin('ekanban_fgprinted_log_tbl', function ($join) {
        //         $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_fgprinted_log_tbl.ekanban_no')
        //             ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_fgprinted_log_tbl.seq');
        //     })
        //     ->select(
        //         'ekanban_fgin_tbl.kanban_no',
        //         DB::raw('COALESCE(ekanban_piprodinlog_tbl.creation_date, entry_print_kanban.creation_date, ekanban_fgprinted_log_tbl.creation_date) AS creation_date')
        //     )
        //     ->where('ekanban_fgin_tbl.seq', $getSquence)
        //     ->where('ekanban_fgin_tbl.chutter_address', '!=', '')
        //     ->whereNull('ekanban_fgin_tbl.last_updated_date')
        //     ->where('ekanban_fgin_tbl.item_code', $getItemcode)
        //     ->where('ekanban_fgin_tbl.kanban_no', $getKanban)
        //     // ->orderBy('ekanban_fgin_tbl.seq', 'asc')
        //     ->first();

        // GET tgl print kanban dari database langusung
        $getDatafordatabase = ekanban_fgin_tbl::select('kanban_print as creation_date', 'kanban_no')
            ->where('kanban_no', '=', $getKanban)
            ->whereNull('last_updated_date')
            ->whereNotNull('chutter_address')
            ->orderBy('kanban_print', 'asc')
            ->first();
        // dd($getDatafordatabase);
        // GET tgl print kanban dari inputan
        $getDataForInput = ekanban_fgin_tbl::select('kanban_print as creation_date')
            ->where('kanban_no', '=', $getKanban)
            ->where('seq', '=', $getSquence)
            ->where('chutter_address', '!=', '')
            ->whereNull('last_updated_date')
            ->first();

        // Inisialisasi variabel tanggal dari data
        $dateDatabase = null;
        // Jika data tidak null, ambil tanggal dari data
        if ($getDatafordatabase !== null && isset($getDatafordatabase->creation_date)) {
            $dateArray = explode(" ", $getDatafordatabase->creation_date);
            $dateDatabase = $dateArray[0];
        }
        // Inisialisasi variabel tanggal dari data
        $dateInput = null;
        // Jika data tidak null, ambil tanggal dari data
        if ($getDataForInput !== null) {
            $dateArray = explode(" ", $getDataForInput->creation_date);
            $dateInput = $dateArray[0];
        }
        // dd($dateInput);
        // dd($dateDatabase);
        // Jika data untuk inputan tidak null, ambil tanggal dari data
        // dd($dateInput);
        // Bandingkan tanggal dari kedua data
        // dd($selectedData);
        if ($dateDatabase === $dateInput) {
            // Data cocok, gunakan data dari $selectedData
            $response = ["message" => "success"];
        } else {
            // Data tidak cocok
            $response = ["message" => "error", "data" => $getDatafordatabase, "date" => $dateDatabase];
        }
        // } else {
        //     $response = ["message" => "error_chutter"];
        // }


        // Output response
        // dd($response);
        return response()->json($response);
    }


    public function validasi_itemcode_fgout1(Request $request)
    {

        $getSquence = $request->getSquence;
        $getItemcode = $request->getItemcode;
        $validasi = ekanban_chutter_fgout::where('item_code', $getItemcode)
            ->where('seq', $getSquence)
            ->where('last_updated_date', NULL)
            ->select('item_code')
            ->first();
        $validasi = $validasi ? $validasi->item_code : "";

        if (is_null($validasi)) {
            $validasi = "";
        }

        return response()->json($validasi);
    }

    public function validasi_chuterr_address1(Request $request)
    {
        $getSquence = $request->getSquence;
        $getItemcode = $request->getItemcode;
        $validasi_chutter_address = ekanban_fgin_tbl::where('item_code', $getItemcode)
            // ->where('chutter_address', '!=', '')
            ->where('seq', $getSquence)
            ->select('chutter_address')
            ->first();
        $validasi = ($validasi_chutter_address == null || $validasi_chutter_address->chutter_address == null) ? "" : $validasi_chutter_address->chutter_address;

        return response()->json($validasi);
    }
    public function validasi_fifo_lokal1(Request $request)
    {
        // dd($request);
        // data pada inputan
        $getSquence = $request->getSquence;
        $getItemcode = $request->getItemcode;
        $getKanban = $request->getKanban;
        $getKanban = $request->getKanban;
        // data pada tabel
        $tabelSquence = $request->tabelSquence;
        $tabelItemcode = $request->tabelItemcode;
        $tabelKanban = $request->tabelKanban;

        // VALIDASI INPUTAN DAN TABEL
        // get date for inputan to tbl fg in
        $getDataForInput = ekanban_fgin_tbl::select('kanban_print as creation_date')
            ->where('kanban_no', '=', $getKanban)
            ->where('seq', '=', $getSquence)
            ->where('chutter_address', '!=', '')
            ->whereNull('last_updated_date')
            ->first();

        // get date for tabel to tbl fg in
        $getDatafordatabase = ekanban_fgin_tbl::select('kanban_print as creation_date', 'kanban_no')
            ->where('kanban_no', '=', $tabelKanban)
            ->where('seq', '=', $tabelSquence)
            ->where('chutter_address', '!=', '')
            ->whereNull('last_updated_date')
            ->first();

        // Inisialisasi variabel tanggal dari data
        $dateDatabase = null;
        // Jika data tidak null, ambil tanggal dari data
        if ($getDatafordatabase !== null && isset($getDatafordatabase->creation_date)) {
            $dateArray = explode(" ", $getDatafordatabase->creation_date);
            $dateDatabase = $dateArray[0];
        }
        // Inisialisasi variabel tanggal dari data
        $dateInput = null;
        // Jika data tidak null, ambil tanggal dari data
        if ($getDataForInput !== null) {
            $dateArray = explode(" ", $getDataForInput->creation_date);
            $dateInput = $dateArray[0];
        }
        // Bandingkan tanggal dari kedua data
        if ($dateDatabase === $dateInput) {
            // Data cocok, gunakan data dari $selectedData
            $response = ["message" => "success"];
        } else {
            // Data tidak cocok
            $response = ["message" => "error", "data" => $getDatafordatabase, "date" => $dateDatabase];
        }

        // dd($response);
        return response()->json($response);
    }
    public function validasi_itemcode_fgout2(Request $request)
    {

        $getSquence = $request->getSquence;
        $getItemcode = $request->getItemcode;
        $validasi = ekanban_chutter_fgout::where('item_code', $getItemcode)
            ->where('seq', $getSquence)
            ->select('item_code')
            ->first();
        // dd($validasi);
        $validasi = $validasi ? $validasi->item_code : "";
        if (is_null($validasi)) {
            $validasi = "";
        }
        return response()->json($validasi);
    }
    public function validasi_chuterr_address2(Request $request)
    {
        $getSquence = $request->getSquence;
        $getItemcode = $request->getItemcode;
        $validasi_chutter_address = ekanban_fgin_tbl::where('item_code', $getItemcode)
            // ->where('chutter_address', '!=', '')
            ->where('seq', $getSquence)
            ->select('chutter_address')
            ->first();
        $validasi = ($validasi_chutter_address == null || $validasi_chutter_address->chutter_address == null) ? "" : $validasi_chutter_address->chutter_address;

        return response()->json($validasi);
    }
    public function validasi_fifo_lokal2(Request $request)
    {

        // fifo creation_date
        $getSquence = $request->getSquence;
        $getItemcode = $request->getItemcode;
        $getKanban = $request->getKanban;

        // VALIDASI INPUTAN DAN DATABASE
        // GET tgl print kanban dari database langusung
        $getDatafordatabase = ekanban_fgin_tbl::select('kanban_print as creation_date', 'kanban_no')
            ->where('kanban_no', '=', $getKanban)
            ->whereNull('last_updated_date')
            ->whereNotNull('chutter_address')
            ->orderBy('kanban_print', 'asc')
            ->first();

        // GET tgl print kanban dari inputan
        $getDataForInput = ekanban_fgin_tbl::select('kanban_print as creation_date')
            ->where('kanban_no', '=', $getKanban)
            ->where('seq', '=', $getSquence)
            ->where('chutter_address', '!=', '')
            ->whereNull('last_updated_date')
            ->first();
        // Inisialisasi variabel tanggal dari data
        $dateDatabase = null;
        // Jika data tidak null, ambil tanggal dari data
        if ($getDatafordatabase !== null && isset($getDatafordatabase->creation_date)) {
            $dateArray = explode(" ", $getDatafordatabase->creation_date);
            $dateDatabase = $dateArray[0];
        }
        // Inisialisasi variabel tanggal dari data
        $dateInput = null;
        // Jika data tidak null, ambil tanggal dari data
        if ($getDataForInput !== null) {
            $dateArray = explode(" ", $getDataForInput->creation_date);
            $dateInput = $dateArray[0];
        }

        if ($dateDatabase === $dateInput) {
            // Data cocok, gunakan data dari $validasi
            $response = ["message" => "success"];
        } else {
            // Data tidak cocok
            $response = ["message" => "error", "data" => $getDatafordatabase, "date" => $dateDatabase];
        }
        // dd($response);
        return response()->json($response);
    }

    public function validasi_itemcode_fgout4(Request $request)
    {

        $getSquence = $request->getSquence;
        $getItemcode = $request->getItemcode;
        $validasi = ekanban_chutter_fgout::where('item_code', $getItemcode)
            ->where('seq', $getSquence)
            ->select('item_code')
            ->first();
        $validasi = $validasi ? $validasi->item_code : "";
        if (is_null($validasi)) {
            $validasi = "";
        }

        return response()->json($validasi);
    }
    public function validasi_chuterr_address3(Request $request)
    {
        $getSquence = $request->getSquence;
        $getItemcode = $request->getItemcode;
        $validasi_chutter_address = ekanban_fgin_tbl::where('item_code', $getItemcode)
            ->where('seq', $getSquence)
            ->select('chutter_address')
            ->first();

        $validasi = ($validasi_chutter_address == null || $validasi_chutter_address->chutter_address == null) ? "" : $validasi_chutter_address->chutter_address;


        return response()->json($validasi);
    }
    public function validasi_fifo_lokal3(Request $request)
    {
        // fifo to creation_date
        // paramter inputan
        $getSquence = $request->getSquence;
        $getItemcode = $request->getItemcode;
        $getKanban = $request->getKanban;
        $getKanban = $request->getKanban;
        // data pada tabel
        $tabelSquence = $request->tabelSquence;
        $tabelItemcode = $request->tabelItemcode;
        $tabelKanban = $request->tabelKanban;

        // VALIDASI INPUTAN DAN TABEL
        // get date for inputan to tbl fg in
        $getDataForInput = ekanban_fgin_tbl::select('kanban_print as creation_date')
            ->where('kanban_no', '=', $getKanban)
            ->where('seq', '=', $getSquence)
            ->where('chutter_address', '!=', '')
            ->whereNull('last_updated_date')
            ->first();

        // get date for tabel to tbl fg in
        $getDatafordatabase = ekanban_fgin_tbl::select('kanban_print as creation_date', 'kanban_no')
            ->where('kanban_no', '=', $tabelKanban)
            ->where('seq', '=', $tabelSquence)
            ->where('chutter_address', '!=', '')
            ->whereNull('last_updated_date')
            ->first();

        // Inisialisasi variabel tanggal dari data
        $dateDatabase = null;
        // Jika data tidak null, ambil tanggal dari data
        if ($getDatafordatabase !== null && isset($getDatafordatabase->creation_date)) {
            $dateArray = explode(" ", $getDatafordatabase->creation_date);
            $dateDatabase = $dateArray[0];
        }
        // Inisialisasi variabel tanggal dari data
        $dateInput = null;
        // Jika data tidak null, ambil tanggal dari data
        if ($getDataForInput !== null) {
            $dateArray = explode(" ", $getDataForInput->creation_date);
            $dateInput = $dateArray[0];
        }
        // dd($getDatedatabase);
        // dd($dateinput);

        // dd($getDate);

        if ($dateDatabase === $dateInput) {
            // Data cocok, gunakan data dari $validasi
            $response = ["message" => "success"];
        } else {
            // Data tidak cocok
            $response = ["message" => "error", "data" => $getDatafordatabase, "date" => $dateDatabase];
        }
        return response()->json($response);
    }
    // sudah ada log nya untuk fg out
    public function add_ekanbanChuterout(Request $request)
    {
        // dd($request);
        date_default_timezone_set("Asia/Jakarta");
        DB::connection('ekanban')->beginTransaction();
        try {

            $itemcodeLokal = $request->Itemcode[0];

            // get kanban no and part no
            $get_partno = $request->part_no[0];
            $get_kanban_no = $request->Kanban[0];



            // parameter for  ekanban fg
            $Qty = $request->input('Qty');
            $totalQty = array_sum(array_map('intval', $Qty));
            $itemcodes = $request->input('Itemcode');
            $firstItemcode = $itemcodes[0];
            $partNos = $request->input('part_no');
            $mpname = Carbon::now()->format('m-Y');

            // get data tabel fg untuk mendapatkan data
            $getfgTbl = ekanban_fg_chuter_tbl::where('item_code', $firstItemcode)
                // ->whereIn('part_no', $partNos)
                // ->where('mpname', $mpname)
                ->orderBy('creation_date', 'desc')
                ->select('stock_awal', 'in', 'out', 'id', 'mpname')
                ->first();
            // dd($getfgTbl);
            $id_fg = $getfgTbl->id;
            $stock_awal = $getfgTbl->stock_awal;
            $in = $getfgTbl->in;
            $out = $getfgTbl->out;
            $resulOut =  $totalQty +  $out;

            $balance =  $stock_awal +  $in -  $resulOut;
            //update untuk tabel fg
            $updateBalance = ekanban_fg_chuter_tbl::where('id', $id_fg)
                ->update([
                    'out' => $resulOut,
                    'balance' => $balance
                ]);
            // dd($balance);
            // lakukan entry pada in out chuter log
            $Kanban_no = $request->input('Kanban');
            $out_date = Carbon::now();
            $created_by = Auth::user()->user;
            $squences = $request->input('Squence');
            // dd($Kanban_no);
            foreach ($Kanban_no as $key => $kanban) {
                $conditions = [
                    'kanban_no' => $kanban,
                    'seq' => $squences[$key],
                ];

                $dataToUpdate = [
                    'out_datetime' => $out_date,
                    // Add other fields to be updated if needed
                ];

                chuter_in_out_log::where($conditions)->update($dataToUpdate);
            }
            // update for tabel ekanban_fgin_tbl
            $Itemcode = $request->Itemcode[0];
            // get chuter untuk ekanban fg in
            $getChutter = ekanban_stock_limit::where('itemcode', $Itemcode)
                ->select('chutter_address')
                ->first();
            $creation_date =  Carbon::now();
            $chutter_address = $getChutter->chutter_address . '_out';
            $data = ekanban_fgin_tbl::whereIn('item_code', $itemcodes)
                // ->whereIn('part_no', $partNos)
                ->whereIn('seq', $squences)
                ->select('id')
                ->get();

            // Loop melalui hasil kueri dan simpan id dalam array
            foreach ($data as $row) {
                $ids[] = $row->id;
            }

            // Cek apakah ada id yang ditemukan
            if (count($ids) > 0) {
                // Lakukan pembaruan dengan id yang ditemukan
                $data1 = ekanban_fgin_tbl::whereIn('id', $ids)
                    ->update([
                        'chutter_address' => $chutter_address,
                        'last_updated_by' => $created_by,
                        'last_updated_date' => $creation_date,
                    ]);
            }

            // lakukan entry pada ekanban fg out
            date_default_timezone_set("Asia/Jakarta");
            $Itemcode = $request->Itemcode;
            $part_no = $request->part_no;
            $Squence = $request->Squence;
            $Kanban = $request->Kanban;
            $Qty = $request->Qty;
            $mpname =  Carbon::now()->format('m-Y');
            $creation_date =  Carbon::now();
            $created_by = Auth::user()->user;
            $dataToInsert = [];

            foreach ($Itemcode as $key => $itemcodeValue) {
                $dataToInsert[] = [
                    'item_code' => $itemcodeValue,
                    'part_no' => $part_no[$key],
                    'seq' => $Squence[$key],
                    'kanban_no' => $Kanban[$key],
                    'qty' => $Qty[$key],
                    'mpname' => $mpname,
                    'created_by' => $created_by,
                    'creation_date' => $creation_date,
                ];
            }

            // Insert data into the database
            ekanban_chutter_fgout::insert($dataToInsert);

            DB::connection('ekanban')->commit();
            // get data over flow
            $cutOffdate = '2024-05-20';

            $getDataoverflow = ekanban_fgin_tbl::where('item_code', $itemcodeLokal)
                ->whereNull('last_updated_date')
                ->whereNull('chutter_address')
                ->whereDate('creation_date', $cutOffdate) // Menggunakan whereDate untuk tipe DATE
                ->select('seq')
                ->get();

            $count = $getDataoverflow->count();
            // dd($count);
            return response()->json([
                'message' => 'Data successfully processed',
                'Kanban' => $get_kanban_no,
                'part_no' => $get_partno,
                'data' => $count
            ], 200);
        } catch (\Exception $e) {
            // Handle exceptions here
            DB::connection('ekanban')->rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
        // DB::connection('ekanban')->table('ekanban_fgout_tbl')->insert($data);

    }

    public function getChutter(Request $request)
    {

        $itemLokal = $request->itemLokal;
        $getChutter = ekanban_stock_limit::where('itemcode', $itemLokal)
            ->select('chutter_address')
            ->first();

        return response()->json($getChutter);
    }
}
