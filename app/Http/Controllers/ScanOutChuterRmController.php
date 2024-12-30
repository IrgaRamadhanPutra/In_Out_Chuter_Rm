<?php

namespace App\Http\Controllers;

use App\Models\Ekanban\chuter_rm_in_out_log;
use App\Models\Ekanban\ekanban_chuter_rmin_tbl;
use App\Models\Ekanban\ekanban_chuterin_tbl;
use App\Models\Ekanban\ekanban_rm_chuter_tbl;
use App\Models\Ekanban\ekanban_transrm_chuter_out;
use App\Models\Ekanban\EkanbanTransrmChuterOut;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;

class ScanOutChuterRmController extends Controller
{
    //
    public function index()
    {
        return view('scan-out-chutter-rm.index');
    }

    public function get_datatables_outchuter(Request $request)
    {
        if ($request->ajax()) {
            $createdBy = Auth::user()->user;

            $data = ekanban_transrm_chuter_out::select(
                'id',
                'item_code',
                'part_name',
                'kanban_no',
                'seq',
                'qty',
                'to_sloc',
                'created_by'
            )
                ->whereNull('bpb_no')
                ->whereNull('doc_no')
                ->where('created_by', $createdBy)
                ->orderBy('creation_date', 'desc');

            return DataTables::of($data)
                ->rawColumns(['action'])
                ->editColumn('action', function ($data) {
                    return '
                        <a href="#"
                            data-toggle="tooltip"
                            row-id="' . $data->id . '"
                            data-itemCode="' . $data->item_code . '"
                            data-kanbanNo="' . $data->kanban_no . '"
                            data-seq="' . $data->seq . '"
                            data-placement="top"
                            title="delete"
                            class="dropdown-item delete"
                            style="display: flex; justify-content: center; align-items: center; height: 100%;">
                            <i class="ri-delete-bin-2-fill" style="color: red; font-size: 1.5em;"></i>
                        </a>';
                })
                ->make(true);
        }
    }
    public function get_data_chuter(Request $request)
    {

        if ($request->ajax()) {
            $chuter = $request->chuter;
            $data = ekanban_chuter_rmin_tbl::select('item_code', 'part_name', 'kanban_no', 'seq')
                ->where('chutter_address', $chuter) // Menambahkan klausa WHERE
                ->where('status', '=', 'IN')
                ->get();

            // dd($data);
            return DataTables::of($data)->make(true);
        }
    }
    public function check_stock_sap(Request $request)
    {
        // dd($request);

        // Get item code and quantity from the request
        $itemcode = $request->itemcode;
        $qty = intval($request->qty);

        // Get the current quantity from the database for the given item code
        $getQty = ekanban_transrm_chuter_out::select('qty')
            ->where('item_code', $itemcode)
            ->whereNull('doc_no')
            ->get();

        $resulQty = $getQty->isNotEmpty() ? $getQty->sum('qty') : 0;

        // Calculate the combined quantity
        $combinQty = $qty + $resulQty;
        // dd($combinQty);

        // Debug output to check the combined quantity
        // dd($combinQty); // Uncomment for debugging

        // Retrieve the SAP credentials from environment variables
        $sapClient = env('SAP_API_CLIENT');
        $sapUsername = env('SAP_API_USERNAME');
        $sapPassword = env('SAP_API_PASSWORD');

        // Build the API URL
        $apiUrl = 'http://149.129.247.175:8001/sap/zapi/ZMM_TCH_STOCK';

        // Set the query parameters for the API request
        $params = [
            'sap-client' => $sapClient,
            'sap-user' => $sapUsername,
            'sap-password' => $sapPassword,
            'MATERIAL_NO' => $itemcode,
            'PLANT' => '1701',
            'SLOC' => '1010'
        ];

        // Make a GET request to the API with query parameters
        $response = Http::get($apiUrl, $params);

        // Get the JSON response data
        $data = $response->json();

        // Access data directly from 'la_output'
        // $materialNo = $data['la_output']['material_no'] ?? null;
        $quantity = $data['la_output']['quantity'] ?? null;
        // $sloc = $data['la_output']['sloc'] ?? null;
        // $plant = $data['la_output']['plant'] ?? null;
        // dd($combinQty);
        // dd($quantity);

        // Check if the combined quantity exceeds the quantity from the SAP response
        if ($combinQty > $quantity) {
            // Jika combinQty lebih besar dari quantity, tetap respond dengan status success tetapi menandai error
            return response()->json([
                'status' => 'error',
                'message' => 'Combined quantity exceeds the allowed quantity.',
            ]); // Tanpa kode status 400, agar dianggap sukses
        } else {
            // Jika combinQty kurang dari atau sama dengan quantity, respond dengan sukses
            return response()->json([
                'status' => 'success',
                'message' => 'success'
            ]);
        }
    }

    public function create_data_out_transit(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        // Set zona waktu ke Jakarta
        $currentDateTime = Carbon::now();

        // Generate mpname dalam format bulan-tahun (misal: 10-2024)
        $mpname = $currentDateTime->format('m-Y');

        // Ambil data pengguna yang login
        $createdBy = Auth::user()->user; // atau gunakan Auth::id() jika menggunakan ID

        // Mulai transaksi
        DB::beginTransaction();
        $fromSloc = '1010';

        try {
            // Masukkan data ke tabel ekanban_transrm_chuter_out
            DB::connection('ekanban')->table('ekanban_transrm_chuter_out')->insert([
                'part_name'       => $request->input('partCreate'),
                'item_code'       => $request->input('itemcodeCreate'),
                'kanban_no'       => $request->input('kanbanCreate'),
                'seq'             => $request->input('seqCreate'),
                'qty'             => $request->input('qtyCreate'),
                'from_sloc'       => $fromSloc,
                'to_sloc'         => $request->input('slocCreate'),
                'mpname'          => $mpname,
                'created_by'      => $createdBy,
                'creation_date'   => $currentDateTime,
                'chutter_address' => $request->input('chuterCreate'),
            ]);

            // Update in chuter tbl
            $status = "OUT";
            $updateBy = Auth::user()->user;
            $updateDate = Carbon::now();

            ekanban_chuter_rmin_tbl::where('item_code', $request->input('itemcodeCreate'))
                ->where('seq', $request->input('seqCreate'))
                ->update([
                    'status'             => $status,
                    'last_updated_by'    => $updateBy,
                    'last_updated_date'  => $updateDate,
                ]);


            // Update chuter log tbl
            chuter_rm_in_out_log::where('kanban_no', $request->input('kanbanCreate'))
                ->where('seq', $request->input('seqCreate'))
                ->update([
                    'out_datetime' => $updateDate,
                ]);

            // Update stock in ekanban_rm_chuter_tbl
            $getRmTbl = ekanban_rm_chuter_tbl::where('item_code', $request->input('itemcodeCreate'))
                // ->where('mpname', $mpname)
                ->select('stock_awal', 'in', 'out', 'id', 'item_code', 'balance')
                ->orderBy('creation_date', 'desc')
                ->first();
            // dd($getRmTbl);
            // Check if $getRmTbl is null
            $itemcode = $getRmTbl->item_code;
            $stock_awal = $getRmTbl->stock_awal;
            $in = $getRmTbl->in;
            $out = $getRmTbl->out;

            $totalOutsystem = intval($request->qtyCreate);
            // get qty out by sistem
            // $out = $request->qtyCreate;
            // Calculate the total input
            // $totalOut = array_sum(array_map('intval', $out)); // Sum all quantities
            // // dd($totalIn);
            // // Calculate new in and balance
            $newOut = $out + $totalOutsystem;
            $balance = $stock_awal + $in - $newOut;
            // dd($balance);
            // Update stock balance in ekanban_rm_chuter_tbl
            ekanban_rm_chuter_tbl::where('item_code', $itemcode)
                ->where('mpname', $mpname)
                ->update([
                    'out' => $newOut,
                    'balance' => $balance
                ]);
            // Commit transaksi jika tidak ada error
            DB::connection('ekanban')->commit();

            // Tampilkan response sukses
            return response()->json([
                'status'  => 'success',
                'message' => 'Data berhasil dimasukkan',
            ]);
        } catch (\Exception $e) {
            // Rollback transaksi jika ada error
            DB::connection('ekanban')->rollback();

            // Tampilkan error message
            return response()->json([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500); // Kirim status 500 (Internal Server Error)
        }
    }

    public function post_tp_outchuter(Request $request)

    {
        // Retrieve SAP credentials and URL from environment variables
        $sapClient = env('SAP_API_CLIENT');
        $sapUsername = env('SAP_API_USERNAME');
        $sapPassword = env('SAP_API_PASSWORD');
        $url = env('SAP_API_URL_TCH_TRANSFER'); // SAP API URL from .env

        // Assuming 'tableData' is the input data
        $tableData = $request->input('tableData');
        // dd($tableData);

        // Transform the data into the expected format
        $itInput = array_map(function ($item, $index) {
            // Define custom quantities for each index
            return [
                'MATERIAL' => $item['item_code'],
                'PLANT_ASAL' => '1701',  // or fetch from your input if dynamic
                'SLOC_ASAL' => '1010',    // or fetch from your input if dynamic
                'PLANT_TUJUAN' => '1701',  // or fetch from your input if dynamic
                'SLOC_TUJUAN' => $item['to_sloc'],
                'QUANTITY' => $item['qty'], // Replace qty with the desired values
                'SATUAN' => 'SHE'
            ];
        }, $tableData, array_keys($tableData));

        $data = [
            'IT_INPUT' => $itInput,
        ];

        // dd($data);

        try {
            DB::beginTransaction();

            // Send POST request to SAP API
            $response = Http::withBasicAuth($sapUsername, $sapPassword)
                ->timeout(175)
                ->withOptions(['query' => ['sap-client' => $sapClient]])
                ->post($url, $data);

            // Check if the response is successful
            if ($response->successful() && !empty($responseData = $response->json()['it_output'])) {
                // Generate the $bpb_no in format BPB_bulanthntgl_angkaacak5digit
                $currentDate = now()->format('Ymd'); // Get current date as YYYYMMDD
                $randomNumber = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT); // Generate a random 5-digit number
                $bpb_no = 'BPB-' . $currentDate . '-' . $randomNumber;

                // Get doc_no from the response
                $doc_no = $responseData[0]['doc_no'];

                // Get the current authenticated user
                $createdBy = Auth::user()->user;

                // Assuming 'tableData' is the input data
                $tableData = $request->input('tableData');

                // Loop through each item in the tableData
                foreach ($tableData as $data) {
                    // Update the data in the table transti out chuter based on item_code and seq
                    Ekanban_transrm_chuter_out::where('created_by', $createdBy)
                        ->where('item_code', $data['item_code'])
                        ->where('seq', $data['seq'])
                        ->update([
                            'bpb_no' => $bpb_no,
                            'doc_no' => $doc_no,
                        ]);
                }

                // Commit the transaction
                DB::connection('ekanban')->commit();

                // Return the success response
                return response()->json([
                    'message' => 'Data post successfully',
                    'doc_no' => $doc_no,
                    'bpb_no' => $bpb_no,
                    'response' => $responseData,
                ]);
            }

            // Rollback and handle failure if response is not successful
            DB::connection('ekanban')->rollback();
            return response()->json([
                'error' => 'Data submission failed',
                'details' => $responseData['message'] ?? 'No document number returned',
                'response' => $response->json(),
            ], 400);
        } catch (\Exception $e) {
            // Rollback on exception
            DB::connection('ekanban')->rollback();
            return response()->json([
                'error' => 'Request failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function delete_outchuter_datatables(Request $request)
    {
        // Mengambil data dari request
        $id = $request->id;
        $itemcode_database = $request->itemcode_database;
        $kanban_database = $request->kanban_database;
        $seq_database = $request->seq_database;

        try {
            // Memulai transaksi
            DB::beginTransaction();

            // Menghapus baris dari database chuter out
            $delete_chuter = ekanban_transrm_chuter_out::where('id', $id)
                ->where('item_code', $itemcode_database)
                ->delete();

            // Mengupdate status di chuter in
            $status = "IN";
            $update_chuterin = ekanban_chuter_rmin_tbl::where('item_code', $itemcode_database)
                ->where('kanban_no', $kanban_database)
                ->where('seq', $seq_database)
                ->update([
                    'status' => $status,
                    'last_updated_by' => null, // Set to NULL
                    'last_updated_date' => null // Set to NULL
                ]);

            // Update log chuter in out with NULL value
            $update_chuter_log = chuter_rm_in_out_log::where('kanban_no', $kanban_database)
                ->where('seq', $seq_database)
                ->update([
                    'out_datetime' => null // Set to NULL
                ]);

            // Commit the transaction
            DB::connection('ekanban')->commit();

            // Mengembalikan response sukses
            return response()->json([
                'message' => 'Data has been deleted and updated successfully.',
            ]);
        } catch (\Exception $e) {
            // Rollback and handle failure
            DB::connection('ekanban')->rollback();

            // Mengembalikan response error
            return response()->json([
                'error' => 'Request failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
