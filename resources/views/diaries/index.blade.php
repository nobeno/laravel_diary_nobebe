
@extends('layouts.app')

@section('title')
一覧
@endsection

@section('content')
<a href="{{ route('diary.create') }}" class="btn btn-primary btn-block">
    新規投稿
</a>

<!-- ユーザー表示 -->
<div class="container m-5">
    <div class="row">
        @foreach($users as $user)
            @if (Auth::check() && Auth::user()->id !== $user->id)
                <div class="border border-primary m-4 p-4" style="max-width: 18rem;">
                    <img height="80px" width="auto" src="{{ $user->picture_path }}">
                    <p class="text-primary">{{$user->name}}</p>
                        @if (Auth::check() && $user->followings->contains(function ($user) {return $user->id === Auth::user()->id;}))
                            <button type="button" class="btn btn-primary js-unfollow textChange-{{$user->id}}">フォロー中</button>
                        @else
                            <button type="button" class="btn btn-outline-primary js-follow textChange-{{$user->id}}">フォロー</button>
                        @endif
                         <input class="user-id" type="hidden" value="{{ $user->id }}">
                </div>
            @endif
        @endforeach
    </div>
</div>

<!-- 投稿表示 -->
<div class="container">
    <div class="row">
@foreach ($diaries as $diary)
        <div class="m-4 p-4 border border-primary">
            <img src="/storage/images/{{ $diary->images_path}}" width="auto" height="200px">
            <p>投稿者：{{ $diary->user->name }}</p>
            <p>推しメン：{{ $diary->title }}</p>
            <p>想い：{{ $diary->body }}</p>
            <p>{{ date('Y年m月d日　H時i分',  strtotime($diary->created_at)) }}</p>
            @if (Auth::check() && Auth::user()->id === $diary->user_id)
            <a class="btn btn-success" href="{{ route('diary.edit', ['id' => $diary->id]) }}">編集</a>
            <form action="{{ route('diary.destroy', ['id' => $diary->id]) }}" method="POST" class="d-inline">
                @csrf
                @method('delete')
                <button class="btn btn-danger">削除</button>
            </form>
            @endif
            <div class=" mt-3 ml-3">
                @if (Auth::check() && $diary->likes->contains(function ($user) {
                return $user->id === Auth::user()->id;
                }))
                <i class="fas fa-heart fa-lg text-danger js-dislike"></i>
                @else
                <i class="far fa-heart fa-lg text-danger js-like"></i>
                @endif
                <input class="diary-id" type="hidden" value="{{ $diary->id }}">
                <span class="js-like-num">{{ $diary->likes->count() }}</span>
            </div> 
        </div>
@endforeach
    </div>
</div>
@endsection