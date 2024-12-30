@extends('admin.layout')
@section('title')
    SEARCH CHUTER ADDRESS
@endsection
@section('breadcrumb')
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a>Dashboard</a></li>
            <li class="breadcrumb-item text-danger">Search Data Chuter Addresing</li>
        </ol>
    </nav>
    {{-- <hr> --}}
@endsection('breadcrumb')
@section('content')
    {{-- <div class="card shadow mt-3">
        <div class="card-body mt-4">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <div class="datatable datatable-primary">
                            <div class="table-responsive">
                                <table id="tblChutter" class="table table-bordered table-hover" style="width:99.5%">
                                    <thead class="text-center text-white"
                                        style="text-transform: uppercase; font-size: 10px; background-color:rgb(170, 21, 21)">
                                        <tr>
                                            <th class="text-dark width="1%>Chuter Address</th>
                                            <th class="text-dark width="1%>Itemcode</th>
                                            <th class="text-dark width="5%>Part Name</th>
                                            <th class="text-dark width="1%>qty</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <input type="hidden" id="jml_row" name="jml_row" value="">
                    </div>

                </div>
            </div>
            <!-- Card Box below the table -->
        </div>
    </div> --}}
    <div class="row mb-2">
        <!-- First Card -->
        <div class="col-6">
            <div class="card shadow mt-3">
                <div class="card-body mt-4 text-center">
                    <h5 class="card-title">ITEMCODE</h5>
                    <button type="button" class="btn btn-primary" id="buttonItemcode">
                        <i class="bx bxs-hand-up"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Second Card -->
        <div class="col-6">
            <div class="card shadow mt-3">
                <div class="card-body mt-4 text-center">
                    <h5 class="card-title">CHUTER ADDRESS</h5>
                    <button type="button" class="btn btn-secondary" id="buttonChuter"><i
                            class="bx bxs-hand-up"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mt-1" id="cardSearchitemcode" style="display: none;">
        <div class="card-body mt-2">
            <div class="row mb-3"> <!-- Button row -->
                <button type="button" class="btn btn-primary btn-block btn-sm w-100" id="buttonItemcode" disabled>
                    Search by Itemcode
                </button>
            </div>
            <div class="row mb-3 mt-4">
                <div class="form-group col-12">
                    <label for="itemcode" class="font-weight-bold">Itemcode</label>
                </div>
                <div class="form-group col-12">
                    <select class="form-control form-control-sm" id="itemcode" name="itemcode"
                        style="width: 100%; margin-top: -5px;">
                        <option value="">--CHOICE--</option>
                        @foreach ($getItemcode as $item)
                            <option value="{{ $item->item_code }}">{{ $item->item_code }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3 mt-4">
                <div class="form-group col-12 d-flex justify-content-center">
                    <span class="empty-message text-danger fw-bold d-none text-center" style="font-size: 15px;">
                        No data available
                    </span>
                </div>
            </div>

            <div class="row mb-3 mt-lg-5" id="dataItemcode"> <!-- Card for NAMA ITEMCODE -->

            </div>

        </div>
    </div>


    <div class="card shadow mt-1" id="cardSearchchuter" style="display: none;">
        <div class="card-body mt-2">
            <div class="row mb-3"> <!-- Button row -->
                <button type="button" class="btn btn-secondary btn-block btn-sm w-100" disabled>
                    Search by Chuter Address
                </button>
            </div>
            <div class="row mb-3 mt-4">
                <div class="form-group col-12">
                    <label for="chuter" class="font-weight-bold">Chuter Address</label>
                </div>
                <div class="form-group col-12">
                    <select class="form-control form-control-sm" id="chuter" name="chuter"
                        style="width: 100%; margin-top: -5px;">
                        <option value="">Select Chuter</option>
                        @foreach ($getChuter as $chuter)
                            <option value="{{ $chuter->chuter_address }}">{{ $chuter->chuter_address }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3 mt-4">
                <div class="form-group col-12 d-flex justify-content-center">
                    <span class="empty-message text-danger fw-bold d-none text-center" style="font-size: 15px;">
                        No data available
                    </span>
                </div>
            </div>

            <div class="row mb-3 mt-lg-5" id="dataChuter"> <!-- Card for NAMA ITEMCODE -->

            </div>

        </div>
    </div>
    @include('search-chuter-address.ajax')
@endsection('content')
