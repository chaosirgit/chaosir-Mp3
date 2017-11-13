<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    //
        public function get_id($token)
        {
            if (empty($token)) {
                $return = array('type' => 0, 'msg' => '请登陆');
                return exit(response()->json($return));
            }
            $row = DB::select('select id from user where token = :token and updated_at > :now', ['token' => $token, 'now' => time() + 28800]);
            if (!$row) {
                $return = array('type' => 0, 'msg' => '您还未登陆，请登陆');
                return exit(response()->json($return));
            }
            return intval($row[0]->id);
        }

        public function add(Request $request)
        {
            $token = $request->header('token');
            $user_id = $this->get_id($token);
            $mp3 = $request->file('mp3');
            if(!$mp3->isValid()){
                $return = array('type'=>0,'msg'=>'上传失败，请重试');
                return exit(response()->json($return));
            }
            $filename = $mp3->getClientOriginalName();
            $extension = $mp3->getClientOriginalExtension();
            if($extension != 'mp3'){
                $return = array('type'=>0,'msg'=>'上传失败，请上传mp3文件');
                return exit(response()->json($return));
            }

            $path = $mp3->move('mp3',md5(time().$filename).'.mp3');
            $arr = explode('-',$filename);
            $music_name = $arr[0];
            $music_author = explode('.',$arr[1])[0];
            $music_addr = $path->getPathname();
            $query = DB::insert('insert into music (music_name, music_author, music_addr, created_at) values (:music_name,:music_author,:music_addr,:created_at)',['music_name'=>$music_name,'music_author'=>$music_author,'music_addr'=>$music_addr,'created_at'=>date('Y-m-d H:i:s',time()+28800)]);
            if($query){
                return response()->json(['type'=>1,'msg'=>'上传成功']);
            }else{
                return response()->json(['type'=>1,'msg'=>'上传失败']);
            }

        }
}
