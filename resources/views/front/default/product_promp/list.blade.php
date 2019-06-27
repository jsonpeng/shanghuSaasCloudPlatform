@extends('front.default.layout.base')

@section('css')
    <style>
        .weui-grid{width: 25%;}
    </style>
@endsection

@section('content')
    <div class="product-wrapper">
        @foreach($products as $product)
            <a class="product-item2" href="/product/{{ $product->id }}">
                <div class="img">
                    <img src="{{ $product->image }}">
                </div>
                <div class="title">{{ $product->name }}</div>
                <div class="price">¥{{ $product->realPrice }} <span style="float: none; text-decoration: line-through;">¥{{ $product->price }}</span> <span style="float: right;">{{ $product->sales_count }}人购买</span></div>
            </a>
        @endforeach
    </div>
    @include(frontView('layout.nav'), ['tabIndex' => 2])
@endsection

@section('js')
    
@endsection


