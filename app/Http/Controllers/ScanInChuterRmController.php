<?php

namespace App\Http\Controllers;

use App\Models\Ekanban\chuter_in_out_log;
use App\Models\Ekanban\chuter_rm_in_out_log;
use App\Models\Ekanban\ekanban_chuter_rmin_tbl;
use App\Models\Ekanban\ekanban_chutter_fgout;
use App\Models\Ekanban\ekanban_fg_chuter_tbl;
use App\Models\Ekanban\ekanban_fgin_tbl;
use App\Models\Ekanban\Ekanban_fgout_tbl;
use App\Models\Ekanban\ekanban_param_tbl;
use App\Models\Ekanban\ekanban_rm_chuter_tbl;
use App\Models\Ekanban\ekanban_stock_limit;
use App\Models\Ekanban\Master_access_chuter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Ui\Presets\React;

class ScanInChuterRmController extends Controller
{
    //
    public function index()
    {
        return view('scan-in-chutter-rm.index');
    }

    public function validasi_ekanban_param(Request $request)
    {
        $getItemcode = $request->itemCode;


        // Query the database
        $get_param = ekanban_param_tbl::select('item_code')
            ->where('item_code', $getItemcode)
            ->first();

        // Check if the item code exists
        if ($get_param !== null) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);
        }
    }

    public function validasi_data_stock(Request $request)
    {
        // Mengambil input dari request
        $getItemcode = $request->itemCode;
        $getpartNo = $request->partNo;

        // Mengambil nilai mpname dengan format bulan-tahun saat ini
        $mpname = Carbon::now()->format('m-Y');

        // Mengambil nama user yang membuat dari session autentikasi
        $created_by = Auth::user()->user;

        // Cek apakah data dengan `mpname` tersedia untuk `item_code` tertentu
        $validasi_data_stock = ekanban_rm_chuter_tbl::select('item_code', 'balance')
            ->where('item_code', $getItemcode)
            ->where('mpname', $mpname)
            ->first();

        if (is_null($validasi_data_stock)) {
            // Jika tidak ada data dengan `mpname`, ambil data tanpa `mpname`
            $validasi_data_stock_old = ekanban_rm_chuter_tbl::select('item_code', 'balance')
                ->where('item_code', $getItemcode)
                ->first();

            // Jika `balance` ditemukan, gunakan nilainya, jika tidak, set ke 0
            $balance = $validasi_data_stock_old ? $validasi_data_stock_old->balance : 0;

            // Entry data baru ke tabel `ekanban_rm_chuter_tbl`
            ekanban_rm_chuter_tbl::create([
                'item_code' => $getItemcode,
                'part_name' => $getpartNo,
                'stock_awal' => $balance,
                'balance' => $balance,
                'mpname' => $mpname,
                'created_by' => $created_by, // Nama user yang membuat
                'creation_date' => Carbon::now(), // Waktu sekarang
            ]);

            // Mengembalikan respons JSON sukses
            return response()->json(['status' => 'sukses']);
        } else {
            // Jika data dengan `mpname` sudah ada, tidak perlu menambah data baru
            return response()->json(['status' => 'sukses']);
        }
    }

    public function validasi_chuter_in(Request $request)
    {
        // dd($request);
        $getItemcode = $request->itemCode;
        $getSeq = $request->sequence;



        // Query the database
        $validasi_chuter_in = Ekanban_chuter_rmin_tbl::select('item_code')
            ->where('item_code', $getItemcode)
            ->where('seq', $getSeq)
            ->first();
        // Check if the item code exists
        if ($validasi_chuter_in === null) {
            return response()->json(['status' => 'null']);
        } else {
            return response()->json(['status' => 'not_null']);
        }
    }

    public function add_chutteraddress(Request $request)
    {
        // dd($request);

        // Set timezone
        date_default_timezone_set("Asia/Jakarta");

        // Mulai transaksi
        DB::beginTransaction();

        try {
            // Split the input string by comma and trim whitespace from the second part
            $parts = explode(",", $request->input2);
            $chuterAddress = trim($parts[0]); // Extract Chuter address
            $status = 'IN';

            // Retrieve other input values
            $itemCodes = $request->input('itemCode'); // Assuming this is an array
            $firstItemcode = $itemCodes[0];
            $partNos = $request->input('partNo'); // Ensure this is an array
            $sequences = $request->input('sequence'); // Ensure this is an array
            $qtys = $request->input('qty'); // Ensure this is an array
            $kanbans = $request->input('kanban'); // Ensure this is an array
            $mpname = Carbon::now()->format('m-Y');
            $createdBy = Auth::user()->user;
            $createdDate = Carbon::now();
            // dd($kanbans, $sequences, $qtys, $createdBy, $createdDate);

            // Prepare data to insert into ekanban_chuter_rmin_tbl
            $dataToInsert = [];
            foreach ($itemCodes as $index => $itemCode) {
                $dataToInsert[] = [
                    'item_code' => $itemCode,
                    'kanban_no' => $kanbans[$index], // Access correct kanban
                    'part_name' => $partNos[$index], // Access correct part_no based on index
                    'chutter_address' => $chuterAddress, // Use the trimmed Chuter address
                    'seq' => $sequences[$index], // Access correct sequence
                    'qty' => $qtys[$index], // Access correct quantity
                    'mpname' => $mpname,
                    'status' => $status,
                    'created_by' => $createdBy,
                    'creation_date' => $createdDate,
                ];
            }

            // Insert data into ekanban_chuter_rmin_tbl
            ekanban_chuter_rmin_tbl::insert($dataToInsert);
            // dd($dataToInsert);



            $inDate = Carbon::now(); // Mengambil waktu saat ini
            $createdBy = Auth::user()->user; // Mendapatkan user yang sedang login
            $dataToInsert = []; // Inisialisasi array kosong untuk menampung data yang akan di-insert

            // Looping melalui setiap kanban number
            foreach ($kanbans as $index => $kanbanNo) {
                // Menyusun data yang akan di-insert untuk setiap kanban number
                $dataToInsert[] = [
                    'kanban_no'   => $kanbanNo,
                    'seq'         => $sequences[$index],
                    'chuter_address' => $chuterAddress,
                    'in_datetime' => $inDate,
                    'created_by'  => $createdBy,
                ];
            }

            // Insert data ke ChuterOverflowInOutLog
            chuter_rm_in_out_log::insert($dataToInsert);

            // Update stock in ekanban_rm_chuter_tbl
            $getRmTbl = ekanban_rm_chuter_tbl::where('item_code', $firstItemcode)
                ->where('mpname', $mpname)
                ->select('stock_awal', 'in', 'out', 'id', 'item_code')
                ->first();

            // Check if $getRmTbl is null
            $itemcode = $getRmTbl->item_code;
            $stock_awal = $getRmTbl->stock_awal;
            $in = $getRmTbl->in;
            $out = $getRmTbl->out;

            // Calculate the total input
            $totalIn = array_sum(array_map('intval', $qtys)); // Sum all quantities
            // dd($totalIn);
            // Calculate new in and balance
            $newIn = $in + $totalIn;
            $balance = $stock_awal + $newIn - $out;

            // Update stock balance in ekanban_rm_chuter_tbl
            ekanban_rm_chuter_tbl::where('item_code', $itemcode)
                ->where('mpname', $mpname)
                ->update([
                    'in' => $newIn,
                    'balance' => $balance
                ]);

            // Commit transaction
            DB::connection('ekanban')->commit();

            // Return successful response
            return response()->json(['message' => 'Successful'], 200);
        } catch (\Exception $e) {
            // Rollback transaction in case of error
            DB::connection('ekanban')->rollback();

            // Return error response
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 400);
        }
    }
}
