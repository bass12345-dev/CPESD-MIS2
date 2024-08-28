<?php 
	use App\Repositories\CustomRepository;
	
	$row = CustomRepository::q_get_where(config('custom_config.database.users'),array('is_oic' => 'yes'),'users')->first();
	echo '<span class="text-danger">Office in Charge : '.$row->first_name.' '.$row->middle_name.' '.
	$row->last_name.' '.$row->extension.'</span>';
?>