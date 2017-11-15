<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    //
    public function get_id($token){
        if(empty($token)){
            $return = array('type'=>3,'msg'=>'请登陆');
//            return exit(response()->json($return));
        return exit(view('login'));
        }
        $row = DB::select('select id from user where token = :token and updated_at > :now',['token'=>$token,'now'=>time()+28800]);
        if(!$row){
            $return = array('type'=>3,'msg'=>'登陆超时，请重新登陆');
//            return exit(response()->json($return));
        return exit(view('login'));
        }
        return intval($row[0]->id);
    }


    public function index(Request $request)
    {
        $token = session('token');
        $user_id = $this->get_id($token);
        $results = DB::select('select nickname,gender from user where id = :id',['id'=>$user_id]);
            return view('welcome',['results'=>$results]);

    }
}
