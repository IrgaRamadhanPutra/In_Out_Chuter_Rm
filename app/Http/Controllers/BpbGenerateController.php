<?php

namespace App\Http\Controllers;

use App\Models\Ekanban\ekanban_transrm_chuter_out;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeUnit\FunctionUnit;
use Yajra\DataTables\Facades\DataTables;

class BpbGenerateController extends Controller
{
    //
    public function index_bpb()
    {
        return view('bpb-rm.index');
    }

    public function get_datatables_bpb(Request $request)
    {
        if ($request->ajax()) {
            $data = ekanban_transrm_chuter_out::select(
                'bpb_no',  // Selecting unique bpb_no
                DB::raw('MAX(id) as id'),  // Get the maximum id for the unique bpb_no
                DB::raw('MAX(created_by) as created_by'),  // Get the maximum created_by for the unique bpb_no
                DB::raw('MAX(creation_date) as creation_date')  // Get the most recent creation_date for the unique bpb_no
            )
                ->whereNotNull('bpb_no')  // Ensure bpb_no is not null
                ->groupBy('bpb_no')  // Group by bpb_no to ensure uniqueness
                ->orderBy('creation_date', 'desc')  // Order by creation_date
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return '<a href="#" data-toggle="tooltip" style="color: rgb(0, 0, 0);"
                                row-id="' . $data->id . '"
                                data-bpb="' . $data->bpb_no . '"
                                data-placement="top"
                                title="pdf"
                                class="dropdown-item pdf">
                                <i class="fa fa-file"></i> PDF
                            </a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function generate_bpb_pdf($id_database, $bpb_database)
    {
        // Fetch any necessary data for the PDF using $id_database and $bpb_database
        // $data = [
        //     'id_database' => $id_database,
        //     'bpb_database' => $bpb_database
        // ];

        $data = ekanban_transrm_chuter_out::select(
            'bpb_no',
            'part_name',
            'item_code',
            'kanban_no',
            'seq',
            'qty',
            'created_by',
            'creation_date'
        )
            ->where('bpb_no', $bpb_database)
            ->get();
        // dd($data);
        // Load and render the view to PDF
        $pdf = Pdf::loadView('bpb-rm.generate_bpb_pdf', ['data' => $data]);

        // Return the PDF download response
        return $pdf->stream("bpb_{$bpb_database}.pdf");
    }
}
