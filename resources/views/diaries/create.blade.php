
@extends('layouts.app')
@section('title')
新規投稿
@endsection
@section('content')
<section class="container m-5">
    <div class="row justify-content-center">
        <div class="col-8">
            @if($errors->any())
            <ul>
             @foreach($errors->all() as $message)
             <li class="alert alert-danger">{{ $message }}</li>
             @endforeach
         </ul>
         @endif
         <form action="{{ route('diary.create') }}" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="image">画像</label>
                <input type="file" name="image" class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" id="image" placeholder="ファイル">
            </div>
            <div class="m-3">
                <img src="#" alt="" class="img-print" id="print_img" width="auto" height="200px">
            </div>
            @csrf
            <div class="form-group">
                <label for="title">タイトル</label>
                <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}"/>
            </div>
            <div class="form-group">
                <label for="body">本文</label>
                <textarea class="form-control" name="body" id="body">{{ old('body') }}</textarea>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-primary">投稿</button>
            </div>
        </form>
    </div>
</div>
</section>
@endsection