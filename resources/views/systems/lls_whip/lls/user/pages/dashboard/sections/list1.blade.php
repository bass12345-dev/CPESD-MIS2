<div class="notika-status-area ">
    <div class="container ">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <ul class="list-group">
                        <a href="#" class="list-group-item active">
                            Employed
                        </a>
                        <?php foreach ($employee_positions as $row): ?>
                            <li class="list-group-item">
                                <span class="badge " style="background-color: #337ab7; font-size: 13px; ">{{$row->c}}</span>
                                {{$row->position}}
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="statistic-right-area notika-shadow sm-res-mg-t-0">
                    <div class="row">
                        <h4 class="text-center">Employed Inside Oroquieta</h4>
                    </div>
                    <canvas id="inside-gender-chart"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <div class="statistic-right-area notika-shadow  sm-res-mg-t-0">
                    <div class="row">
                        <h4 class="text-center">Employed Outside Oroquieta</h4>
                    </div>
                    <canvas id="outside-gender-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>