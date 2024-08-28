<div class="card">
    <div class="card-header bg-primary text-white">
        Added Today - {{$today}}
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Status</th>

            </tr>
        </thead>

        <tbody>
            <?php $i = 1;
            foreach ($added_today as $row) {

                $status  = '';
                $bg      = '';

                switch ($row->status) {
                    case 'not-approved':
                        $status = 'To Approved';
                        $bg = 'bg-warning';
                        break;
                    case 'inactive':
                        $status = 'Removed';
                        $bg = 'bg-success';
                        break;
                    case 'active':
                        $status = 'Approved';
                        $bg = 'bg-danger';
                }


            ?>
                <tr>
                    <th>{{$i++}}</th>
                    <td> <a href="{{url('')}}/watchlisted/admin/view_profile?id={{$row->person_id}}"> {{$row->first_name}} {{$row->middle_name}} {{$row->last_name}} {{$row->extension}} </a> </td>
                    <td><span class="badge {{$bg}}">{{$status}}</span></td>

                </tr>
            <?php } ?>
        </tbody>

    </table>
</div>