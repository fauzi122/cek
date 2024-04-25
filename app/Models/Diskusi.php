<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Traits\LogTrait;

class Diskusi extends Model
{
    use LogTrait, HasFactory;
    protected $table='forum_chat';
    protected $guarded=[];
    public function chat($where)
    {
        return $chat = DB::table('forum_chat as a')
        ->select('a.*','b.name','c.nm_mhs',DB::raw('COUNT(d.`id_chat`) AS jml'))
        ->leftJoin('users as b', 'a.user', '=', 'b.username')
        ->leftJoin('mhs as c', 'a.user', '=', 'c.nim')
        ->leftJoin('komentar_chat as d', 'a.id_chat', '=', 'd.id_chat')
        ->where($where)
        ->orderBy('id_chat', 'desc')
        ->groupBy('id_chat');
        // return $chat = DB::table('forum_chat as a')
        // ->select('a.*','b.name','c.nm_mhs',DB::raw('COUNT(d.`id_chat`) AS jml'))
        // ->leftJoin('users as b', 'a.user', '=', 'b.username')
        // ->leftJoin('mhs as c', 'a.user', '=', 'c.nim')
        // ->rightJoin('komentar_chat as d', 'a.id_chat', '=', 'd.id_chat')
        // ->where($where)
        // ->orderBy('id_chat', 'desc')
        // ->groupBy('id_chat');
    }
    // public function jml($where)
    // {
    //      return $chat = DB::table('forum_chat as a')
    //     ->select(DB::raw('COUNT(b.`id_chat`) AS jml'))
    //     ->rightJoin('komentar_chat as b', 'a.id_chat', '=', 'b.id_chat')
    //     ->where($where);
    // }
    public function komentar($where)
    {
        return $chat = DB::table('komentar_chat as a')
        ->select('a.*','b.name','c.nm_mhs')
        ->leftJoin('users as b', 'a.user_komentar', '=', 'b.username')
        ->leftJoin('mhs as c', 'a.user_komentar', '=', 'c.nim')
        ->where('id_chat','=',$where)
        ->orderBy('id_komentar', 'desc');
    }

    
}
