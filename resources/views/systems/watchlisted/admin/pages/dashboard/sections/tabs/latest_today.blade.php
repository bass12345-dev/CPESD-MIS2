<div class="card">
    <div class="card-header bg-primary text-white">
        Latest Added
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                
                
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;
            foreach ($latest_approved as $row) {
            ?>
                <tr>
                    <th>{{$i++}}</th>
                    <td> <a href="{{url('')}}/watchlisted/admin/view_profile?id={{$row->person_id}}"> {{$row->first_name}} {{$row->middle_name}} {{$row->last_name}} {{$row->extension}} </a> </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>