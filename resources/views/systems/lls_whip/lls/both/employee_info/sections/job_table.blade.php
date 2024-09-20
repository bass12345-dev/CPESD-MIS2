<!-- Data Table area Start-->
<div class="data-table-area">
    <div class="data-table-list">
        <h1>Job History</h1>
        <div class="table-responsive">
            <table id="data-table-basic" class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Establishment</th>
                        <th>Position</th>
                        <th>Nature of Employement</th>
                        <th>From</th>
                        <th>To</th>
                    </tr>
                </thead>
                <tbody>
                        <?php $i=1; foreach($job_info as $row): ?>
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$row->establishment_name}}</td>
                            <td>{{$row->position}}</td>
                            <td>{{ ucfirst($row->nature_of_employment)}}</td>
                             <td><?php echo date("m-Y", strtotime($row->start_date))  ?></td>
                            <td>{{$row->end_date}}</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>

            </table>
        </div>
    </div>
</div>

<!-- Data Table area End-->