<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    {{-- <title>Pages / Login - NiceAdmin Bootstrap Template</title> --}}
    <meta content="" name="description">
    <meta content="" name="keywords">

    <title>Chuter All</title>
    <!-- Favicons -->
    <link href="{{ asset('assets/img/logo3.png') }}" rel="icon">
    <link href="{{ asset('assets/img/logo4.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    {{-- <link href="https://fonts.gstatic.com" rel="preconnect"> --}}
    {{-- <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet"> --}}
    <link href="{{ asset('assets/css/family.css') }}" rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
    {{-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet"> --}}
    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!-- =======================================================
    * Template Name: NiceAdmin
    * Updated: Jul 27 2023 with Bootstrap v5.3.1
    * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>
<style>
    .custom-container {
        margin-left: 20px;
        /* Adjust the left margin as needed */
        margin-right: 20px;
        /* Adjust the right margin as needed */
    }

    body {
        /* background-color: #343a40; */
        background-color: #000000;
        /* Dark background color */
        color: #fff;
        /* Text color on dark background */
    }

    /* Custom styles for table borders */
    .custom-table {
        border: 2px solid #e6e6e6;
        /* border: 2px solid #fad502; */
        background-color: transparent;
        color: #ffffff;
        /* Change to your desired border color */
    }

    .custom-table th,
    .custom-table td {
        border: 1px solid #e6e6e6;
        /* border: 1px solid #f7e709; */
        background-color: transparent;
        color: #ffffff;
        /* Change to your desired border color */
    }

    .custom-carousel-item {
        background-color: #151616;
        /* Warna latar belakang item carousel */
        padding: 20px;
        /* Tambahkan padding sesuai keinginan Anda */
        border-radius: 15px;
        /* Tambahkan border-radius sesuai keinginan Anda */
    }

    .popup-modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .popup-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 800px;
        max-height: 80%;
        overflow-y: auto;
        color: black;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .popup-text {
        max-height: 70vh;
        overflow-y: auto;
        font-weight: bold;
        /* Make the text in the modal bold */
    }
</style>

<body>
    <div class="custom-container mt-4">
        <div class="d-flex align-items-center justify-content-between">
            <div class="col">
                <a href="{{ route('home') }}" class="btn btn-primary" title="Dashboard">
                    <i class="bi bi-folder text-white"></i>
                </a>
                <a href="{{ route('index_chuter1_Abnormality') }}" class="btn btn-secondary" title="Abnormality">
                    <i class="bi bi-collection"></i>
                </a>
                <button type="button" class="btn btn-info" data-toggle="button" title="Refresh" aria-pressed="false"
                    autocomplete="off" onclick="refreshPage()">
                    <i class="bi bi-arrow-repeat"></i>
                </button>
            </div>
            <div class="col">

                <!-- Your heading -->
                <h3 class="ml-2 mt-0 mb-0"><b> ALL CONDITION </b></h3>
            </div>
            {{-- <div class="col">
                <img src="{{ asset('assets/img/logo3.png') }}" alt="Logo" width="60" height="60">
            </div> --}}
            <div class="col">
                <h3 class="ml-2 mt-0 mb-0"><b><span id="currentDate"> </span> </b></h3>
            </div>
            {{-- <div class="col"> --}}

            <div class="col-md-0 text-white ms-2">
                <h4><span class="badge bg-danger">KRITIS</span></h4>
            </div>
            <div class="col-md-0  ms-2 ">
                <h4><span class="badge bg-warning">OVER</span></h4>
            </div>
            <div class="col-md-0 ms-2">
                <h4><span class="badge " style="background-color: #07d344">OK</span></h4>
            </div>
            {{-- </div> --}}
        </div>
        {{-- <div class="container mt-5"> --}}
        <div class="card-deck mt-3 mb-2" style="font-weight: bold;">
            {{-- <h3 class="mb-3"> <b> ALL <b></h3> --}}
            {{-- <div id="cardCarousel" class="carousel slide" data-ride="carousel"> --}}
            <div id="cardCarousel" class="carousel slide" data-ride="carousel"data-interval="60000">
                <div class="carousel-inner">

                    <!-- Carousel Item 1 -->
                    <div class="carousel-item active">
                        <div class="card" id="card1" style="background-color: #000000">
                            <!-- Content for Card 1 (CHUTER O) -->
                            <div class="card-body">
                                <!-- Table 1 (CHUTER O) -->
                                <div class="row mt-3">
                                    <div class="col">
                                        {{-- Column --}}
                                        <div class="table-responsive" data-toggle="modal" data-target="#popup-modal"
                                            data-popup-content="CHUTTER J">
                                            <table class="table table-bordered mt-2 custom-table">
                                                <tr>
                                                    <th>CHUTTER J</th>
                                                    <th class="text-center">STATUS</th>
                                                    <th class="text-center">OVER FLOW</th>
                                                </tr>

                                                @foreach ($data as $item)
                                                    @if (strpos($item['chutter_address'], 'J') === 0)
                                                        <tr>
                                                            <td>{{ $item['chutter_address'] }}</td>
                                                            <td class="text-center"
                                                                style="background-color:
                                                                 @if ($item['balance'] < $item['min']) red
                                                                 @elseif($item['balance'] > $item['max']) #fab802
                                                                 @else #22cc0b @endif">
                                                                {{ $item['balance'] }}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col">
                                        {{-- Column --}}
                                        <div class="table-responsive" data-toggle="modal" data-target="#popup-modal"
                                            data-popup-content="CHUTTER I">
                                            <table class="table table-bordered mt-2 custom-table">
                                                <tr>
                                                    <th>CHUTTER I </th>
                                                    <th class="text-center">STATUS</th>
                                                    <th class="text-center">OVER FLOW</th>
                                                </tr>
                                                @foreach ($data as $item)
                                                    @if (strpos($item['chutter_address'], 'I') === 0)
                                                        <tr>
                                                            <td>{{ $item['chutter_address'] }}</td>
                                                            <td class="text-center"
                                                                style="background-color:
                                                             @if ($item['balance'] < $item['min']) red
                                                             @elseif($item['balance'] > $item['max']) #fab802
                                                             @else #22cc0b @endif">
                                                                {{ $item['balance'] }}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </table>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col">
                                        {{-- Column --}}
                                        <div class="table-responsive" data-toggle="modal" data-target="#popup-modal"
                                            data-popup-content="CHUTTER H">
                                            <table class="table table-bordered mt-2 custom-table">
                                                <tr>
                                                    <th>CHUTER H</th>
                                                    <th class="text-center">STATUS</th>
                                                    <th class="text-center">OVER FLOW</th>
                                                </tr>
                                                @foreach ($data as $item)
                                                    @if (strpos($item['chutter_address'], 'H') === 0)
                                                        <tr>
                                                            <td>{{ $item['chutter_address'] }}</td>
                                                            <td class="text-center"
                                                                style="background-color:
                                                     @if ($item['balance'] < $item['min']) red
                                                     @elseif($item['balance'] > $item['max']) #fab802
                                                     @else #22cc0b @endif">
                                                                {{ $item['balance'] }}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col">
                                        {{-- Column --}}
                                        <div class="table-responsive" data-toggle="modal" data-target="#popup-modal"
                                            data-popup-content="CHUTTER G">
                                            <table class="table table-bordered mt-2 custom-table">
                                                <tr>
                                                    <th>CHUTTER G </th>
                                                    <th class="text-center">STATUS</th>
                                                    <th class="text-center">OVER FLOW</th>
                                                </tr>
                                                @foreach ($data as $item)
                                                    @if (strpos($item['chutter_address'], 'G') === 0)
                                                        <td>{{ $item['chutter_address'] }}</td>
                                                        <td class="text-center"
                                                            style="background-color:
                                                     @if ($item['balance'] < $item['min']) red
                                                     @elseif($item['balance'] > $item['max']) #fab802
                                                     @else #07d344 @endif">
                                                            {{ $item['balance'] }}
                                                        </td>
                                                        <td style="background-color:rgb(0, 183, 255);">
                                                            {{ $item['jumlah_kanban'] }} / {{ $item['jumlah_qty'] }}
                                                        </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col">
                                        {{-- Column --}}
                                        <div class="table-responsive" data-toggle="modal" data-target="#popup-modal"
                                            data-popup-content="CHUTTER F">
                                            <table class="table table-bordered mt-2 custom-table">
                                                <tr>
                                                    <th>CHUTER F</th>
                                                    <th class="text-center">STATUS</th>
                                                    <th class="text-center">OVER FLOW</th>
                                                </tr>
                                                @foreach ($data as $item)
                                                    @if (strpos($item['chutter_address'], 'F') === 0)
                                                        <tr>
                                                            <td>{{ $item['chutter_address'] }}</td>
                                                            <td class="text-center"
                                                                style="background-color:
                                                 @if ($item['balance'] < $item['min']) red
                                                 @elseif($item['balance'] > $item['max']) #fab802
                                                 @else #07d344 @endif">
                                                                {{ $item['balance'] }}
                                                            </td>
                                                            <td style="background-color:rgb(0, 183, 255);">
                                                                {{ $item['jumlah_kanban'] }} /
                                                                {{ $item['jumlah_qty'] }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </table>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Carousel Item 2 -->
                    <div class="carousel-item">
                        <div class="card" id="card2" style="background-color: #000000">
                            <!-- Content for Card 2 -->
                            <div class="card-body">
                                <!-- Table 1 (CHUTER O) -->
                                <div class="row">
                                    <div class="col">
                                        {{-- Column --}}
                                        <div class="table-responsive" data-toggle="modal" data-target="#popup-modal"
                                            data-popup-content="CHUTTER J">
                                            <table class="table table-bordered mt-2 custom-table">
                                                <tr>
                                                    <th width="10%" style="font-size: 12px;">PART NAME - PART NO
                                                    </th>
                                                    <th width="5%" class="text-center" style="font-size: 12px;">
                                                        STOCK </th>
                                                    <th width="5%" class="text-center" style="font-size: 12px;">
                                                        MIN / MAX </th>
                                                    <th width="5%" class="text-center" style="font-size: 12px;">
                                                        OVER FLOW</th>
                                                </tr>
                                                @foreach ($data as $item)
                                                    @if (strpos($item['chutter_address'], 'J') === 0)
                                                        <tr>
                                                            <td style="font-size: 12px;">{{ $item['part_name'] }} -
                                                                {{ $item['part_number'] }}</td>
                                                            <td class="text-center"
                                                                style="font-size: 14px; background-color:
                                                            @if ($item['max'] < $item['balance']) #fab802
                                                            @elseif($item['min'] > $item['balance']) red
                                                            @else #07d344 @endif;">
                                                                {{ $item['balance'] }}
                                                            </td>
                                                            <td class="text-center"
                                                                style="font-size: 14px; background-color:
                                                            @if ($item['max'] < $item['balance']) #fab802
                                                            @elseif($item['min'] > $item['balance']) red
                                                            @else #07d344 @endif;">
                                                                @if ($item['max'] < $item['balance'])
                                                                    {{ $item['max'] }}
                                                                @elseif($item['min'] > $item['balance'])
                                                                    {{ $item['min'] }}&nbsp;
                                                                @else
                                                                    {{ $item['balance'] }}
                                                                @endif
                                                            </td>
                                                            <td
                                                                style="background-color:rgb(0, 183, 255);font-size: 14px;">
                                                                {{ $item['jumlah_kanban'] }} /
                                                                {{ $item['jumlah_qty'] }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach

                                            </table>
                                        </div>
                                    </div>
                                    <div class="col">
                                        {{-- Column --}}
                                        <div class="table-responsive" data-toggle="modal" data-target="#popup-modal"
                                            data-popup-content="CHUTTER I">
                                            <table class="table table-bordered mt-2 custom-table">
                                                <tr>
                                                    <th width="10%" style="font-size: 12px;">PART NAME - PART NO
                                                    </th>
                                                    <th width="5%" class="text-center" style="font-size: 12px;">
                                                        STOCK </th>
                                                    <th width="5%" class="text-center" style="font-size: 12px;">
                                                        MIN / MAX </th>
                                                    <th width="5%" class="text-center" style="font-size: 12px;">
                                                        OVER FLOW</th>
                                                </tr>
                                                @foreach ($data as $item)
                                                    @if (strpos($item['chutter_address'], 'I') === 0)
                                                        <tr>
                                                            <td style="font-size: 12px;">{{ $item['part_name'] }} -
                                                                {{ $item['part_number'] }}</td>
                                                            <td class="text-center"
                                                                style="font-size: 14px; background-color:
                                                            @if ($item['max'] < $item['balance']) #fab802
                                                            @elseif($item['min'] > $item['balance']) red
                                                            @else #07d344 @endif;">
                                                                {{ $item['balance'] }}
                                                            </td>
                                                            <td class="text-center"
                                                                style="font-size: 14px; background-color:
                                                            @if ($item['max'] < $item['balance']) #fab802
                                                            @elseif($item['min'] > $item['balance']) red
                                                            @else #07d344 @endif;">
                                                                @if ($item['max'] < $item['balance'])
                                                                    {{ $item['max'] }}
                                                                @elseif($item['min'] > $item['balance'])
                                                                    {{ $item['min'] }}&nbsp;
                                                                @else
                                                                    {{ $item['balance'] }}
                                                                @endif
                                                            </td>
                                                            <td
                                                                style="background-color:rgb(0, 183, 255);font-size: 14px;">
                                                                {{ $item['jumlah_kanban'] }} /
                                                                {{ $item['jumlah_qty'] }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach

                                            </table>
                                        </div>
                                    </div>
                                    <div class="col">
                                        {{-- Column --}}
                                        <div class="table-responsive" data-toggle="modal" data-target="#popup-modal"
                                            data-popup-content="CHUTTER H">
                                            <table class="table table-bordered mt-2 custom-table">
                                                <tr>
                                                    <th width="10%" style="font-size: 12px;">PART NAME - PART NO
                                                    </th>
                                                    <th width="5%" class="text-center" style="font-size: 12px;">
                                                        STOCK </th>
                                                    <th width="5%" class="text-center" style="font-size: 12px;">
                                                        MIN / MAX </th>
                                                    <th width="5%" class="text-center" style="font-size: 12px;">
                                                        OVER FLOW</th>
                                                </tr>
                                                @foreach ($data as $item)
                                                    @if (strpos($item['chutter_address'], 'H') === 0)
                                                        <tr>
                                                            <td style="font-size: 12px;">{{ $item['part_name'] }} -
                                                                {{ $item['part_number'] }}</td>
                                                            <td class="text-center"
                                                                style="font-size: 14px; background-color:
                                                            @if ($item['max'] < $item['balance']) #fab802
                                                            @elseif($item['min'] > $item['balance']) red
                                                            @else #07d344 @endif;">
                                                                {{ $item['balance'] }}
                                                            </td>
                                                            <td class="text-center"
                                                                style="font-size: 14px; background-color:
                                                            @if ($item['max'] < $item['balance']) #fab802
                                                            @elseif($item['min'] > $item['balance']) red
                                                            @else #07d344 @endif;">
                                                                @if ($item['max'] < $item['balance'])
                                                                    {{ $item['max'] }}
                                                                @elseif($item['min'] > $item['balance'])
                                                                    {{ $item['min'] }}&nbsp;
                                                                @else
                                                                    {{ $item['balance'] }}
                                                                @endif
                                                            </td>
                                                            <td
                                                                style="background-color:rgb(0, 183, 255);font-size: 14px;">
                                                                {{ $item['jumlah_kanban'] }} /
                                                                {{ $item['jumlah_qty'] }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach

                                            </table>
                                        </div>
                                    </div>
                                    <div class="col">
                                        {{-- Column --}}
                                        <div class="table-responsive" data-toggle="modal" data-target="#popup-modal"
                                            data-popup-content="CHUTTER G">
                                            <table class="table table-bordered mt-2 custom-table">
                                                <tr>
                                                    <th width="10%" style="font-size: 12px;">PART NAME - PART NO
                                                    </th>
                                                    <th width="5%" class="text-center" style="font-size: 12px;">
                                                        STOCK </th>
                                                    <th width="5%" class="text-center" style="font-size: 12px;">
                                                        MIN / MAX </th>
                                                    <th width="5%" class="text-center" style="font-size: 12px;">
                                                        OVER FLOW</th>
                                                </tr>
                                                @foreach ($data as $item)
                                                    @if (strpos($item['chutter_address'], 'G') === 0)
                                                        <tr>
                                                            <td style="font-size: 12px;">{{ $item['part_name'] }} -
                                                                {{ $item['part_number'] }}</td>
                                                            <td class="text-center"
                                                                style="font-size: 14px; background-color:
                                                            @if ($item['max'] < $item['balance']) #fab802
                                                            @elseif($item['min'] > $item['balance']) red
                                                            @else #07d344 @endif;">
                                                                {{ $item['balance'] }}
                                                            </td>
                                                            <td class="text-center"
                                                                style="font-size: 14px; background-color:
                                                            @if ($item['max'] < $item['balance']) #fab802
                                                            @elseif($item['min'] > $item['balance']) red
                                                            @else #07d344 @endif;">
                                                                @if ($item['max'] < $item['balance'])
                                                                    {{ $item['max'] }}
                                                                @elseif($item['min'] > $item['balance'])
                                                                    {{ $item['min'] }}&nbsp;
                                                                @else
                                                                    {{ $item['balance'] }}
                                                                @endif
                                                            </td>
                                                            <td
                                                                style="background-color:rgb(0, 183, 255);font-size: 14px;">
                                                                {{ $item['jumlah_kanban'] }} /
                                                                {{ $item['jumlah_qty'] }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach

                                            </table>
                                        </div>
                                    </div>
                                    <div class="col">
                                        {{-- Column --}}
                                        <div class="table-responsive" data-toggle="modal" data-target="#popup-modal"
                                            data-popup-content="CHUTTER F">
                                            <table class="table table-bordered mt-2 custom-table">
                                                <tr>
                                                    <th width="10%" style="font-size: 12px;">PART NAME - PART NO
                                                    </th>
                                                    <th width="5%" class="text-center" style="font-size: 12px;">
                                                        STOCK </th>
                                                    <th width="5%" class="text-center" style="font-size: 12px;">
                                                        MIN / MAX </th>
                                                    <th width="5%" class="text-center" style="font-size: 12px;">
                                                        OVER FLOW</th>
                                                </tr>
                                                @foreach ($data as $item)
                                                    @if (strpos($item['chutter_address'], 'F') === 0)
                                                        <tr>
                                                            <td style="font-size: 12px;">{{ $item['part_name'] }} -
                                                                {{ $item['part_number'] }}</td>
                                                            <td class="text-center"
                                                                style="font-size: 14px; background-color:
                                                            @if ($item['max'] < $item['balance']) #fab802
                                                            @elseif($item['min'] > $item['balance']) red
                                                            @else #07d344 @endif;">
                                                                {{ $item['balance'] }}
                                                            </td>
                                                            <td class="text-center"
                                                                style="font-size: 14px; background-color:
                                                            @if ($item['max'] < $item['balance']) #fab802
                                                            @elseif($item['min'] > $item['balance']) red
                                                            @else #07d344 @endif;">
                                                                @if ($item['max'] < $item['balance'])
                                                                    {{ $item['max'] }}
                                                                @elseif($item['min'] > $item['balance'])
                                                                    {{ $item['min'] }}&nbsp;
                                                                @else
                                                                    {{ $item['balance'] }}
                                                                @endif
                                                            </td>
                                                            <td
                                                                style="background-color:rgb(0, 183, 255);font-size: 14px;">
                                                                {{ $item['jumlah_kanban'] }} /
                                                                {{ $item['jumlah_qty'] }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add more carousel items as needed -->

                </div>
                <!-- Tombol Previous -->
                {{-- <a class="carousel-control-prev" href="#cardCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>

                <!-- Tombol Next -->
                <a class="carousel-control-next" href="#cardCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a> --}}
                <!-- Add more cards as needed -->
            </div>
            <!-- Modal HTML structure -->
            <div class="modal fade" id="popup-modal" tabindex="-1" role="dialog"
                aria-labelledby="popup-modal-label" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content bg-dark text-white">
                        <div class="modal-header">
                            <h5 class="modal-title" id="popup-modal-label"></h5>
                            <span aria-hidden="true" class="close" data-dismiss="modal">&times;</span>
                        </div>
                        <div class="modal-body">
                            <div id="popup-text" class="popup-text"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> --}}
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-3.2.1.slim.min.js') }}"></script>
    <!-- Include Bootstrap JS using Laravel asset() function -->
    <script src="{{ asset('assets/js/bootstrap1.min.js') }}"></script>
    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        function refreshPage() {
            // Menggunakan location.reload() untuk me-refresh halaman
            location.reload();
        }
        setTimeout(function() {
            location.reload();
        }, 300000); // 300000 milidetik = 5 menit

        function formatDate(date) {
            const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                'October', 'November', 'December'
            ];

            const day = days[date.getDay()];
            const dayOfMonth = date.getDate().toString().padStart(2, '0'); // Pad with leading zero if needed
            const month = months[date.getMonth()];
            const year = date.getFullYear();

            return `${day}, ${dayOfMonth} ${month} ${year}`;
        }

        function updateCurrentDateAndDay() {
            const currentDateElement = $('#currentDate');
            const currentDate = new Date();
            const formattedDate = formatDate(currentDate);

            currentDateElement.text(formattedDate);
        }

        // Update the current date and day when the page is loaded
        $(document).ready(function() {
            updateCurrentDateAndDay();
        });

        // pop up modal for detail chuter
        document.addEventListener('DOMContentLoaded', function() {
            $('#popup-modal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var tableContent = button.closest('div[data-popup-content]')
                    .html(); // Extract info from data-* attributes

                var modal = $(this);
                modal.find('.modal-title').text('Details for ' + button.data('popup-content'));
                modal.find('.modal-body #popup-text').html(tableContent);

            });
        });
    </script>
</body>

</html>
