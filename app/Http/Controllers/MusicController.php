<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MusicController extends Controller
{
    //
    public function get_all_music()
    {
        $return = DB::select('select music_id,music_name,music_author,music_addr,music_img,music_lyric from music order by created_at desc');
        return response()->json($return);
    }
}
