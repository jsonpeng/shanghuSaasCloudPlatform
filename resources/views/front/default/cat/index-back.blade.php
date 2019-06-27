@extends('front.default.layout.base')

@section('css')
    <style>

    </style>
@endsection

@section('content')
    <div class="cat-left">
      @foreach($categories as $category)
        <a class="cat-row @if($category->id == $cat_id) active @endif" href="/category/{{ $category->id}}" >分类</a>
      @endforeach
    </div>
    <div class="cat-right" id="scroll02">
      @foreach($products as $product)
        <a class="zcjy-product-cat row" href="/product/{{ $product->id }}">
            <img src="{{ $product->image }}" class="product-image">
            <div class="product-name oneline">{{ $product->name }}</div>
            <div class="remark oneline">{{ $product->remark }}</div>
            <div class="price oneline">售价：{{ $product->price }}</div>
        </a>
      @endforeach
    </div>
    
    @include('front.default.layout.nav')
@endsection
