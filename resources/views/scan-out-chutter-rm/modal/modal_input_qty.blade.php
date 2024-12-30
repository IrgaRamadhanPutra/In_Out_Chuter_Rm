<div class="modal fade" id="ItemModalInsertQty" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <form id="create-data-qty">
                @csrf
                @method('POST')
                <div class="modal-header">
                    <h5 class="modal-title text-danger">Masukan Qty</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="itemcodeCreate" class="form-label">Itemcode</label>
                        <input type="text" class="form-control" id="itemcodeCreate" name="itemcodeCreate" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="qtyCreate" class="form-label">Qty</label>
                        <input type="number" class="form-control" id="qtyCreate" name="qtyCreate">
                    </div>
                    <div class="mb-3">
                        <label for="slocCreate" class="form-label">To Sloc</label>
                        <select class="form-control" id="slocCreate" name="slocCreate">
                            <option value="">--Select--</option>
                            <option value="1310">1310</option>
                            <option value="1320">1320</option>
                            <option value="1110">1110</option>
                        </select>
                    </div>

                    <input type="text" class="form-control" id="chuterCreate" name="chuterCreate" hidden>
                    <input type="text" class="form-control" id="partCreate" name="partCreate" hidden>
                    <input type="text" class="form-control" id="seqCreate" name="seqCreate" hidden>
                    <input type="text" class="form-control" id="kanbanCreate" name="kanbanCreate" hidden>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    id="closeModalBtn">Close</button>
                <button type="button" class="btn btn-primary" id="saveModalBtn">Save</button>
            </div>
        </div>
    </div>
</div>
