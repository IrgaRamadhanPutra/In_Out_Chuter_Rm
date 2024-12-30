<script>
    $(document).ready(function() {
        // var table = $('#tblChutter').DataTable({
        //     "paging": false, // Nonaktifkan paging
        //     "searching": false,
        //     "ordering": false,
        //     "lengthChange": false,
        //     "responsive": true,
        //     "drawCallback": function(settings) {
        //         // Tambahkan style border biru pada seluruh tabel
        //         $('#tblChutter').css({
        //             "border": "1px solid blue" // Border style
        //         });
        //         // Tambahkan style border biru pada sel header
        //         $('#tblChutter thead th').css({
        //             "border": "1px solid blue" // Border style
        //         });
        //         // Tambahkan style border biru pada sel data
        //         $('#tblChutter tbody td').css({
        //             "border": "1px solid blue" // Border style
        //         });
        //     }
        // });


        // Get elements for itemcode and chuter
        const toggleButton = document.getElementById('buttonItemcode');
        const cardSearchItemcode = document.getElementById('cardSearchitemcode');
        const cardSearchChuter = document.getElementById('cardSearchchuter');

        // Add click event listener to the Itemcode button
        toggleButton.addEventListener('click', () => {
            // Ensure cardSearchChuter is hidden when cardSearchItemcode is shown
            if (cardSearchChuter.classList.contains('show')) {
                cardSearchChuter.classList.remove('show');
                cardSearchChuter.classList.add('hide');
                setTimeout(() => {
                    cardSearchChuter.style.display = 'none';
                    cardSearchChuter.classList.remove('hide');
                }, 500); // Match CSS transition duration
            }

            if (cardSearchItemcode.classList.contains('show')) {
                // If the card is visible, fade it out
                cardSearchItemcode.classList.remove('show');
                cardSearchItemcode.classList.add('hide');

                // Wait for the animation to finish before setting display to none
                setTimeout(() => {
                    cardSearchItemcode.style.display = 'none'; // Hide the card
                    cardSearchItemcode.classList.remove(
                        'hide'); // Reset hide class for next toggle
                }, 500); // Match CSS transition duration
            } else {
                // If the card is hidden, show it with fade-in
                cardSearchItemcode.style.display = 'block'; // Set display to block first
                setTimeout(() => {
                    cardSearchItemcode.classList.add('show'); // Fade in
                }, 10); // Small timeout to ensure display is applied before animation
            }
        });

        // Add click event listener to the Chuter button
        const buttonChuter = document.getElementById('buttonChuter');
        buttonChuter.addEventListener('click', () => {
            // Ensure cardSearchItemcode is hidden when cardSearchChuter is shown
            if (cardSearchItemcode.classList.contains('show')) {
                cardSearchItemcode.classList.remove('show');
                cardSearchItemcode.classList.add('hide');
                setTimeout(() => {
                    cardSearchItemcode.style.display = 'none';
                    cardSearchItemcode.classList.remove('hide');
                }, 500); // Match CSS transition duration
            }

            if (cardSearchChuter.classList.contains('show')) {
                // If the card is visible, fade it out
                cardSearchChuter.classList.remove('show');
                cardSearchChuter.classList.add('hide');

                // Wait for the animation to finish before setting display to none
                setTimeout(() => {
                    cardSearchChuter.style.display = 'none'; // Hide the card
                    cardSearchChuter.classList.remove(
                        'hide'); // Reset hide class for next toggle
                }, 500); // Match CSS transition duration
            } else {
                // If the card is hidden, show it with fade-in
                cardSearchChuter.style.display = 'block'; // Set display to block first
                setTimeout(() => {
                    cardSearchChuter.classList.add('show'); // Fade in
                }, 10); // Small timeout to ensure display is applied before animation
            }
        });


        $('#itemcode').select2({
            placeholder: "--CHOICE--",
            allowClear: true,
            width: '18%' // Set to 100% to match the parent width
        });

        // Set the height for the Select2 selection area
        $('.select2-selection').css({
            'height': '35px' // This sets the height of the selection area
        });

        // Optional: Align text vertically within the selection
        $('.select2-selection .select2-selection__rendered').css({
            'line-height': '35px' // This aligns the text vertically in the selection area
        });

        // default data itemcode
        fetchDataitemcode();
        // function data itemcode
        function fetchDataitemcode() {
            // Get the value of the selected itemcode
            var itemcode = $('#itemcode').val();
            // Prepare the data object to send to the server
            var data = {
                itemcode: itemcode,
                _token: '{{ csrf_token() }}' // Include CSRF token if needed
            };

            // AJAX request to fetch data
            $.ajax({
                url: "{{ route('search_by_itemcode') }}",
                type: 'GET',
                data: data,
                success: function(data) {
                    // console.log(data); // Debugging: Log the response data

                    // Clear the previous results
                    $("#dataItemcode").empty();
                    if (data.length > 0) {
                        $(".empty-message").addClass("d-none");
                        data.forEach(function(item) {
                            var html = `
                            <div class="col-lg-2 col-md-6 col-sm-12 mb-2" style="margin:10px;">
                                <div class="card bg-white" style="font-size: 15px; background: rgb(245, 255, 250);">
                                    <div class="card-header text-center border p-1" style="background-color: #5091DC;">
                                        <span class="card-subtitle text-white fw-bold">
                                            <strong>${item.item_code}</strong> <!-- Bold text -->
                                        </span>
                                    </div>
                                    <div class="card-body d-flex justify-content-between mt-2">
                                        <div style="width: 100%;">
                                            <span class="tuition-fees text-dark" style="font-size: 15px;">
                                                <div class="flex-container mb-1">
                                                    <span class="text-dark fw-bold" style="font-size: 17px;">
                                                        <strong>Chuter : ${item.chutter_address}</strong> <!-- Bold text -->
                                                    </span>
                                                </div>
                                                <div class="flex-container mb-1">
                                                    <span class="text-dark fw-bold" style="font-size: 15px;">
                                                        <strong>Part Name : ${item.part_name}</strong> <!-- Bold text -->
                                                    </span>
                                                </div>
                                                <div class="flex-container mb-1">
                                                    <span class="text-dark fw-bold" style="font-size: 15px;">
                                                        <strong>QTY: ${item.qty}</strong> <!-- Bold text -->
                                                    </span>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                            // Append the generated HTML
                            $("#dataItemcode").append(html);
                        });

                        // Fade in the entire container
                        $("#dataItemcode > div").hide().fadeIn(500);
                    } else {
                        // Message if data is empty
                        $(".empty-message").removeClass("d-none");
                    }
                    // Generate HTML for each item with a delay

                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error); // Debugging: Log AJAX errors
                }
            });
        }

        // Attach the change event listener to the select element
        $('#itemcode').on('change', function() {
            fetchDataitemcode(); // Call fetchData when the selection changes
        });



        // chuter address
        $('#chuter').select2({
            placeholder: "--CHOICE--",
            allowClear: true,
            width: '18%', // Set to 100% to match the parent width
            dropdownParent: $('#chuter')
                .parent() // Attach dropdown to the parent to control positioning
        });

        // Set the height for the Select2 selection area
        $('.select2-selection').css({
            'height': '35px' // This sets the height of the selection area
        });

        // Optional: Align text vertically within the selection
        $('.select2-selection .select2-selection__rendered').css({
            'line-height': '35px' // This aligns the text vertically in the selection area
        });

        // get default
        fetchDatachuter()
        // funtion get chuter address
        function fetchDatachuter() {
            // Get the value of the selected chuter address
            var chuter = $('#chuter').val();
            // Prepare the data object to send to the server
            var data = {
                chuter: chuter,
                _token: '{{ csrf_token() }}' // Include CSRF token for security
            };

            // AJAX request to fetch data based on selected chuter
            $.ajax({
                url: "{{ route('search_by_chuter') }}",
                type: 'GET',
                data: data,
                success: function(data) {
                    console.log(data); // Debugging: Log the response data

                    // Clear the previous results
                    $("#dataChuter").empty();

                    if (data.length > 0) {
                        $(".empty-message").addClass("d-none");
                        // Loop through the data array and append each item
                        data.forEach(function(item) {
                            var html = `
                                <div class="col-lg-2 col-md-6 col-sm-12 mb-2" style="margin:10px;">
                                    <div class="card bg-white" style="font-size: 15px; background: rgb(245, 255, 250);">
                                        <div class="card-header text-center border p-1" style="background-color: #A2A1A1;">
                                            <span class="card-subtitle text-white fw-bold">
                                                <strong>${item.chutter_address}</strong> <!-- Bold text for chutter address -->
                                            </span>
                                        </div>
                                        <div class="card-body d-flex justify-content-between mt-2">
                                            <div style="width: 100%;">
                                                <span class="tuition-fees text-dark" style="font-size: 15px;">
                                                    <div class="flex-container mb-1">
                                                        <span class="text-dark fw-bold" style="font-size: 17px;">
                                                            <strong>Itemcode : ${item.item_code}</strong> <!-- Bold text for itemcode -->
                                                        </span>
                                                    </div>
                                                    <div class="flex-container mb-1">
                                                        <span class="text-dark fw-bold" style="font-size: 15px;">
                                                            <strong>Part Name : ${item.part_name}</strong> <!-- Bold text for part name -->
                                                        </span>
                                                    </div>
                                                    <div class="flex-container mb-1">
                                                        <span class="text-dark fw-bold" style="font-size: 15px;">
                                                            <strong>QTY: ${item.qty}</strong> <!-- Bold text for quantity -->
                                                        </span>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            // Append the generated HTML
                            $("#dataChuter").append(html);
                        });

                        // Fade in the cards
                        $("#dataChuter > div").hide().fadeIn(500);
                    } else {
                        // Message if data is empty
                        $(".empty-message").removeClass("d-none");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error); // Log AJAX errors
                }
            });
        }


        // Attach the change event listener to the select element
        $('#chuter').on('change', function() {
            fetchDatachuter(); // Call fetchData when the selection changes
        });
    });
</script>
