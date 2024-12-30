<script>
    $(document).ready(function() {
        // Deklarasi Variable
        var input1 = $("#input1");
        var input2 = $("#input2");
        var reset = $("#reset");
        // Inisialisasi DataTables
        var table = $('#tblChutter').DataTable({
            processing: true, // Menampilkan spinner pemrosesan
            serverSide: true, // Menggunakan pemrosesan di server
            ajax: {
                url: "{{ route('get_datatables_outchuter') }}", // URL untuk mendapatkan data
            },
            order: [
                [0, 'desc'] // Urutkan berdasarkan kolom pertama secara menurun
            ],
            responsive: true, // Responsif untuk tampilan layar yang lebih kecil
            columns: [{
                    data: 'item_code'
                },
                {
                    data: 'part_name'
                },
                {
                    data: 'seq'
                },
                {
                    data: 'kanban_no'
                },
                {
                    data: 'qty',
                    class: 'text-center'
                },
                {
                    data: 'to_sloc',
                    class: 'text-center'
                },
                {
                    data: 'action', // Kolom untuk aksi
                    name: 'action',
                    orderable: false, // Tidak bisa diurutkan
                    searchable: false // Tidak bisa dicari
                }
            ],
            paging: false, // Nonaktifkan paging
            searching: false, // Nonaktifkan pencarian
            ordering: false, // Nonaktifkan pengurutan
            lengthChange: false, // Nonaktifkan pengubahan jumlah baris yang ditampilkan
            drawCallback: function(settings) {
                // Tambahkan style border biru pada seluruh tabel
                $('#tblChutter').css({
                    "border": "1px solid blue" // Border style untuk tabel
                });
                // Tambahkan style border biru pada sel header
                $('#tblChutter thead th').css({
                    "border": "1px solid blue" // Border style untuk header
                });
                // Tambahkan style border biru pada sel data
                $('#tblChutter tbody td').css({
                    "border": "1px solid blue" // Border style untuk data
                });
            }
        });

        input1.focus();

        function showLoading() {
            $('.loading-spinner-container').show(); // Show loading spinner
        }

        function hideLoading() {
            $('.loading-spinner-container').hide(); // Hide loading spinner
        }
        // Input field 1
        input1.on("keydown", function(e) {
            if (e.key === "Enter") {
                e.preventDefault(); // Prevent default form submission

                if (input1.val() !== "") {
                    var value = input1.val();
                    if (value.includes(',')) {
                        var splitData = value.split(',');

                        if (splitData.length > 1) {
                            // console.log(splitData);
                            var chuter = splitData[0];
                            $('#chuterCreate').val(chuter);

                            var table = $('#tblChutter').DataTable();
                            getDataChuter(chuter);
                            // Check if the table is empty
                        } else {
                            input1.val("");
                            input1.focus();
                        }
                    } else {
                        input1.val("");
                        input1.focus();
                    }
                }
            }
        });

        // get data chuter address base on chuter
        function getDataChuter(chuter) {
            $('#ItemModalchuter').modal('show');
            $('#input1').val('');

            // Initialize the DataTable
            var lookUpdataItemcodeIn = $('#lookUpdataItemcodeIn').DataTable();
            lookUpdataItemcodeIn.destroy(); // Destroy any existing instance of the DataTable

            lookUpdataItemcodeIn = $('#lookUpdataItemcodeIn').DataTable({
                "pagingType": "numbers",
                ajax: {
                    url: "{{ route('get_data_chuter') }}", // Server URL
                    data: function(d) {
                        // Add the chuter parameter to the request
                        d.chuter = chuter; // Pass the chuter variable here
                    }
                },
                serverSide: true,
                deferRender: true,
                responsive: true,
                "bFilter": false, // Disable global searching
                "order": [
                    [1, 'asc']
                ], // Default ordering
                searching: true,
                columns: [{
                        "data": "item_code"
                    },
                    {
                        "data": "part_name"
                    },
                    {
                        "data": "kanban_no"
                    },
                    {
                        "data": "seq"
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    // Apply inline styles to all columns in the row
                    $(row).find('td').css('font-size', '14px'); // Set font size
                },
                "initComplete": function(settings, json) {
                    // Event listener for double-clicking a row
                    $(document).on('dblclick', '#lookUpdataItemcodeIn tbody tr', function() {
                        var rowItem1 = $(this);
                        var rowData = lookUpdataItemcodeIn.row(rowItem1)
                            .data(); // Use .row(), not .rows()

                        if (rowData) { // Check if rowData is not undefined
                            // console.log(rowData);

                            // Update the form fields with the selected data
                            $('#itemcodeCreate').val(rowData["item_code"]);
                            $('#partCreate').val(rowData["part_name"]);
                            $('#seqCreate').val(rowData["seq"]);
                            $('#kanbanCreate').val(rowData["kanban_no"]);

                            // Hide the current modal and show the Insert Qty modal
                            $('#ItemModalchuter').modal('hide');
                            $('#ItemModalInsertQty').modal('show');

                            // Set focus to the quantity input field
                            $('#qtyCreate').focus();
                        } else {
                            console.error("No data found for the selected row.");
                        }
                    });
                },
            });

        }



        // Function to reset all input fields when the modal is closed
        $('#closeModalBtn').on('click', function() {
            // Reset each field to an empty value
            $('#itemcodeCreate').val('');
            $('#qtyCreate').val('');
            $('#partCreate').val('');
            $('#seqCreate').val('');
            $('#kanbanCreate').val('');
            $('#chuterCreate').val('');
            $('#slocCreate').val('');

            // If you want to also reset focus to a specific input, you can use:
            $('#itemcodeCreate').focus(); // Optional: Set focus back to itemcodeCreate
        });


        // save button for save modal qty
        $('#saveModalBtn').on('click', function() {
            // Get the values of the input fields
            var itemcode = $('#itemcodeCreate').val();
            var qty = $('#qtyCreate').val();
            var sloc = $('#slocCreate').val();

            // Validate if the fields are not empty
            if (itemcode === "" || qty === "" || sloc === "") {
                alert("input cannot be empty!");
                document.getElementById('Audioerror').play(); // Mainkan audio error
                Swal.fire({
                    icon: 'error',
                    title: 'Input Cannot be Empty!',
                    html: '<span style="color: red;">Inputan Tidak Boleh Kosong</span>',
                    showConfirmButton: true,
                }).then((result) => {

                    $('#qtyCreate').focus();
                    $('#qtyCreate').val("");
                });
                return; // Stop the AJAX call if validation fails
            }

            // Prepare the data object to send to the server
            var data = {
                itemcode: itemcode,
                qty: qty,
                _token: '{{ csrf_token() }}' // Include CSRF token if needed
            };

            // Send AJAX request
            $.ajax({
                url: "{{ route('check_stock_sap') }}", // Server-side route
                type: "GET",
                data: {
                    itemcode: $('#itemcodeCreate').val(),
                    qty: $('#qtyCreate').val(),
                    _token: '{{ csrf_token() }}' // Sertakan token CSRF
                },
                dataType: 'json', // Mengharapkan respons dalam format JSON
                beforeSend: function() {
                    showLoading(); // Menampilkan loading spinner
                },
                success: function(response) {
                    console.log(response); // Melihat respons dari server

                    if (response.status === 'success') {
                        createDataOutTransit();

                    } else if (response.status === 'error') {
                        console.log('Error: ' + response
                            .message); // Menampilkan pesan error dari respons
                        document.getElementById('Audioerror').play(); // Mainkan audio error
                        Swal.fire({
                            icon: 'error',
                            title: 'Quantity Exceeds Available Stock',
                            html: '<span style="color: red;">Jumlah yang dimasukkan melebihi stok yang tersedia.</span>',
                            showConfirmButton: true,
                        }).then((result) => {

                            $('#qtyCreate').focus();
                            $('#qtyCreate').val("");
                        });
                    }
                },

                complete: function() {
                    hideLoading(); // Sembunyikan loading spinner setelah selesai
                }
            });
            // create data out chuter
            function createDataOutTransit() {
                $.ajax({
                    url: "{{ route('create_data_out_transit') }}", // Server-side route
                    type: "POST", // POST method
                    data: $('#create-data-qty').serialize(), // Serialize form data
                    dataType: 'json', // Expecting JSON response
                    beforeSend: function() {
                        showLoading(); // Show loading spinner
                    },
                    success: function(response) {
                        console.log(response); // Debugging: Check entire response

                        if (response.status === 'success') {
                            // alert('Success: ' + response.message);
                            document.getElementById('Audiosucces').play();

                            $('#create-data-qty').find(
                                'input[type="text"], input[type="number"]'
                            ).val(''); // Clear text and number inputs

                            // Reset the dropdown to the default option
                            $('#slocCreate').val(
                            ''); // Set the dropdown to its default value

                            // Sembunyikan modal
                            $('#ItemModalInsertQty').modal('hide');

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Data Saved Successfully',
                            });

                            $('#tblChutter').DataTable().ajax.reload(); // Reload tabel
                            // Fokuskan pada input pertama (input1)
                            $('#input1').focus(); // Fokus pada input1
                            input1.focus();
                        } else {
                            // console.log('Error: ' +
                            document.getElementById('Audioerror')
                                .play(); // Mainkan audio error
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Hub IT',
                                showConfirmButton: true,
                            }).then((result) => {
                                $('#qtyCreate').focus();
                                $('#qtyCreate').val(""); // Kosongkan input qty
                            });
                            $('#create-data-qty').find(
                                'input[type="text"], input[type="number"]').val('');

                            // Fokuskan pada input pertama
                            input1.focus();

                            // Sembunyikan modal
                            $('#ItemModalInsertQty').modal('hide');
                        }
                    },
                    error: function(jqXHR) {
                        let errorMessage = 'An unexpected error occurred.';
                        if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                            errorMessage = jqXHR.responseJSON.message;
                        }
                        alert('Error: ' + errorMessage);
                    },
                    complete: function() {
                        hideLoading
                            (); // Hide the loading spinner after the request is complete
                    }
                });
            }


        });


        // button click post
        document.getElementById('post').addEventListener('click', function() {
            // Retrieve the DataTable instance
            var table = $('#tblChutter').DataTable();
            console.log(table);
            // Initialize an array to store the table data
            var tableData = [];

            // Iterate through all rows of the table
            table.rows().every(function(rowIdx, tableLoop, rowLoop) {
                // Get the data for each row
                var data = this.data();

                // Push the row data to the tableData array
                tableData.push({
                    item_code: data.item_code,
                    part_name: data.part_name,
                    seq: data.seq,
                    kanban_no: data.kanban_no,
                    qty: data.qty,
                    to_sloc: data.to_sloc
                });
            });

            // Check if tableData is empty
            if (tableData.length === 0) {
                document.getElementById('Audioerror').play();
                Swal.fire({
                    icon: 'error',
                    title: 'Data Not Found',
                    text: 'No data available in the table to post.',
                    showConfirmButton: true, // Menampilkan tombol OK
                }).then(() => {
                    // Set focus to input1 after the alert is closed
                    $('#input1').focus();
                });
                return; // Exit the function if there's no data
            }

            // Show SweetAlert loading
            Swal.fire({
                title: 'Processing...',
                text: 'Please wait for Post.',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                }
            });

            // Send the data via AJAX request
            $.ajax({
                url: 'post_tp_outchuter', // Ganti dengan URL endpoint yang sesuai
                method: 'POST',
                data: {
                    tableData: tableData,
                    _token: '{{ csrf_token() }}' // Pastikan untuk menyertakan CSRF token jika diperlukan
                },
                success: function(response) {
                    // Close the loading alert
                    Swal.close();

                    if (response.message === 'Data post successfully') {
                        Swal.fire({
                            icon: 'success',
                            title: response.message, // Pesan sukses dari controller
                            text: `BPB NO "${response.bpb_no}"`, // Menampilkan BPB NO dari response
                        });

                        $('#tblChutter').DataTable().ajax.reload(); // Reload tabel
                        $('#input1').focus(); // Fokus pada input1
                    }
                },
                error: function(error) {
                    // Close the loading alert
                    Swal.close();

                    let errorMessage = error.responseJSON?.message ||
                        'Unknown error occurred'; // Pesan error dari response
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage, // Ganti dengan pesan error dari controller
                    });
                }
            });
        });


        // delete data out chuter for datatables
        $(document).on('click', '.delete', function(e) {
            e.preventDefault();

            var id = $(this).attr('row-id');
            var itemcode_database = $(this).attr('data-itemCode');
            var kanban_database = $(this).attr('data-kanbanNo');
            var seq_database = $(this).attr('data-seq');

            // Menampilkan SweetAlert loading
            Swal.fire({
                title: 'Please wait...',
                text: 'Deleting the record...',
                allowOutsideClick: false, // Menghindari klik di luar swal
                onOpen: () => {
                    Swal.showLoading(); // Menampilkan loading
                }
            });

            $.ajax({
                url: 'delete_outchuter_datatables', // Ganti dengan URL endpoint yang sesuai
                method: 'POST',
                data: {
                    id: id,
                    itemcode_database: itemcode_database,
                    kanban_database: kanban_database,
                    seq_database: seq_database,
                    _token: '{{ csrf_token() }}' // Token CSRF untuk keamanan
                },
                success: function(response) {
                    // Menyembunyikan SweetAlert loading
                    Swal.close(); // Menutup loading

                    // Menampilkan pesan sukses
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message, // Pesan sukses dari controller
                    });
                    // Reload atau update tabel jika diperlukan
                    $('#tblChutter').DataTable().ajax.reload();
                    $('#input1').focus();
                },
                error: function(error) {
                    // Menyembunyikan SweetAlert loading
                    Swal.close(); // Menutup loading

                    // Menangani respons error
                    let errorMessage = error.responseJSON?.message ||
                        'Unknown error occurred'; // Pesan error dari response
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage, // Ganti dengan pesan error dari controller
                    });
                }
            });
        });

        reset.on("click", function() {
            // Kode di bawah ini akan mengembalikan tampilan ke kondisi semula
            $('#tblChutter').DataTable().clear().draw();
            // Menampilkan divLokal
            document.getElementById("divLokal").style.display = "block";

            // Sembunyikan divChutter
            document.getElementById("divChutter").style.display = "none";

            // Fokuskan input1
            input1.focus();

            // Kosongkan nilai input1
            input1.val("");

            // Kosongkan nilai input2
            input2.val("");
        });


        // var isChutterActive = false;

        // document.getElementById("addChutter").addEventListener("click", function() {
        //     // Toggle status
        //     isChutterActive = !isChutterActive;

        //     if (isChutterActive) {
        //         // Sembunyikan divLokal dan fokuskan input2
        //         document.getElementById("divLokal").style.display = "none";
        //         document.getElementById("divChutter").style.display = "block";
        //         document.getElementById("input2").focus();
        //         document.getElementById("input1").value = ""; // Bersihkan nilai input1
        //     } else {
        //         // Tampilkan divLokal, sembunyikan divChutter, dan fokuskan input1
        //         document.getElementById("divLokal").style.display = "block";
        //         document.getElementById("divChutter").style.display = "none";
        //         document.getElementById("input1").focus();
        //         document.getElementById("input2").value = ""; // Bersihkan nilai input2
        //     }
        // });


    });
</script>
