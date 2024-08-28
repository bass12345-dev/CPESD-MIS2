<div class="offcanvas offcanvas-end" style="width: 50%" tabindex="-1" id="offcanvasExample"
    aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h3 class="offcanvas-title">Programs</h3>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="program_form">
            <div class="form-row mb-2">

                <div class="list-group">

                    <?php foreach ($programs as $row):
    $checked = $row['x'] == true ? 'checked' : '';
                   ?>
                    <label class="list-group-item h4">
                        <input class="form-check-input me-1" name="program_id" type="checkbox"
                            value="{{$row['program_id']}}" {{$checked}}>
                        {{$row['program']}}
                    </label>

                    <?php endforeach; ?>

                </div>

            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>
</div>