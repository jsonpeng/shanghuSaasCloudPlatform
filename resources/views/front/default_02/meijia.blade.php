@extends('front.default.layout.base')

<!-- 新品推荐 -->
<div style="background-color: #fff;padding: 15px 0; margin-top: 5px;">
    <div class="theme-title">
        <div class="content"><img src="{{ asset('images/default/index/sift.png') }}" style="vertical-align: middle; margin-right: 10px;">热销商品，精选推荐</div>
    </div>
</div>

<div class="product-wrapper scroll-container">
    @foreach ($products as $product)
        <a class="product-item2 scroll-post" href="/product/{{ $product->id }}">
            <div class="img">
                <img src="{{ $product->image }}">
                @if($product->is_hot)<p class="hot">HOT</p>@endif
            </div> 
            <div class="title">{{ $product->name }}</div>
            <div class="price">¥{{ $product->price }} <span>{{ $product->sales_count }}人购买</span></div>
        </a>
    @endforeach
</div>