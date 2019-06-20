<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/app.css">
    <title>一覧表示画面</title>
</head>
<body>
    @extends('layouts.app')

    @section('title')
    一覧
    @endsection

    @section('content')
    <a href="{{ route('diary.create') }}" class="btn btn-primary btn-block">
        新規投稿
    </a>
    @foreach ($diaries as $diary)
    <div class="m-4 p-4 border border-primary">
        <p>{{ $diary->title }}</p>
        <p>{{ $diary->body }}</p>
        <p>{{ $diary->created_at }}</p>
        <a class="btn btn-success" href="{{ route('diary.edit', ['id' => $diary->id]) }}">編集</a>
        <form action="{{ route('diary.destroy', ['id' => $diary->id]) }}" method="POST" class="d-inline">
            @csrf
            @method('delete')
            <button class="btn btn-danger">削除</button>
        </form>
    </div>
    @endforeach
</body>
<a href="{{ route('diary.create') }}" class="btn btn-primary btn-block">
    新規投稿
</a>
</html>