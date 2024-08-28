<?php

namespace App\Services;


class CustomService
{
    

    public function put_zeros($last_digits){

        $tracking_number = '';
        
        switch ($last_digits) {
            case $last_digits < 10:
                $tracking_number = '00'.$last_digits;
                break;
            case $last_digits < 100:
                $tracking_number = '0'.$last_digits;
                break;
            default:
                $tracking_number = $last_digits;
                break;
        }

        return $tracking_number;

    }

    public function check_status($doc_status)
    {
        $status = '';

        switch ($doc_status) {
            case 'completed':
                $status = '<span class="badge p-2 bg-success">Completed</span>';
                break;
            case 'pending':
                $status = '<span class="badge p-2 bg-danger">Pending</span>';
                break;

            case 'cancelled':
                $status = '<span class="badge p-2 bg-warning">Canceled</span>';
                break;

            case 'outgoing':
                $status = '<span class="badge p-2 bg-secondary">Outgoing</span>';
                break;
            default:
                # code...
                break;
        }

        return $status;
    }


    public function ref_number($item){
        return date('Y', strtotime($item->rfa_date_filed)).'-'.date('m', strtotime($item->rfa_date_filed)).'-'.$item->number;

    }

    public function pmas_number($item){
        return date('Y', strtotime($item->date_and_time_filed)).' - '.date('m', strtotime($item->date_and_time_filed)).' - '.$item->number;
    }

    public function put_zeros_p_r($last_digits){
        $reference_number = '';

        switch ($last_digits) {
            case $last_digits < 10:
                $reference_number = '00' . $last_digits;
                break;
            case $last_digits < 100:
                $reference_number = '0' . $last_digits;
                break;
            default:
                $reference_number = $last_digits;
                break;
        }
        return $reference_number;
    }


}
