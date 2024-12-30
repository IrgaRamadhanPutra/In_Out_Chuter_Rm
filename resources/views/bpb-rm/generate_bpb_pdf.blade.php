<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pengeluaran Barang</title>
    <style>
        /* body {
            font-family: Arial, sans-serif;
        } */

        .container {
            width: 100%;
            /* margin: 0 auto; */
        }

        .header {
            text-align: center;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 1px;
            text-align: center;
        }

        .custom-cell {
            padding-right: 3pt;
            padding-left: 3pt;
            font-size: 9px;
        }

        .table-row {
            padding: 5px;
            text-align: left;
        }

        .label {
            display: inline-block;
            /* Make the label occupy only the necessary space */
            width: 100px;
            /* Set a fixed width for the labels */
        }
    </style>
</head>

<body>

    <div class="container">
        <div style="width: 100%; border: 1px solid black; padding: 0px; margin-top: -10px;">
            <!-- Added border and adjusted margin-top -->
            <table style="width: 100%;margin-top: 0px;"> <!-- Reduced margin-bottom -->
                <tr>
                    <td style="padding: 1px; text-align: left; font-weight: bold; margin: 0;">
                        PT. TRIMITRA CHITRAHASTA
                    </td>
                    <td style="padding: 1px; text-align: right;" colspan="2">
                        No : {{ $data->first()->bpb_no ?? 'Null' }}
                    </td>
                </tr>
            </table>

            <div style="text-align: center; margin-bottom: 5px;"> <!-- Reduced margin-bottom -->
                <h3 style="margin: 0px 0;">BUKTI PENGELUARAN BARANG</h3>
                <p style="margin: 0;">(Part, Carrier, Box, Skid)</p>
            </div>

            <div class="row" style="margin-bottom: 2px; padding: 3px;"> <!-- Reduced margin-bottom -->
                <div class="col text-center"> <!-- Column for Hari/Tanggal -->
                    <span style="font-size:13px;" class="label">Hari/Tanggal</span>
                    <span style="font-size:13px;">
                        :
                        {{ \Carbon\Carbon::parse($data->first()->creation_date)->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d-F-Y') }}
                    </span>
                </div>
                <div class="col text-center"> <!-- Column for Cycle No/Route -->
                    <span style="font-size:13px;" class="label">Cycle No/Route</span>
                    <span style="font-size:13px;">
                        :
                    </span>
                </div>
                <div class="col text-center"> <!-- Column for Jam -->
                    <span style="font-size:13px;" class="label">Jam</span>
                    <span style="font-size:13px;">
                        : {{ \Carbon\Carbon::parse($data->first()->creation_date)->format('H:i:s') }}
                    </span>
                </div>
            </div>
            <table style="width: 100%;margin-top:0px;"> <!-- Added border to table -->
                <tr>
                    <td rowspan="2" colspan="3" style="padding-right: 3pt; padding-left: 3pt; text-align: left;">
                        {{-- <div class="row" style="margin-bottom: 5px; display: flex; justify-content: flex-start;">
                            <!-- Column for Hari/Tanggal -->
                            <div class="col" style="margin-right: 10px;">
                                <span style="font-size:14px;" class="label">Hari/Tanggal</span>
                                <span style="font-size:14px;">
                                    : {{ \Carbon\Carbon::parse($data->first()->creation_date)->format('d-F-Y') }}
                                </span>
                            </div>
                            <!-- Column for Cycle No/Route -->
                            <div class="col" style="margin-right: 10px;">
                                <span style="font-size:14px;" class="label">Cycle No/Route</span>
                                <span style="font-size:14px;"> :</span>
                            </div>
                            <!-- Column for Jam -->
                            <div class="col">
                                <span style="font-size:14px;" class="label">Jam</span>
                                <span style="font-size:14px;">
                                    : {{ \Carbon\Carbon::parse($data->first()->creation_date)->format('H:i:s') }}
                                </span>
                            </div>
                        </div> --}}
                    </td>
                    <td colspan="8"
                        style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding: 1px 3px; font-size:9;">
                        Actual Delivery
                    </td>
                    <td rowspan="2" style="padding-right: 3pt; padding-left: 3pt;">
                    </td>
                </tr>


                <tr>
                    <td colspan="2"
                        style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding-right: 1pt; padding-left: 1pt;font-size:9; ">
                        Qty Delivery (pcs)
                    </td>
                    <td colspan="2"
                        style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding-right: 1pt; padding-left: 1pt;font-size:9; ">
                        Qty Carier (Unit)
                    </td>
                    <td colspan="2"
                        style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding-right: 1pt; padding-left: 1pt;font-size:9; ">
                        Qty BOX (Unit)
                    </td>
                    <td colspan="2"
                        style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding-right: 1pt; padding-left: 1pt;font-size:9; ">
                        Qty Skid (Unit)
                    </td>
                </tr>
                <tr>
                    <td
                        style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding-right: 3pt; padding-left: 3pt;font-size:9; ">
                        No
                    </td>
                    <td
                        style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding-right: 1pt; padding-left: 1pt; font-size:9;  white-space: nowrap; width: 150px;">
                        Part No / Part Name&nbsp;
                    </td>
                    <td
                        style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding-right: 3pt; padding-left: 3pt;font-size:9; ">
                        Qty
                        <br>
                        Packing
                        <br>
                    </td>
                    <td
                        style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding-right: 3pt; padding-left: 3pt;font-size:9; ">
                        Plan
                    </td>
                    <td
                        style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding-right: 3pt; padding-left: 3pt;font-size:9; ">
                        Act. Check
                    </td>
                    <td
                        style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding-right: 3pt; padding-left: 3pt;font-size:9; ">
                        Plan/
                        <br>
                        kirim
                    </td>
                    <td
                        style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding-right: 3pt; padding-left: 3pt;font-size:9; ">
                        Act.Check/
                        <br>
                        Terima
                    </td>
                    <td
                        style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding-right: 3pt; padding-left: 3pt;font-size:9; ">
                        Plan/
                        <br>
                        Kirim
                    </td>
                    <td
                        style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding-right: 3pt; padding-left: 3pt;font-size:9; ">
                        Act.Check/
                        <br>
                        Terima
                    </td>
                    <td
                        style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding-right: 3pt; padding-left: 3pt;font-size:9; ">
                        Plan/
                        <br>
                        Kirim
                    </td>
                    <td
                        style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding-right: 3pt; padding-left: 3pt;font-size:9; ">
                        Act.Check/
                        <br>
                        Terima
                    </td>
                    <td
                        style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding-right: 3pt; padding-left: 3pt;font-size:9; ">
                        No. PO/DN
                    </td>
                </tr>
                @foreach ($data as $index => $item)
                    <tr>
                        <td
                            style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding: 1pt; font-size:9;">
                            {{ $index + 1 }} <!-- Row number -->
                        </td>
                        <td
                            style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding: 1pt; font-size:8;">
                            {{ $item->part_name }} <!-- Part Name -->
                        </td>
                        <td
                            style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding: 1pt; font-size:9;">
                            {{ $item->qty }} <!-- Quantity -->
                        </td>
                        <td
                            style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding: 3pt; font-size:9; ">

                        </td>
                        <td
                            style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding: 3pt; font-size:9; ">
                        </td>
                        <td
                            style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding: 3pt; font-size:9; ">
                        </td>
                        <td
                            style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding: 3pt; font-size:9; ">
                        </td>
                        <td
                            style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding: 3pt; font-size:9; ">
                        </td>
                        <td
                            style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding: 3pt; font-size:9; ">
                        </td>
                        <td
                            style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding: 3pt; font-size:9; ">
                        </td>
                        <td
                            style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding: 3pt; font-size:9; ">
                        </td>
                        <td
                            style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding: 3pt; font-size:9; ">
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2"
                        style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding-right: 3pt; padding-left: 3pt;font-size:9; ">
                        Diserahkan Oleh
                    </td>
                    <td colspan="2"
                        style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding-right: 3pt; padding-left: 3pt;font-size:9; ">
                        Diketahui Oleh
                    </td>
                    <td colspan="2"
                        style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding-right: 3pt; padding-left: 3pt;font-size:9; ">
                        Di Terima Oleh
                    </td>
                    <td rowspan="4" colspan="6"
                        style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding-right: 3pt; padding-left: 3pt; font-size:9; text-align: left;">
                        Note :
                    </td>

                </tr>
                <tr>
                    <td rowspan="3" colspan="2"
                        style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding-right: 3pt; padding-left: 3pt;font-size:9; ">

                    </td>
                    <td rowspan="3" colspan="2"
                        style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding-right: 3pt; padding-left: 3pt;font-size:9; ">

                    </td>
                    <td style="padding-right: 3pt; padding-left: 3pt;font-size:9;">
                    </td>
                    <td style="padding-right: 3pt; padding-left: 3pt;font-size:9;">
                        &nbsp;
                        <br>
                        &nbsp;

                    </td>
                </tr>
                <tr>
                    <td style="padding-right: 3pt; padding-left: 3pt;">
                    </td>
                    <td style="padding-right: 3pt; padding-left: 3pt;">
                    </td>
                </tr>
                <tr>
                    <td style="padding-right: 3pt; padding-left: 3pt;">
                    </td>
                    <td style="padding-right: 3pt; padding-left: 3pt;">
                    </td>
                </tr>
                <tr>
                    <td colspan="2"
                        style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding-right: 3pt; padding-left: 3pt;font-size:9; ">
                        Warehouse
                    </td>
                    <td colspan="2"
                        style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding-right: 3pt; padding-left: 3pt;font-size:9; ">
                        Security
                    </td>
                    <td colspan="2"
                        style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding-right: 3pt; padding-left: 3pt;font-size:9; ">
                        Driver/MilkRun
                    </td>
                    <td colspan="6"
                        style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); padding-right: 3pt; padding-left: 3pt;font-size:9; ">
                    </td>
                </tr>
            </table>

        </div>
        <span style="font-size: 12px">LD-INV-02 rev.1</span>
    </div>



</body>

</html>
