@extends('common.base')

@section('title')
詳細
@endsection
<link rel="stylesheet" href="{{ asset('css/newcomment.css') }}">
@section('extra_css')
<style>

</style>
@endsection

@section('brand_name')
@endsection

@section('content')
<main id="app">
  <div class="container">
    @auth
      <div>
        <h3>コメントを残す</h3>
        <form action="{{ url()->current() }}" method="post" class="newcomment-form">
          @csrf
          <div class="evaluations">
            <p>評価</p>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="evaluation" id="inlineRadio1" value="+">
              <label class="form-check-label" for="inlineRadio1">+</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="evaluation" id="inlineRadio2" value="?">
              <label class="form-check-label" for="inlineRadio2">?</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="evaluation" id="inlineRadio3" value="-">
              <label class="form-check-label" for="inlineRadio3">-</label>
            </div>
          </div>
          <div class="title">
            <div class="form-group">
              <label for="title">タイトル</label>
              <input type="text" class="form-control" name="title" id="title" placeholder="タイトル" required>
            </div>
          </div>
          <div class="content">
            <label for="content">内容</label>
            <textarea class="form-control" id="content" name="content" rows="4"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">登録</button>
        </form>
      </div>
      @else
      <div class="then-login">
        <h4>コメントを残すにはログインが必要です</h4>
        @if (Route::has('login'))
          <a href="{{ route('login') }}" class="btn btn-secondary">ログイン</a>
        @endif
        @if (Route::has('register'))
          <a href="{{ route('register') }}" class="btn btn-primary">アカウント作成</a>
        @endif
      </div>
    @endif
  </div>
</main>
@endsection

@section('extra_javascript')
@endsection