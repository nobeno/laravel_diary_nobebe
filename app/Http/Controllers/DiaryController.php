<?php

namespace App\Http\Controllers;

use App\Diary; // App/Diaryクラスを使用する宣言
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\CreateDiary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DiaryController extends Controller
{
    public function index()
    {
        //diariesテーブルのデータを全件取得
        //useしてるDiaryモデルのallメソッドを実施
        //all()はテーブルのデータを全て取得するメソッド
        // $diaries = Diary::orderBy('id', 'desc')->get();
        $diaries = Diary::with('likes')->orderBy('id', 'desc')->get();
        $users   = User::with('followings')->get(); 

        // return view('diaries.index',['diaries' => $diaries]);
        return view('diaries.index')->with('diaries',$diaries)->with('users',$users);

        // dd($diaries);  //var_dump()とdie()を合わせたメソッド。変数の確認 + 処理のストップ

    }

    public function create()
    {
        // views/diaries/create.blade.phpを表示する
        return view('diaries.create');
    }

    public function store(CreateDiary $request)
    {
       $diary = new Diary(); //Diaryモデルをインスタンス化

        $diary->title = $request->title; //画面で入力されたタイトルを代入
        $diary->body = $request->body; //画面で入力された本文を代入
        date_default_timezone_set('Asia/Tokyo');
        $time = date("Ymdhis"); 

        $images_path = $request->image->storeAs('public/images', $time.'_'.Auth::user()->id . '.jpg');
        $diary->images_path = basename($images_path);  

        $diary->user_id = Auth::user()->id; //追加 ログインしてるユーザーのidを保存
        $diary->save(); //DBに保存

        return redirect()->route('diary.index'); //一覧ページにリダイレクト
    }

    public function destroy(Diary $diary)
    {
        if (Auth::user()->id !== $diary->user_id) 
        {
            abort(403);
        }

        Storage::disk('local')->delete('public/images/'.$diary->images_path);

    //取得したデータを削除
        $diary->delete();

        return redirect()->route('diary.index');
    }

    public function edit(Diary $diary)
    {
        if (Auth::user()->id !== $diary->user_id) 
        {
            abort(403);
        } 

        return view('diaries.edit', [
            'diary' => $diary,
            ]);
    }

    public function update(Diary $diary, CreateDiary $request)
    {
        if (Auth::user()->id !== $diary->user_id) 
        {
            abort(403);
        } 

        $diary->title = $request->title; //画面で入力されたタイトルを代入
        $diary->body = $request->body; //画面で入力された本文を代入

        if($request->image){
        Storage::disk('local')->delete('public/images/'.$diary->images_path);
        date_default_timezone_set('Asia/Tokyo');
        $time = date("Ymdhis"); 
        $images_path = $request->image->storeAs('public/images', $time.'_'.Auth::user()->id . '.jpg');
        $diary->images_path = basename($images_path);
        }

        $diary->save(); //DBに保存

        return redirect()->route('diary.index'); //一覧ページにリダイレクト
    }

    public function like(int $id)
    {
        $diary = Diary::where('id', $id)->with('likes')->first();

        $diary->likes()->attach(Auth::user()->id);
    }

    public function dislike(int $id)
    {
        $diary = Diary::where('id', $id)->with('likes')->first();

        $diary->likes()->detach(Auth::user()->id);
    }

}
