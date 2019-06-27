@extends('front.default.layout.base')

@section('css')
    <style>
    </style>
@endsection

@section('content')
    
    @foreach ($groups as $group)
    	<a class="group-sale-item" href="/product/{{$group->product->id}}">
	        <img src="{{$group->product->image}}">
	        <div class="">{{$group->product_name}}</div>
            <div class="">价格: {{$group->price}}</div>
            <div class="">已售: {{$group->buy_num}}</div>
            <div class="">还剩: {{$group->product_max - $group->buy_num}}</div>
	        <!--div class="subtitle oneline">专题描述</div-->
	    </a>
    @endforeach

    @include(frontView('layout.nav'), ['tabIndex' => 2])
@endsection


@section('js')
    
@endsection
