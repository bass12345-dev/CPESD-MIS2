<!-- Modal -->
<div class="modal fade" id="update_password_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Update Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            <div class="card">
							<div class="card-body">
								<div class="m-sm-3">
									<form id="update_password_form">
                                        <div class="row ">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">New Password</label>
											    <input class="form-control form-control-lg" type="password"  name="new_password" autocomplete  required />
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Confirm New Password</label>
											    <input class="form-control form-control-lg" type="password"  name="confirm_new_password" autocomplete  required />
                                            </div>
                                        </div>
										<div class="d-grid gap-2 m">
											<button type="submit" class="btn btn-lg btn-primary">Submit</button>
										</div>
									</form>
								</div>
							</div>
						</div>
            </div>
        </div>

    </div>
</div>
