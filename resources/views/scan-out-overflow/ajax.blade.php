<script>
    $(document).ready(function() {
        // Deklarasi Variable
        var input1 = $("#input1");
        var input2 = $("#input2");
        var reset = $("#reset");

        // var table = $("#tblOverflow").DataTable();
        var table = $('#tblOverflow').DataTable({
            "paging": false, // Nonaktifkan paging
            "searching": false,
            "ordering": false,
            "lengthChange": false,
            "responsive": true,
            "drawCallback": function(settings) {
                // Tambahkan style border biru pada seluruh tabel
                $('#tblOverflow').css({
                    "border": "1px solid blue" // Border style
                });
                // Tambahkan style border biru pada sel header
                $('#tblOverflow thead th').css({
                    "border": "1px solid blue" // Border style
                });
                // Tambahkan style border biru pada sel data
                $('#tblOverflow tbody td').css({
                    "border": "1px solid blue" // Border style
                });
            }
        });

        input1.focus();
        // Input field 1
        input1.on("keydown", function(e) {
            if (event.key === "Enter") {
                // checkInput();
                if (input1.val() != "") {
                    var value = input1.val();
                    // var spliteData1 = value.split(',');
                    // jika berisi koma
                    if (value.includes(',')) {
                        var spliteData1 = value.split(',');
                        // inputan koma 7
                        if (spliteData1.length === 7) {
                            if (spliteData1.length > 1) {
                                // console.log(spliteData1);
                                var getItemcodelocal = spliteData1[3];
                                // console.log(getItemcodelocal);
                                $("#itemcodeLokal").val(getItemcodelocal);
                                // input1.attr('readonly', true);
                                var itemLokal = $('#itemcodeLokal').val();
                                // console.log(itemLokal);
                                // alert(itemLokal);
                                addDataToTable(spliteData1);
                                $('#input1').focus();
                            } else {
                                input1.val("");

                                $('#input1').focus();
                            }

                            // inputan koma 8
                        } else if (spliteData1.length === 8) {
                            if (spliteData1.length > 1) {
                                var getItemcodelocal = spliteData1[4];
                                // console.log(spliteData1);
                                // console.log(getItemcodelocal);
                                $("#itemcodeLokal").val(getItemcodelocal);
                                var itemLokal = $('#itemcodeLokal').val();
                                addDataToTable2(spliteData1);
                            } else {
                                input1.val("");
                                $('#input1').focus();
                            }
                        } else {
                            // Jika jumlah koma tidak sesuai, berikan pesan atau tindakan yang sesuai
                            // alert("Jumlah koma tidak sesuai. Input tidak dapat diproses.");
                            input1.val("");
                            $('#input1').focus();
                        }
                    } else {
                        // Jika tidak ada koma dalam input
                        // alert("Input tidak mengandung koma. Input tidak dapat diproses.");
                        input1.val("");
                        $('#input1').focus();
                    }

                } else {
                    // reset.removeClass("d-none")
                    // input1.attr("readonly", true);
                }
                return false;
            }
        });


        // funtion add to tabel to koma 7...
        function addDataToTable(spliteData1) {
            var getKanban = spliteData1[0];
            var getSquence = spliteData1[1];
            var getPartno = spliteData1[2];
            var getItemcode = spliteData1[3];
            var getQty = spliteData1[4];
            // alert('ok');
            // Menampilkan loading spinner
            function showLoading() {
                $('.loading-spinner-container').show();
            }

            // Menyembunyikan loading spinner
            function hideLoading() {
                $('.loading-spinner-container').hide();
            }

            // validasi in overflow
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                }
            });
            $.ajax({
                url: "{{ route('validasi_data_overflow') }}",
                type: "get",
                data: {
                    getSquence: getSquence,
                    getKanban: getKanban
                }, // Data yang akan dikirim ke server
                dataType: 'json',
                beforeSend: function() {
                    showLoading(); // Memanggil fungsi showLoading sebelum request
                },
                success: function(response) {
                    function showLoading() {
                        $('.loading-spinner-container').show();
                    }

                    // Menyembunyikan loading spinner
                    function hideLoading() {
                        $('.loading-spinner-container').hide();
                    }
                    if (response.get_data_over !== undefined && response.get_data_over !== "") {
                        // alert('lanjut validasi');
                        // validasi out overflow on tbl chuter_overflow_in_out_log
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            }
                        });
                        $.ajax({
                            url: "{{ route('validasi_data_out_overflow') }}",
                            type: "get",
                            data: {
                                getSquence: getSquence,
                                getKanban: getKanban
                            }, // Data yang akan dikirim ke server
                            dataType: 'json',
                            beforeSend: function() {
                                showLoading
                                    (); // Memanggil fungsi showLoading sebelum request
                            },
                            success: function(response) {
                                if (response.get_data_out_over != "") {
                                    //  validasi fifo out overflow
                                    $.ajax({
                                        url: "{{ route('validasi_fifo_out_overflow') }}",
                                        type: "get",
                                        data: {
                                            getSquence: getSquence,
                                            getKanban: getKanban
                                        }, // Data yang akan dikirim ke server
                                        dataType: 'json',
                                        beforeSend: function() {
                                            showLoading
                                                (); // Memanggil fungsi showLoading sebelum request
                                        },
                                        success: function(response) {
                                            if (response.message ===
                                                "success") {
                                                handleTableOperations(
                                                    getKanban,
                                                    getSquence,
                                                    getPartno,
                                                    getItemcode, getQty
                                                    ); // Perform table operations

                                            } else {
                                                // alert('eror');
                                                showError(`Data OverFlow Tgl: ${response.date}`);
                                                // hideLoading();
                                                // if ("vibrate" in
                                                //     navigator) {
                                                //     navigator.vibrate([
                                                //         1000]);
                                                // }
                                                // document.getElementById('Audioerror').play();

                                                // Swal.fire({
                                                //     icon: 'error',
                                                //     title: 'Error',
                                                //     text: `Data OverFlow Tgl: ${response.date}`,
                                                //     showConfirmButton: true, // Menampilkan tombol OK
                                                // });
                                                // input1.val("")
                                                //     .focus();
                                            }
                                        }

                                    });

                                } else {

                                    showError('Data Sudah Out Overflow');
                                    // alert('eror');
                                    // if ("vibrate" in navigator) {
                                    //     navigator.vibrate([1000]);
                                    // }
                                    // document.getElementById('Audioerror').play();
                                    // swal.fire({
                                    //     icon: 'error',
                                    //     title: 'Error',
                                    //     text: 'Data Sudah Out Overflow',
                                    //     showConfirmButton: true, // Menampilkan tombol OK
                                    //     // timer: 2000, // Menampilkan selama 2 detik
                                    // });
                                    // input1.val("");
                                    // input1.focus();
                                }
                            },
                            error: function(xhr, status, error) {
                                // Menangani kesalahan dalam melakukan request Ajax
                                alert("Terjadi kesalahan: " + error);
                            },
                            complete: function() {
                                hideLoading
                                    (); // Memanggil fungsi hideLoading setelah request selesai
                            }
                        });
                    } else {
                        // alert('eror');
                        showError('Data Belum di Scan In Overflow');
                        // if ("vibrate" in navigator) {
                        //     navigator.vibrate([1000]);
                        // }
                        // document.getElementById('Audioerror').play();
                        // swal.fire({
                        //     icon: 'error',
                        //     title: 'Data Not Found',
                        //     text: 'Data Belum di Scan In Overflow',
                        //     showConfirmButton: true, // Menampilkan tombol OK
                        //     // timer: 2000, // Menampilkan selama 2 detik
                        // });
                        // input1.val("");
                        // input1.focus();
                    }
                },
                error: function(xhr, status, error) {
                    // Menangani kesalahan dalam melakukan request Ajax
                    alert("Terjadi kesalahan: " + error);
                },
                complete: function() {
                    hideLoading(); // Memanggil fungsi hideLoading setelah request selesai
                }
            });

        }

        // Function to show the loading spinner
        function showLoading() {
            $('.loading-spinner-container').show();
        }

        // Function to hide the loading spinner
        function hideLoading() {
            $('.loading-spinner-container').hide();
        }

        // Main function to handle table operations such as adding rows and validating data
        function handleTableOperations(getKanban, getSquence, getPartno, getItemcode, getQty) {
            var table = $('#tblOverflow').DataTable();

            // Check if the table is empty
            if (table.data().count() === 0) {
                hideLoading(); // Hide loading spinner
                addRowToTable(table, getItemcode, getPartno, getSquence, getKanban, getQty); // Add a new row
                resetInputFields(); // Reset input fields after adding a row
            } else {
                var partNoExists = checkPartNumberExists(table,
                getPartno); // Check if part number exists in the table

                if (partNoExists) {
                    var sequenceIsUnique = checkSequenceUnique(table,
                    getSquence); // Check if the sequence is unique

                    if (sequenceIsUnique) {
                        addRowToTable(table, getItemcode, getPartno, getSquence, getKanban,
                        getQty); // Add a new row
                        resetInputFields(); // Reset input fields after adding a row
                    } else {
                        showError('Sequence Tidak Boleh Sama'); // Show error if sequence is not unique
                    }
                } else {
                    showError('Part No Tidak Sama'); // Show error if part number is not found
                }
            }
        }

        // Function to check if the part number exists in the table
        function checkPartNumberExists(table, getPartno) {
            var partNoExists = false;
            table.rows().every(function() {
                var rowData = this.data();
                var existingPartNo = rowData[1];
                var valuePartno = $(existingPartNo).val();
                if (valuePartno == getPartno) {
                    partNoExists = true;
                    return false; // Exit loop if a matching Part No is found
                }
            });
            return partNoExists;
        }

        // Function to check if the sequence is unique in the table
        function checkSequenceUnique(table, getSquence) {
            var sequenceIsUnique = true;
            table.rows().every(function() {
                var rowData = this.data();
                var existingSequence = rowData[2];
                var valueSequence = $(existingSequence).val();
                if (valueSequence == getSquence) {
                    sequenceIsUnique = false;
                }
            });
            return sequenceIsUnique;
        }

        // Function to add a new row to the table
        function addRowToTable(table, getItemcode, getPartno, getSquence, getKanban, getQty) {
            var counter = table.rows().count();
            var jml_row = Number(counter) + 1;

            var Itemcode = "Itemcode" + jml_row;
            var part_no = "part_no" + jml_row;
            var Squence = "Squence" + jml_row;
            var Kanban = "Kanban" + jml_row;
            var Qty = "Qty" + jml_row;

            table.row.add([
                '<input type="text" class=" text-center" id="' + Itemcode +
                '" name="Itemcode[]" value="' + getItemcode + '" readonly>',
                '<input type="text" class=" text-center" id="' + part_no +
                '" name="part_no[]" value="' + getPartno + '" readonly>',
                '<input type="text" class=" text-center" id="' + Squence +
                '" name="Squence[]" value="' + getSquence + '" readonly>',
                '<input type="text" class=" text-center" id="' + Kanban + '" name="Kanban[]" value="' +
                getKanban + '">',
                '<input type="text" class=" text-center" id="' + Qty + '" name="Qty[]" value="' +
                getQty + '">',
            ]).draw();
        }

        // Function to reset the input fields after adding a row
        function resetInputFields() {
            input1.val("");
            input1.attr('readonly', false);
            $('#input1').focus();
        }

        // Function to display an error message using SweetAlert
        function showError(message) {
            hideLoading(); // Hide loading spinner
            if ("vibrate" in navigator) {
                navigator.vibrate([1000]); // Vibrate if supported by the device
            }
            document.getElementById('Audioerror').play(); // Play error sound
            swal.fire({
                icon: 'error',
                title: 'Error',
                text: message,
                showConfirmButton: true, // Show OK button
            });
            input1.val("");
            $('#input1').focus();
        }



        // funtion add to tabel to koma 8...
        // function addDataToTable2(spliteData1) {

        //     var getKanban = spliteData1[1];
        //     var getSquence = spliteData1[2];
        //     var getPartno = spliteData1[3];
        //     var getItemcode = spliteData1[4];
        //     var getQty = spliteData1[5];
        //     // console.log(spliteData1);
        //     // console.log(getSquence);
        //     // console.log(getPartno);
        //     // console.log(getItemcode);
        //     function showLoading() {
        //         $('.loading-spinner-container').show();
        //     }

        //     // Menyembunyikan loading spinner
        //     function hideLoading() {
        //         $('.loading-spinner-container').hide();
        //     }

        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
        //                 'content')
        //         }
        //     });
        //     $.ajax({
        //         url: "{{ route('validasi_itemcode_fgin') }}",
        //         type: "get",
        //         data: {
        //             getSquence: getSquence,
        //             getItemcode: getItemcode
        //         }, // Data yang akan dikirim ke server
        //         dataType: 'json',
        //         beforeSend: function() {
        //             showLoading(); // Memanggil fungsi showLoading sebelum request
        //         },
        //         success: function(response) {
        //             function showLoading() {
        //                 $('.loading-spinner-container').show();
        //             }

        //             // Menyembunyikan loading spinner
        //             function hideLoading() {
        //                 $('.loading-spinner-container').hide();
        //             }
        //             // Menggunakan if-else untuk menangani berbagai respons
        //             if (response.message === "data_not") {
        //                 // Menangani ketika data tidak ada di tabel
        //                 if ("vibrate" in navigator) {
        //                     navigator.vibrate([1000]);
        //                 }
        //                 document.getElementById('Audioerror').play();
        //                 swal.fire({
        //                     icon: 'error',
        //                     title: 'Data Not Found',
        //                     text: 'Data Belum di Scan In Fg',
        //                     showConfirmButton: true, // Menampilkan tombol OK
        //                     // timer: 2000, // Menampilkan selama 2 detik
        //                 });
        //                 input1.val("");
        //                 input1.focus();
        //             } else if (response.message === "null") {
        //                 // Menangani ketika kolom chutter_address null
        //                 if (table.data().count() === 0) {
        //                     function showLoading() {
        //                         $('.loading-spinner-container').show();
        //                     }

        //                     // Menyembunyikan loading spinner
        //                     function hideLoading() {
        //                         $('.loading-spinner-container').hide();
        //                     }
        //                     // validasi to ekanban_fgout
        //                     hideLoading();
        //                     var t = $('#tblOverflow')
        //                         .DataTable();
        //                     var counter = t.rows()
        //                         .count();
        //                     var jml_row = Number(
        //                         counter) + 1;
        //                     var Itemcode =
        //                         "Itemcode" +
        //                         jml_row;
        //                     var part_no =
        //                         "part_no" + jml_row;
        //                     var Squence =
        //                         "Squence" + jml_row;
        //                     var Kanban = "Kanban" +
        //                         jml_row;
        //                     var Qty = "Qty" +
        //                         jml_row;
        //                     t.row.add([
        //                         '<input type="text" class=" text-center" id="' +
        //                         Itemcode +
        //                         '" name="Itemcode[]" value="' +
        //                         getItemcode +
        //                         '" readonly>',
        //                         '<input type="text" class=" text-center" id="' +
        //                         part_no +
        //                         '" name="part_no[]" value="' +
        //                         getPartno +
        //                         '" readonly>',
        //                         '<input type="text" class=" text-center" id="' +
        //                         Squence +
        //                         '" name="Squence[]" value="' +
        //                         getSquence +
        //                         '" readonly>',
        //                         '<input type="text" class=" text-center" id="' +
        //                         Kanban +
        //                         '" name="Kanban[]" value="' +
        //                         getKanban +
        //                         '" >',
        //                         '<input type="text" class=" text-center" id="' +
        //                         Qty +
        //                         '" name="Qty[]" value="' +
        //                         getQty +
        //                         '" >',
        //                     ]).draw();
        //                     input1.val("");
        //                     input1.attr('readonly',
        //                         false);
        //                     $('#input1').focus();

        //                 } else {

        //                     // validasi data kosong
        //                     // partno harus sama
        //                     // Tabel tidak kosong, periksa apakah Part No sudah ada dalam tabel
        //                     var t = $(
        //                             '#tblOverflow'
        //                         )
        //                         .DataTable();
        //                     var counter = t
        //                         .rows()
        //                         .count();
        //                     var jml_row =
        //                         Number(
        //                             counter
        //                         ) + 1;
        //                     var Itemcode =
        //                         "Itemcode" +
        //                         jml_row;
        //                     var part_no =
        //                         "part_no" +
        //                         jml_row;
        //                     var Squence =
        //                         "Squence" +
        //                         jml_row;
        //                     var Kanban =
        //                         "Kanban" +
        //                         jml_row;
        //                     var Qty =
        //                         "Qty" +
        //                         jml_row;
        //                     t.row.add([
        //                         '<input type="text" class=" text-center" id="' +
        //                         Itemcode +
        //                         '" name="Itemcode[]" value="' +
        //                         getItemcode +
        //                         '" readonly>',
        //                         '<input type="text" class=" text-center" id="' +
        //                         part_no +
        //                         '" name="part_no[]" value="' +
        //                         getPartno +
        //                         '" readonly>',
        //                         '<input type="text" class=" text-center" id="' +
        //                         Squence +
        //                         '" name="Squence[]" value="' +
        //                         getSquence +
        //                         '" readonly>',
        //                         '<input type="text" class=" text-center" id="' +
        //                         Kanban +
        //                         '" name="Kanban[]" value="' +
        //                         getKanban +
        //                         '" >',
        //                         '<input type="text" class=" text-center" id="' +
        //                         Qty +
        //                         '" name="Qty[]" value="' +
        //                         getQty +
        //                         '" >',
        //                     ]).draw();

        //                     input1.val("");
        //                     input1.attr(
        //                         'readonly',
        //                         false);
        //                     $('#input1')
        //                         .focus();

        //                     input1.val("");
        //                     input1.attr(
        //                         'readonly',
        //                         false);
        //                     $('#input1')
        //                         .focus();

        //                 }
        //             } else if (response.message == "Already") {
        //                 hideLoading();
        //                 if ("vibrate" in navigator) {
        //                     navigator.vibrate([1000]);
        //                 }
        //                 document.getElementById('Audioerror').play();
        //                 swal.fire({
        //                     icon: 'error',
        //                     title: 'Data Already Exist',
        //                     text: 'Data Sudah Scan In Overflow',
        //                     showConfirmButton: true, // Menampilkan tombol OK
        //                 });
        //                 input1.val("");
        //                 input1.focus();
        //             } else if (response.message === "not_null") {
        //                 // Menangani ketika kolom chutter_address sudah ada
        //                 hideLoading();
        //                 if ("vibrate" in navigator) {
        //                     navigator.vibrate([1000]);
        //                 }
        //                 document.getElementById('Audioerror').play();
        //                 swal.fire({
        //                     icon: 'error',
        //                     title: 'Data Already Exist',
        //                     text: 'Data Sudah Di Scan Chutter',
        //                     showConfirmButton: true, // Menampilkan tombol OK
        //                 });
        //                 input1.val("");
        //                 input1.focus();
        //             }
        //         },
        //         error: function(xhr, status, error) {
        //             // Menangani kesalahan dalam melakukan request Ajax
        //             alert("Terjadi kesalahan: " + error);
        //         },
        //         complete: function() {
        //             hideLoading(); // Memanggil fungsi hideLoading setelah request selesai
        //         }
        //     });


        // }


        // var input2 = $("#input2");

        // Attach keydown event listener
        input2.on("keydown", function(e) {
            if (e.which === 13) { // 13 is the Enter key
                var inputValue = input2.val().trim(); // Get the value and trim whitespace

                if (inputValue === "OVERFLOW") {
                    // Logic if input value is "OVERFLOW"
                    alert("Input is OVERFLOW.");



                    function showLoading() {
                        $('.loading-spinner-container').show();
                    }

                    // Menyembunyikan loading spinner
                    function hideLoading() {
                        $('.loading-spinner-container').hide();
                    }


                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                .attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{ route('add_out_overflow') }}",
                        type: "POST",
                        data: $('#formOverflow').serialize(),
                        dataType: 'json',
                        beforeSend: function() {
                            showLoading(); // Menampilkan indikator loading
                        },
                        success: function(data) {
                            hideLoading(); // Menyembunyikan indikator loading

                            if (data.message === "Successful") {
                                // Update UI untuk status sukses
                                input1.attr("readonly", false);
                                document.getElementById("divLokal").style.display = "block";
                                document.getElementById("divOver").style.display = "none";
                                document.getElementById('Audiosucces').play();
                                input1.focus();
                                input1.val("");
                                input2.val("");
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Data Saved Successfully',
                                });
                                $('#tblOverflow').DataTable().clear().draw();
                            } else {
                                // Update UI untuk status error
                                input1.attr("readonly", false);
                                $('#itemcodeChutter').val("");
                                $('#itemcodeLokal').val("");
                                document.getElementById("divLokal").style.display = "block";
                                document.getElementById("divOver").style.display = "none";
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
                                $('#tblOverflow').DataTable().clear().draw();
                            }
                        },
                        error: function(xhr) {
                            hideLoading
                                (); // Menyembunyikan indikator loading jika terjadi kesalahan

                            // Menangani kesalahan jika ada
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi Kesalahan dalam Permintaan',
                            });
                        }
                    });

                    // Add your logic here
                } else {
                    // Logic for any other input value
                    alert("Input is something else.");
                    // Add your logic here
                    input2.val("");
                }
            }
        });



        reset.on("click", function() {
            // Kode di bawah ini akan mengembalikan tampilan ke kondisi semula
            $('#tblOverflow').DataTable().clear().draw();
            // Menampilkan divLokal
            document.getElementById("divLokal").style.display = "block";

            // Sembunyikan divOver
            document.getElementById("divOver").style.display = "none";

            // Fokuskan input1
            input1.focus();

            // Kosongkan nilai input1
            input1.val("");

            // Kosongkan nilai input2
            input2.val("");
        });

        // button add to inputan chutter
        var isChutterActive = false;

        document.getElementById("addOverflow").addEventListener("click", function() {
            // Toggle status
            isChutterActive = !isChutterActive;

            if (isChutterActive) {
                // Sembunyikan divLokal dan fokuskan input2
                document.getElementById("divLokal").style.display = "none";
                document.getElementById("divOver").style.display = "block";
                document.getElementById("input2").focus();
                document.getElementById("input1").value = ""; // Bersihkan nilai input1
            } else {
                // Tampilkan divLokal, sembunyikan divOver, dan fokuskan input1
                document.getElementById("divLokal").style.display = "block";
                document.getElementById("divOver").style.display = "none";
                document.getElementById("input1").focus();
                document.getElementById("input2").value = ""; // Bersihkan nilai input2
            }
        });
    });
</script>
