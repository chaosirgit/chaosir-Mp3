<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ListController extends Controller
{
    //

    public function get_id($token){
        if(empty($token)){
            $return = array('type'=>3,'msg'=>'请登陆');
//            return exit(response()->json($return));
            return view('login');
        }
        $row = DB::select('select id from user where token = :token and updated_at > :now',['token'=>$token,'now'=>time()+28800]);
        if(!$row){
            $return = array('type'=>3,'msg'=>'登陆超时，请重新登陆');
//            return exit(response()->json($return));
        return view('login');
        }
        return intval($row[0]->id);
    }

    public function add(Request $request)
    {
        $token = session('token');
        $list_name = $request->input('list_name');
        $id = $this->get_id($token);
        if (empty($list_name)) {
            $return = array('type' => 0, 'msg' => '请填写列表名');
            return response()->json($return);
        }
        $query = DB::insert('insert into list (list_name, user_id,created_at) values (:list_name,:user_id,:created_at)', ['list_name' => $list_name, 'user_id' => $id, 'created_at' => date('Y-m-d H:i:s',time() + 28800)]);
        if($query){
            $return = array('type'=>1,'msg'=>'创建成功');
            return response()->json($return);
        }else{
            $return = array('type'=>0,'msg'=>'操作失败，请重试');
            return response()->json($return);
        }
    }

    public function del(Request $request)
    {
        $token = session('token');
        $list_id = $request->get('list_id');
        $id = $this->get_id($token);
        $query = DB::delete('delete from list where list_id = :list_id',['list_id'=>$list_id]);
        if($query){
            $return = array('type'=>1,'msg'=>'删除成功');
            return response()->json($return);
        }else{
            $return = array('type'=>0,'msg'=>'删除失败，请重试');
            return response()->json($return);
        }
    }

    public function get_list(Request $request)
    {
        $token = session('token');
        $id = $this->get_id($token);
        $results = DB::select('select list_id,list_name from list where user_id = :user_id',['user_id'=>$id]);
        if(!$results){
            $return = array('type'=>0,'msg'=>'很抱歉，您还没有创建播放列表');
            return response()->json($return);
        }else{
            return response()->json($results);
        }
    }

    public function music(Request $request)
    {
        $token = session('token');
        $id = $this->get_id($token);
        $list_id = $request->input('list_id');
        $music_id = $request->input('music_id');

        $str = DB::select('select music_id from list where list_id = :list_id',['list_id'=>$list_id])[0]->music_id;
        if(empty($str))
        {
            $str = strval($music_id);
        }else{
            $arr = explode(',',$str);
            if(in_array($music_id,$arr)){
                return exit(response()->json(array('type'=>0,'msg'=>'该歌曲已经在列表里里')));
            }else{
                $arr[] = $music_id;
                $str = implode(',',$arr);
                }
        }
        $query = DB::update('update list set music_id = :str where list_id = :list_id',['str'=>$str,'list_id'=>$list_id]);
        if($query){
            return response()->json(['type'=>1,'msg'=>'添加歌曲成功']);
        }else{
            return response()->json(['type'=>0,'msg'=>'添加失败，请重试']);
        }
    }

    public function get_list_music(Request $request)
    {

        $token = session('token');
        $id = $this->get_id($token);
        $list_id = $request->id;
        $str = DB::select('select music_id from list where list_id = :list_id',['list_id'=>$list_id])[0]->music_id;
        $arr = explode(',',$str);
        $arr = array_reverse($arr);
        foreach ($arr as $value)
        {
            $row = DB::select('select * from music where music_id = :music_id',['music_id'=>$value])[0];
            $rows[] = $row;
        }
        return response()->json($rows);

    }
}
