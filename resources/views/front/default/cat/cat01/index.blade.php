@extends('front.default.layout.base')

@section('css')
    <style>
      ul li{
        display: inline-block; height: 40px; line-height: 40px; padding: 0 10px;
      }
    </style>
@endsection

@section('content')
    <div class="cat-selector">
      <ul>
        <li @if($cat_id == 0) class="active" @endif><a href="/category/cat_level_01">全部商品</a></li>
        @foreach ($categories as $element)
          <li @if($cat_id == $element->id) class="active" @endif><a href="/category/cat_level_01/{{$element->id}}">{{$element->name}}</a></li>
        @endforeach
      </ul>
    </div>

    <div class="product-wrapper" style="margin-top: 2rem;">
      @foreach ($products as $element)
        <a class="product-item2" href="/product/{{$element->id}}">
            <div class="img">
                <img class="lazy" data-original="{{ $element->image }}">
            </div>
            <div class="title">{{$element->name}}</div>
            <div class="price">¥{{$element->price}} <span class="buynum">{{ $element->sales_count }}人购买</span></div>
        </a>
      @endforeach
    </div>
    
    @include(frontView('layout.nav'), ['tabIndex' => 2])
@endsection
