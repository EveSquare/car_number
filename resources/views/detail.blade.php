@extends('common.base')

@section('title')
詳細
@endsection
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@section('extra_css')
<style>

  .progress-bar-left {
    margin-right: 3px;
    border-top-left-radius: 0.5em;
    border-bottom-left-radius: 0.5em;
  }

  .progress-bar-right {
    margin-left: 3px;
    border-top-right-radius: 0.5em;
    border-bottom-right-radius: 0.5em;
  }

  .comment-empty {
    text-align: center;
    margin-top: 100px;
  }

</style>
@endsection

@section('brand_name')
@endsection

@section('content')
<main id="app">
  <div class="container">
    <div class="evaluation">
      <div class="balloon">
        <p class="balloon-code">+</p>
      </div>
      <div class="progress">
        <div class="progress-bar progress-bar-left"data-toggle="tooltip" title="Tooltip message" v-tooltip.top="positive" role="progressbar" style="width: 70%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
        <div class="progress-bar bg-success" v-tooltip.top="normal" role="progressbar" style="width: 10%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
        <div class="progress-bar bg-info progress-bar-right" v-tooltip.top="negative" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
    </div>
  </div>
  <div class="newcomment">
    <a href="{{ url('newcomment/'.$id) }}">コメントを残す</a>
  </div>
  @forelse ($comments as $comment)
    <comment
      evaluation="{{ $comment->evaluation }}"
      title="{{ $comment->title }}"
      content="{{ $comment->content }}"
    ></comment>
    @empty
    <h4 class="comment-empty">コメントはありません</h4>
  @endforelse
</main>
@endsection

@section('extra_javascript')
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script src="https://unpkg.com/v-tooltip"></script>
<script src="{{ asset('js/detail.js') }}"></script>
@endsection