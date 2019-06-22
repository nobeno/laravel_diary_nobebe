<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


//dairiesテーブルのデータを扱うクラス
//クラス名を先頭が小文字で複数形にした形のテーブルと自動的に関連づけされる
//Diary -> diaries
class Diary extends Model
{
    public function likes()
    {
        return $this->belongsToMany('App\User', 'likes')->withTimestamps();
    }
}
