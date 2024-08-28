<!-- Modal -->
<div class="modal fade" id="cancel_document_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Cancel Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="cancel_form">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card p-3 border">
                                <h1>Tracking Number</h1>
                                <hr>
                                <ul class="display_tracking_number ms-4">
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-row mb-2">
                                <input type="hidden" name="document_ids">
                                <input type="hidden" name="user_type">
                                <label for="inputEmail4">Reason/s</label>
                                <textarea class="form-control" name="reason" style="height: 10rem;" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>