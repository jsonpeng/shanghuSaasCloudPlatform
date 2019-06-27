@extends('front.default.layout.base')

@section('css')
    <style>
        
    </style>
@endsection

@section('title')
@endsection

@section('content')

    <div class="nav_tip">
        <div class="img">
            <a href="/"><i class="icon ion-ios-arrow-left"></i></a>
        </div>
        <p class="titile">信息资讯</p>
    </div>
    <div class="weui-tab">
        @if ($postCats->count() > 1)
            <div class="weui-navbar">
                @foreach ($postCats as $element)
                    <a class="weui-navbar__item @if($element->id == $cat_id) weui-bar__item_on @endif" href="/post_cat/{{ $element->id }}">
                        {{ $element->name }}
                    </a>
                @endforeach 
            </div>
        @endif
        <div class="weui-tab__panel">
            @foreach ($posts as $post)
                <a class="news-info" href="/post/{{ $post->id }}">
                    <p class="title">{{ $post->name }}</p>
                    <img src="{{ $post->image }}" alt="">
                    <div class="news-bottom">
                        <span class="view"><i class="icon ion-ios-eye"></i>{{ $post->view }}</span>
                        <span class="date">{{ $post->created_at->format('Y-m-d') }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    @include(frontView('layout.nav'), ['tabIndex' => 1])
@endsection


@section('js')
<script type="text/javascript">
    
</script>
@endsection