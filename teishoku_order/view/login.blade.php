@extends('layout/template')

@section('title', 'ログインページ')
@section('style', 'css/login.css')

@include('layout/header')

@section('content')
<p>ログインIDとパスワードを入力してください。</p>
<form method="POST" action="index.php?action=top">
    <div>
        <input type="text" name="user_id">
    </div>
    <div>
        <input type="password" name="password">
    </div>
    <div>
        <input type="submit" value="submit">
    </div>
</form>
@endsection