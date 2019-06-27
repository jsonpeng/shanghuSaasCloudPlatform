@extends('front.default.layout.base')

@section('css')
    <style>
        .weui-grid{width: 25%;}
        .swipe-wrap{width: 100%;}
        a.swiper-slide{width: 100%; display: block;}
        a.swiper-slide img{width: 100%; display: block;}
    </style>
@endsection

@section('title')
@endsection

@section('content')
<h1>代理商{{ $proxy->nickname }}的首页</h1>
@endsection


@section('js')
@endsection