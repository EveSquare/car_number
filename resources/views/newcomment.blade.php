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
    <h3>コメントを残す</h3>
    <form action="{{ url('newcomment/') }}" method="post" class="newcomment-form">
      <div class="evaluations">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="evaluation" id="inlineRadio1" value="option1">
          <label class="form-check-label" for="inlineRadio1">+</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="evaluation" id="inlineRadio2" value="option2">
          <label class="form-check-label" for="inlineRadio2">?</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="evaluation" id="inlineRadio3" value="option3">
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
        <textarea class="form-control" id="content" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">登録</button>
    </form>
  </div>
</main>
@endsection

@section('extra_javascript')
@endsection