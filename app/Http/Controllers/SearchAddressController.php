<?php

namespace App\Http\Controllers;

use App\Models\Ekanban\ekanban_chuter_rmin_tbl;
use App\Models\Ekanban\ekanban_param_tbl;
use App\Models\Ekanban\master_address_rm;
use Illuminate\Http\Request;

class SearchAddressController extends Controller
{
    //
    public function index(Request $request)
    {
        $getItemcode = ekanban_param_tbl::select('item_code')
            ->where('kanban_type', 'R/M')
            ->get();

        $getChuter = master_address_rm::select('chuter_address')
            ->whereNotNull('chuter_address') // Ensure chuter_address is not NULL
            ->where('chuter_address', '!=', '0') // Ensure chuter_address is not NULL
            ->orderBy('chuter_address')      // Order by chuter_address
            ->get();


        return view('search-chuter-address.index', compact('getItemcode', 'getChuter'));
    }

    public function search_by_itemcode(Request $request)
    {
        // Debugging, hapus dd() setelah selesai
        // dd($request);

        // Ambil itemcode dari request
        $itemcode = $request->input('itemcode');

        // Inisialisasi query untuk mengambil data dari tabel
        $getData = ekanban_chuter_rmin_tbl::select('item_code', 'part_name', 'chutter_address', 'qty')
            ->where('status', '=', 'IN');
        // ->orderBy('item_code');
        // Tambahkan kondisi where jika itemcode ada
        if ($itemcode) {
            $getData->where('item_code', 'like', "%$itemcode%");
        }
        // dd($getData);
        // Ambil hasil query
        $results = $getData->get();

        // Mengembalikan data dalam format JSON
        return response()->json($results);
    }

    public function search_by_chuter(Request $request)
    {
        $chuter = $request->input('chuter');
        $getData = ekanban_chuter_rmin_tbl::select('item_code', 'part_name', 'chutter_address', 'qty')
            ->where('status', '=', 'IN');

        // ->orderBy('item_code');
        // Tambahkan kondisi where jika itemcode ada
        if ($chuter) {
            $getData->where('chutter_address', 'like', "%$chuter%");
        }
        // dd($getData);
        // Ambil hasil query
        $results = $getData->get();

        // Mengembalikan data dalam format JSON
        return response()->json($results);
    }
}
