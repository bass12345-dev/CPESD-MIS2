<div class="card flex-fill p-3">
    <div class="card-header">
        <h5 class="card-title mb-0">User System Authorized</h5>
    </div>
    <form id="authorized_form">
        <div class="form-row mb-2">
            <input type="hidden" name="user_id" value="{{$user->user_id}}">
            <?php foreach ($systems as $row => $value) :
                # code...
             ?>
             <div class="list-group">
                <label class="list-group-item h4">
                    <input  class="form-check-input me-1" name="system_id" type="checkbox" value="{{$systems[$row]['system_id']}}" {{$systems[$row]['is_checked']}}> {{$systems[$row]['system_name']}}
                </label>
            </div>
            <?php endforeach; ?>
        </div>
        <button type="submit" class="btn btn-primary submit">Submit</button>
    </form>
</div>