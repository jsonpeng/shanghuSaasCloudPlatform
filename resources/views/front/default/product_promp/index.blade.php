@extends('front.default.layout.base')

@section('css')
    <style>
    </style>
@endsection

@section('content')
    
    @foreach ($promps as $promp)
    	<a class="theme-item" href="/product_promp/{{$promp->id}}">
	        <img src="{{$promp->image}}">
	        <div class="title oneline">{{$promp->name}}</div>
	        <!--div class="subtitle oneline">专题描述</div-->
	    </a>
    @endforeach


    @include(frontView('layout.nav'), ['tabIndex' => 2])
@endsection


@section('js')
    
@endsection
