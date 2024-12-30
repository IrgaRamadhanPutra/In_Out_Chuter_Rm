<script>
    $(document).ready(function() {
        // Deklarasi Variable
        var input1 = $("#input1");
        var input2 = $("#input2");
        var reset = $("#reset");

        // var table = $("#tblChutter").DataTable();
        var table = $('#tblChutter').DataTable({
            "paging": false, // Nonaktifkan paging
            "searching": false,
            "ordering": false,
            "lengthChange": false,
            "responsive": true,
            "drawCallback": function(settings) {
                // Tambahkan style border biru pada seluruh tabel
                $('#tblChutter').css({
                    "border": "1px solid blue" // Border style
                });
                // Tambahkan style border biru pada sel header
                $('#tblChutter thead th').css({
                    "border": "1px solid blue" // Border style
                });
                // Tambahkan style border biru pada sel data
                $('#tblChutter tbody td').css({
                    "border": "1px solid blue" // Border style
                });
            }
        });

        input1.focus();
        // $('#smallModal').modal('hide');
        // Input field 1

        function showLoading() {
            $('.loading-spinner-container').show(); // Show loading spinner
        }

        function hideLoading() {
            $('.loading-spinner-container').hide(); // Hide loading spinner
        }

        // Function to handle Enter key on input1
        input1.on("keydown", function(e) {
            if (e.key === "Enter") {
                if (input1.val() !== "") {
                    var value = input1.val();
                    if (value.includes(',')) {
                        var splitData = value.split(',');
                        if (splitData.length > 1) {
                            // console.log(splitData);
                            var itemCode = splitData[0];
                            var partNo = splitData[1];
                            var sequence = splitData[3];
                            var kanban = splitData[2];
                            var qty = splitData[4]; // Define qty if needed

                            var table = $('#tblChutter').DataTable();

                            // Check if the table is empty
                            if (table.data().count() === 0) {
                                // Call validasiEkanbanParam function
                                // validasiEkanbanParam(itemCode, partNo, sequence, kanban);
                                validasiChuterIn(itemCode, partNo, sequence, kanban, qty)
                            } else {
                                var status = true;

                                table.rows().every(function() {
                                    var rowData = this.data();
                                    var valueSequence = $(rowData[2]).val();
                                    var valueItemCode = $(rowData[0]).val();

                                    if (valueSequence === sequence && valueItemCode ===
                                        itemCode) {
                                        status = false;
                                        return false; // Keluar dari perulangan jika ditemukan sequence yang sama
                                    }
                                });

                                if (status) {
                                    // validasiEkanbanParam(itemCode, partNo, sequence, kanban);
                                    validasiChuterIn(itemCode, partNo, sequence, kanban, qty)

                                } else {
                                    hideLoading();
                                    if ("vibrate" in navigator) {
                                        navigator.vibrate([1000]);
                                    }
                                    document.getElementById('Audioerror').play();
                                    swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Seq & Itemcode Already Exist In Table ',
                                        showConfirmButton: true,
                                    });
                                    input1.val("");
                                    $('#input1').focus();
                                }
                            }
                        } else {
                            input1.val("");
                            $('#input1').focus();
                        }
                    } else {
                        input1.val("");
                        $('#input1').focus();
                    }
                }
                return false; // Prevent default Enter key behavior
            }
        });

        // FUNCTION VALIDASI EKANBAN PARAM
        // function validasiEkanbanParam(itemCode, partNo, sequence, kanban) {
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });

        //     $.ajax({
        //         url: "{{ route('validasi_ekanban_param') }}", // Server URL
        //         type: "GET", // HTTP method
        //         data: {
        //             itemCode: itemCode
        //         }, // Data to send to the server
        //         dataType: 'json', // Expected data type from server
        //         beforeSend: function() {
        //             showLoading(); // Show loading indicator before the request
        //         },
        //         success: function(response) {
        //             // Handle the response from the server
        //             if (response.status === 'success') {
        //                 // console.log('Success: Item code exists.');
        //                 // alert('Data ada');
        //                 // Call validasiChuterIn after successful validation
        //                 validasiChuterIn(itemCode, partNo, sequence, kanban);
        //             } else if (response.status === 'error') {
        //                 hideLoading();
        //                 if ("vibrate" in navigator) {
        //                     navigator.vibrate([1000]);
        //                 }
        //                 document.getElementById('Audioerror').play();
        //                 swal.fire({
        //                     icon: 'error',
        //                     title: 'Error',
        //                     text: 'Data Not Found',
        //                     showConfirmButton: true,
        //                 });
        //                 input1.val("");
        //                 $('#input1').focus();
        //             }
        //         },
        //         error: function(xhr, status, error) {
        //             // Handle errors here
        //             console.error('AJAX Error:', status, error);
        //         }
        //     });
        // }

        // FUNCTION VALIDASI CHUTER IN RM
        function validasiChuterIn(itemCode, partNo, sequence, kanban, qty) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('validasi_chuter_in') }}", // Server URL
                type: "GET", // HTTP method
                data: {
                    itemCode: itemCode,
                    sequence: sequence // Data to send to the server
                },
                dataType: 'json', // Expected data type from server
                beforeSend: function() {
                    showLoading(); // Show loading indicator before the request
                },
                success: function(response) {
                    // Handle the response from the server
                    if (response.status === 'null') {
                        // console.log('Success: Item code exists.');
                        validasi_data_stock(itemCode, partNo, sequence, kanban, qty);
                    } else if (response.status === 'not_null') {
                        hideLoading();
                        if ("vibrate" in navigator) {
                            navigator.vibrate([1000]);
                        }
                        document.getElementById('Audioerror').play();
                        swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Data Already Scan In Chuter',
                            showConfirmButton: true,
                        });
                        input1.val("");
                        $('#input1').focus();
                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    console.error('AJAX Error:', status, error);
                }
            });
        }

        function validasi_data_stock(itemCode, partNo, sequence, kanban, qty) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('validasi_data_stock') }}", // Server URL
                type: "GET", // HTTP method
                data: {
                    itemCode: itemCode,
                    partNo: partNo
                },
                dataType: 'json', // Expected data type from server
                beforeSend: function() {
                    showLoading(); // Show loading indicator before the request
                },
                success: function(response) {
                    // Handle the response from the server
                    if (response.status === 'sukses') {
                        // console.log('Success: Data has been processed successfully.');
                        getDatatotable(itemCode, partNo, sequence, kanban, qty);
                    } else {
                        // Kondisi fallback jika status lain muncul
                        hideLoading();
                        if ("vibrate" in navigator) {
                            navigator.vibrate([1000]);
                        }
                        document.getElementById('Audioerror').play();
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Call IT ',
                            showConfirmButton: true,
                        });
                        input1.val("");
                        $('#input1').focus();
                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    console.error('AJAX Error:', status, error);
                }
            });
        }

        // FUNCTION TO SHOW MODAL AND CHECK QTY
        function getDatatotable(itemCode, partNo, sequence, kanban, qty) {
            hideLoading();

            $('#smallModal').modal('hide'); // Hide modal
            $('#inputQty').val(''); // Reset the QTY input field

            // Assume input1 is a reference to an element in your form
            input1.val(""); // Reset input1
            $('#input1').focus(); // Focus back to input1
            hideLoading(); // Hide loading spinner

            var t = $('#tblChutter').DataTable();
            var counter = t.rows().count();
            var jml_row = Number(counter) + 1;

            // Create unique identifiers for each field
            var itemCodeId = "itemCode" + jml_row;
            var partNoId = "partNo" + jml_row;
            var sequenceId = "sequence" + jml_row;
            var kanbanId = "kanban" + jml_row;
            var qtyId = "qty" + jml_row;

            // Add new row to DataTable with correct variables for values
            t.row.add([
                '<input type="text" class="text-center" id="' + itemCodeId +
                '" name="itemCode[]" value="' + itemCode + '" readonly>',
                '<input type="text" class="text-center" id="' + partNoId +
                '" name="partNo[]" value="' + partNo + '" readonly>',
                '<input type="text" class="text-center" id="' + sequenceId +
                '" name="sequence[]" value="' + sequence + '" readonly>',
                '<input type="text" class="text-center" id="' + qtyId +
                '" name="qty[]" value="' + qty + '" readonly>',
                '<input type="text" class="text-center" id="' + kanbanId +
                '" name="kanban[]" value="' + kanban + '" readonly>'
            ]).draw();
            input1.val(""); // Reset input1 after adding new row
            input1.attr('readonly', false); // Enable input1
            $('#input1').focus(); // Focus back to input1
        }



        // Input field 2
        input2.on("keydown", function(e) {

            if (e.which === 13) {
                // handleInput2Change();
                var input2 = $("#input2");
                // var itemcodeLokal = $("#itemcodeLokal");
                // Input field 2 for add row tabel
                // if (input2.val() !== "") {
                var getInput2 = input2.val();
                if (getInput2.includes(',')) {
                    var spliteData = getInput2.split(',');
                    // var Getpart_no = spliteData[1];
                    // var Getpart_no = spliteData[2];
                    // console.log(spliteData);
                    addInchuter();
                } else {
                    input2.val(
                        ""); // Kosongkan input2 jika tidak ada koma
                    input2.attr('readonly', false);
                    $('#input2').focus();
                }

            }
        });

        // add update colum for ekanban fgin
        function addInchuter() {
            function showLoading() {
                $('.loading-spinner-container').show();
            }

            // Menyembunyikan loading spinner
            function hideLoading() {
                $('.loading-spinner-container').hide();
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $(
                            'meta[name="csrf-token"]'
                        )
                        .attr('content')
                }
            });

            $.ajax({
                url: "{{ route('add_chutteraddress') }}",
                type: "POST",
                data: $('#formChutter')
                    .serialize(),
                dataType: 'json',
                beforeSend: function() {
                    showLoading
                        (); // Memanggil fungsi showLoading sebelum request
                },
                success: function(data) {
                    if (data.message === 'Successful') {
                        // alert('Sukses'); // Jika respons sukses
                        hideLoading();
                        $('#itemcodeChutter').val("");
                        $('#itemcodeLokal').val("");
                        document.getElementById("divLokal").style.display = "block";
                        document.getElementById("divChutter").style.display = "none";
                        document.getElementById('Audiosucces').play();
                        input1.focus();
                        input1.val("");
                        input2.val("");
                        Swal.fire({
                            icon: 'success',
                            title: 'Successs',
                            text: 'Data Saved Successfully',
                        });
                        input1.focus();
                        $('#tblChutter').DataTable().clear().draw();
                    } else {
                        hideLoading();
                        $('#itemcodeChutter').val("");
                        $('#itemcodeLokal').val("");
                        document.getElementById("divLokal").style.display = "block";
                        document.getElementById("divChutter").style.display = "none";
                        if ("vibrate" in navigator) {
                            navigator.vibrate([1000]);
                        }
                        document.getElementById('Audioerror').play();
                        input1.focus();
                        input1.val("");
                        input2.val("");
                        Swal.fire({
                            icon: 'error',
                            timer: 2000,
                            title: 'Error',
                            text: 'Terjadi Kesalahan Hub IT',
                        });
                        $('#tblChutter').DataTable().clear().draw();
                    }
                },
                error: function(jqXHR) {
                    alert('Error: ' + jqXHR.responseJSON.message); // Menangani error dari server
                }



            });
        }
        // byutton close
        $('#closeButton').on('click', function() {
            $('#input1').val(''); // Clear the input field
        });
        reset.on("click", function() {
            // Kode di bawah ini akan mengembalikan tampilan ke kondisi semula
            $('#tblChutter').DataTable().clear().draw();
            // Menampilkan divLokal
            document.getElementById("divLokal").style.display =
                "block";

            // Sembunyikan divChutter
            document.getElementById("divChutter").style.display =
                "none";

            // Fokuskan input1
            input1.focus();

            // Kosongkan nilai input1
            input1.val("");

            // Kosongkan nilai input2
            input2.val("");
        });

        // button add to inputan chutter
        var isChutterActive = false;

        document.getElementById("addChutter").addEventListener("click",
            function() {
                // Toggle status
                isChutterActive = !isChutterActive;

                if (isChutterActive) {
                    // Sembunyikan divLokal dan fokuskan input2
                    document.getElementById("divLokal").style.display =
                        "none";
                    document.getElementById("divChutter").style
                        .display = "block";
                    document.getElementById("input2").focus();
                    document.getElementById("input1").value =
                        ""; // Bersihkan nilai input1
                } else {
                    // Tampilkan divLokal, sembunyikan divChutter, dan fokuskan input1
                    document.getElementById("divLokal").style.display =
                        "block";
                    document.getElementById("divChutter").style
                        .display = "none";
                    document.getElementById("input1").focus();
                    document.getElementById("input2").value =
                        ""; // Bersihkan nilai input2
                }
            });

    });
</script>
