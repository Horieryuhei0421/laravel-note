<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    public function myMemo($user_id){
        $tag = \Request::query('tag');
        // �^�O���Ȃ���΁A���̐l�������Ă��郁����S�Ď擾
        if(empty($tag)){
            return $this::select('memos.*')->where('user_id', $user_id)->where('status', 1)->get();
        }else{
        // �����^�O�̎w�肪����΃^�O�ōi�� ->wher(tag���N�G���p�����[�^�[�Ŏ擾�������̂Ɉ�v)
          $memos = $this::select('memos.*')
              ->leftJoin('tags', 'tags.id', '=','memos.tag_id')
              ->where('tags.name', $tag)
              ->where('tags.user_id', $user_id)
              ->where('memos.user_id', $user_id)
              ->where('status', 1)
              ->get();
          return $memos;
        }
    }
}
