<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use itbdw\QiniuStorage\QiniuStorage;


class AdminController extends Controller
{
    //
        public function get_id($token)
        {
            if (empty($token)) {
                $return = array('type' => 3, 'msg' => '请登陆');
//                return exit(response()->json($return));
            return view('login');
            }
            $row = DB::select('select id from user where token = :token and updated_at > :now', ['token' => $token, 'now' => time() + 28800]);
            if (!$row) {
                $return = array('type' => 3, 'msg' => '您还未登陆，请登陆');
//                return exit(response()->json($return));
            return view('login');
            }
            return intval($row[0]->id);
        }

        public function add(Request $request)
        {
            $token = session('token');
            $user_id = $this->get_id($token);
            $is_admin = DB::select('select is_admin from user where id=:id',['id'=>$user_id])[0]->is_admin;
            if($is_admin != 1){
//                return exit(response()->json(['type'=>0,'msg'=>'您不是管理员']));
            return '您不是管理员';
            }
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

            $arr = explode('-',$filename);
            $music_name = $arr[0];
            $music_author = explode('.',$arr[1])[0];
            $is_repeat = DB::select('select count(*) as count from music where music_name = :music_name and music_author = :music_author',['music_name'=>$music_name,'music_author'=>$music_author])[0]->count;
            if($is_repeat){
//                return exit(response()->json(array('type'=>0,'msg'=>'此歌曲已经有了')));
                return '此歌曲已经有了';
            }else {
                $path = $mp3->move('mp3',md5(time().$filename).'.mp3');
                $music_addr = $path->getPathname();
                $query = DB::insert('insert into music (music_name, music_author, music_addr, created_at) values (:music_name,:music_author,:music_addr,:created_at)', ['music_name' => $music_name, 'music_author' => $music_author, 'music_addr' => $music_addr, 'created_at' => date('Y-m-d H:i:s', time() + 28800)]);
                if ($query) {
//                    return response()->json(['type' => 1, 'msg' => '上传成功']);
                return '上传成功';
                } else {
                    return response()->json(['type' => 0, 'msg' => '上传失败']);
                }
            }
        }

        public function upload()
        {
            $disk = QiniuStorage::disk('qiniu');
            $upload_token = $disk->uploadToken();

            return view('upload',['upload_token'=>$upload_token]);
        }
}
