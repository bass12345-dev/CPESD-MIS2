<!-- Data Table area Start-->
<div class="data-table-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="data-table-list">
                    <div class="basic-tb-hd card-header">
                        <h2>Contractor's List</h2>

                    </div>
                    <div class="table-responsive">
                        <table id="data-table-basic" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Contractor</th>
                                    <th>Ongoing Projects</th>
                                    <th>Completed Projects</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php  $i = 1; foreach($contractors_data as $row): ?>
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td><a href="{{url('admin/whip/contractor-information/'.$row->contractor_id)}}">{{$row->contractor_name}}</a></td>
                                    <td>{{$row->project_count_ongoing}}</td>
                                    <td>{{$row->project_count_completed}}</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Data Table area End-->