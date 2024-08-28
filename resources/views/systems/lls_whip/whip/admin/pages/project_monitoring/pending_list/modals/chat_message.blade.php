<div class="modal animated bounce" id="chat_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="chat">
                
                <div class="chat-history">
                <h2>Remarks</h2>
                    <a href="javascript:;" type="button" class="refresh" style="margin-bottom: 20px;">Refresh</a>
                   
                    <form id="add_remarks_form">
                        <input type="hidden" name="project_monitoring_id">
                        <ul class="chat-ul">
                        </ul>
                        <div class="send_message">
                            <textarea rows="9" class="form-control" name="remarks"></textarea>
                            <button type="submit" class="btn btn-primary btn-block"
                                style="margin-top: 10px;">Send</button>
                        </div>
                    </form>
            </div> <!-- end chat-history -->
        </div> <!-- end chat -->


    </div>
</div>
</div>