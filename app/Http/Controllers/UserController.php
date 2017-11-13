<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    //
    public function register(Request $request)
    {
        $mobile = $request->input('mobile');
        $password = $request->input('password');
        $nickname = $request->input('nickname');
        $gender = $request->input('gender');

        if(!preg_match('/^\d{11}$/',$mobile)){
            $return = array('type'=>0,'msg'=>'请填写正确的手机号');
            return response()->json($return);
        }
        if(!preg_match('/^[0-9a-zA-Z\S]{6,16}$/',$password)){
            $return = array('type'=>0,'msg'=>'密码必须是 6-16 位数字或字母');
            return response()->json($return);
        }
        if(empty($nickname)){
            $return = array('type'=>0,'msg'=>'请填写昵称');
            return response()->json($return);
        }
        if(empty($gender)){
            $return = array('type'=>0,'msg'=>'请选择性别');
            return response()->json($return);
        }
        $row = DB::select('select count(*) as num from user where mobile = :mobile',['mobile'=>$mobile])[0]->num;
        if($row){
            $return = array('type'=>0,'msg'=>'该用户已存在');
            return response()->json($return);
        }else {
            $query = DB::insert('insert into user (mobile, password, nickname, gender,created_at) values (:mobile,:password,:nickname,:gender,:created_at)', ['mobile' => $mobile, 'password' => Crypt::encrypt($password), 'nickname' => $nickname, 'gender' => $gender, 'created_at' => date('Y-m-d H:i:s', time() + 28800)]);
            if ($query) {
                $return = array('type' => 1, 'msg' => '注册成功');
                return response()->json($return);
            }
        }
    }

    public function login(Request $request)
    {
        $mobile = $request->input('mobile');
        $password = $request->input('password');

        if(empty($mobile)){
            $return = array('type'=>0,'msg'=>'请填写用户名');
            return response()->json($return);
        }
        if(empty($password)){
            $return = array('type'=>0,'msg'=>'请填写密码');
            return response()->json($return);
        }

        $row = DB::select('select id,password from user where mobile = :mobile',['mobile'=>$mobile]);
        if(!$row){
            $return = array('type'=>0,'msg'=>'没有此用户，请注册');
            return response()->json($return);
        }
        $is_password = Crypt::decrypt($row[0]->password);
        if($password != $is_password){
            $return = array('type'=>0,'msg'=>'密码错误');
            return response()->json($return);
        }else{
            $id = $row[0]->id;
            $token = md5(md5(time()).$mobile);
            $updated_at = date('Y-m-d H:i:s',time()+28800+1209600);
            $query = DB::update('update user set token = :token , updated_at = :updated_at where id = :id',['token'=>$token,'updated_at'=>$updated_at,'id'=>$id]);
            if($query){
                $return = array('type'=>1,'msg'=>'登陆成功','token'=>$token);
                return response()->json($return);
            }else{
                $return = array('type'=>0,'msg'=>'登陆失败，请重试');
                return response()->json($return);
            }
        }

    }
}



