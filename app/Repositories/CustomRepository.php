<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class CustomRepository
{

 
    public static function q_get($conn,$table){
        return DB::connection($conn)->table($table);
    }
    public static function q_get_where($conn,$where,$table){
        return DB::connection($conn)->table($table)->where($where);
    }

    public static function q_get_order($conn,$table,$order_key,$order_by){
        return DB::connection($conn)->table($table)->orderBy($order_key, $order_by);
    }

    public static function q_get_where_order($conn,$table,$where,$order_key,$order_by){
        return DB::connection($conn)->table($table)->where($where)->orderBy($order_key, $order_by);
    }


    public function insert_item($conn,$table,array $data){
        return DB::connection($conn)->table($table)->insert($data);
    }

    //UPDATE ITEMS 
    public static function update_item($conn,$table,$where,$data){
        return DB::connection($conn)->table($table)->where($where)->update($data);
    }

    public static function delete_item($conn,$table,$where){
        return DB::connection($conn)->table($table)->where($where)->delete();
    }


    public function isEmailUnique($email)
    {
        return DB::table('users')->where('email_address', $email)->doesntExist();
    }
    public function isUsernameUnique($email)
    {
        return DB::table('users')->where('username', $email)->doesntExist();
    }

    
}
