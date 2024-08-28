<div class="timeline-centered">



    <?php

    use App\Repositories\CustomRepository;
    $Query = new CustomRepository();
   

    if(count($project_monitoring) > 0){

    

        

    
    foreach ($project_monitoring as $row) :
        $display = date('Y-m-d', strtotime($row->date_of_monitoring)) ==  date("Y-m-d") ? 'Today' : '';
        $text_class = $row->monitoring_status == 'pending' ? 'text-danger' : 'text-sucess';
        $bg = $row->monitoring_status == 'pending' ? 'bg-danger' : 'bg-success';

        $query_total  = $Query->q_get_where(config('custom_config.database.lls_whip'),array('project_monitoring_id' => $row->project_monitoring_id),'project_employee')->count();
        $query_skilled  = $Query->q_get_where(config('custom_config.database.lls_whip'),array('project_monitoring_id' => $row->project_monitoring_id,'nature_of_employment' => 'skilled'),'project_employee')->count();
        $query_unskilled  = $Query->q_get_where(config('custom_config.database.lls_whip'),array('project_monitoring_id' => $row->project_monitoring_id,'nature_of_employment' => 'unskilled'),'project_employee')->count();

        $calc_skilled =  $query_skilled == 0 ? 0 :   (int) $query_skilled / (int) $query_total * 100;
        $calc_unskilled =  $query_unskilled == 0 ? 0 :   (int) $query_unskilled / (int) $query_total * 100;

    ?>
   
        <article class="timeline-entry">
        <a href="{{url('/user/whip/project-monitoring-info/'.$row->project_monitoring_id)}}">
            <div class="timeline-entry-inner">
                <time class="timeline-time" datetime="2014-01-10T03:45"><span>{{date('M d Y', strtotime($row->date_of_monitoring))}}</span> <span>{{$display}}</span></time>
                <div class="timeline-icon {{$bg}}">
                    <i class="entypo-feather"></i>
                </div>

                <div class="timeline-label">
                    <h2>Basil John <span class="{{$text_class}}">{{$row->monitoring_status}}</span></h2>
                    <p style="font-size: 18px;">{{$row->specific_activity}}</p>
                    <div class="card flex-fill p-3">
                        <table class="table table-hover table-striped table-information " style="width: 100%; ">
                            <tr style="border : 1px solid #000">
                                <td style="border : 1px solid #000">Hired Skilled Workers</td>
                                <td style="border : 1px solid #000" class="text-start text-bold"><span class="title total_skilled">{{round($calc_skilled,2)}} %</span></td>
                            </tr>
                            <tr>
                                <td style="border : 1px solid #000;">UnSkilled Workers</td>
                                <td style="border : 1px solid #000" class="text-start text-bold"><span class="title total_unskilled ">{{round($calc_unskilled,2)}} %</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            </a>
        </article>
      

    <?php endforeach; ?>
    <?php }else { ?>

        <h1>No Monitoring</h1>
    <?php } ?>




</div>