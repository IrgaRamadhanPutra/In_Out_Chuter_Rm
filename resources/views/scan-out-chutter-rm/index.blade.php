@extends('admin.layout')
@section('title')
    SCAN OUT CHUTER
@endsection
@section('breadcrumb')
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a>Dashboard</a></li>
            <li class="breadcrumb-item text-danger">ScanOut Chuter Raw Material</li>
        </ol>
    </nav>
    {{-- <hr> --}}
@endsection('breadcrumb')
@section('content')
    <div class="card shadow mt-3">
        <div class="card-body mt-2">
            <form id="formChutter">
                @csrf

                <div class="form-outline mb-4" id="divLokal">


                    {{-- <input type="hidden" name="sequence" id="sequence"> --}}
                    {{-- <label class="form-label text-danger mt-2" for="input1">*Kanban Lokal*</label> --}}
                    <h1 class="text-danger mt-2"><b><i>*Label Chuter*</i></b></h1>

                    <input type="text" class="form-control" id="input1" name="input1" placeholder="" value=""
                        required="" style="width: 100%;">
                </div>

                {{-- <div class="form-outline mb-4" style="display: none" id="divChutter">
                    <h1 class="text-danger mt-2"><b><i>*Kanban Chuter*</i></b></h1>
                    <input type="text" class="form-control" id="input2" name="input2" placeholder="" value=""
                        required="" style="width: 100%;">
                </div> --}}

                <div class="table-responsive">
                    <table id="tblChutter" class="table  table-hover bg-primary" style="width:99.5%">
                        <thead class="text-center" style="text-transform: uppercase; font-size: 12px;">
                            <tr>
                            <tr>
                                <th scope="col"
                                    style="width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    Itemcode</th>
                                <th scope="col"
                                    style="width: 500px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    Part Name</th>
                                <th scope="col"
                                    style="width: 100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    Sequence</th>
                                <th scope="col"
                                    style="width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    Kanban No</th>
                                <th scope="col"
                                    style="width: 100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    Qty</th>
                                <th scope="col"
                                    style="width: 100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    To Sloc</th>
                                <th scope="col"
                                    style="width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    Action</th>
                            </tr>
                            </tr>
                        </thead>
                        <tbody id="body">
                            <!-- Isi tabel disini -->
                        </tbody>
                    </table>
                </div>

                <br>
                <div class="form-group d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-primary" id="post" style="font-size: 15px;">POST</button>
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
    @include('scan-out-chutter-rm.modal.modal_getdata_chuter')
    @include('scan-out-chutter-rm.modal.modal_input_qty')
    @include('scan-out-chutter-rm.ajax')
@endsection('content')
