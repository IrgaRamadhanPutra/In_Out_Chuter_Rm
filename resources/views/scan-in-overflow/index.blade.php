@extends('admin.layout')
@section('title')
    SCAN IN OVERFLOW
@endsection
@section('breadcrumb')
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a>Dashboard</a></li>
            <li class="breadcrumb-item text-danger">ScanIn OverFlow</li>
        </ol>
    </nav>
    {{-- <hr> --}}
@endsection('breadcrumb')
@section('content')
    <div class="card shadow mt-3">
        <div class="card-body mt-2">
            <form id="formOverflow">
                @csrf
                <div class="form-outline mb-4" id="divLokal">
                    <h1 class="text-danger mt-2"><b><i>*Kanban Lokal*</i></b></h1>

                    <input type="text" class="form-control" id="input1" name="input1" placeholder="" value=""
                        required="" style="width: 100%;">
                </div>
                <div class="form-outline mb-4" style="display: none" id="divOver">
                    <h1 class="text-danger mt-2"><b><i>*Kanban Overflow*</i></b></h1>
                    <input type="text" class="form-control" id="input2" name="input2" placeholder="" value=""
                        required="" style="width: 100%;">
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <div class="datatable datatable-primary">
                                <div class="table-responsive">
                                    <table id="tblOverflow" class="table table-bordered table-hover" style="width:99.5%">
                                        <thead class="text-center text-white"
                                            style="text-transform: uppercase; font-size: 10px; background-color:rgb(170, 21, 21)">
                                            <tr>
                                                <th class="text-dark width="1%>Itemcode</th>
                                                <th class="text-dark width="1%>Part No</th>
                                                <th class="text-dark width="1%>Squence</th>
                                                <th class="text-dark width="1%>kanban no</th>
                                                <th class="text-dark width="1%>qty</th>
                                                {{-- <th class="text-dark width="1%>Kanban No</th> --}}
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
                <br>
                <div class="form-group d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-primary" id="addOverflow" style="font-size: 15px;">ADD TO
                        KANBAN</button>
                    <button type="button" class="btn btn-secondary" id="reset" data-dismiss="modal"
                        style="font-size: 15px;">RESET</button>
                </div>
        </div>
        <audio id="Audiosucces" src="{{ asset('audio\succes.mp3') }}"></audio>
        <audio id="Audioerror" src="{{ asset('audio\error.mp3') }}"></audio>
        <div class="loading-spinner-container">
            <div class="loading-spinner"></div>
            <span>Loading..</span>
        </div>
        </form>
    </div>
    </div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    @include('scan-in-overflow.ajax')
@endsection('content')
