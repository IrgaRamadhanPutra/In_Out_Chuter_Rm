<div class="modal fade" id="ItemModalchuter" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Itemcode</h5>
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span> --}}
                <p class="text-danger">Klik 2x untuk memilih</p>
                {{-- </button> --}}
            </div>
            <div class="modal-body">
                <table id="lookUpdataItemcodeIn" class="table table-striped table-bordered table-hover" width="100%">
                    <thead style="text-transform: uppercase; font-size: 14px;">
                        <tr>
                            <th>Itemcode</th>
                            <th style="width: 200px;">Part name</th> <!-- Set a specific width inline -->
                            <th>Kanban No</th>
                            <th>Seq</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- table rows will be dynamically generated here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
