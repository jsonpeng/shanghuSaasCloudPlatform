@extends('front.default.layout.base')

@section('css')
    <style>
    	.post-title{
        	font-size: 18px;
        	color: #666;
        	padding: 15px 15px;
        	text-align: center;
        }

        .post-sub-title{
        	font-size: 14px;
        	color: #666;
        	padding: 5px 15px;
        	padding-top: 0;
        }

        .post-sub-title span{
        	color: #999;
        }

        .post-content{
        	font-size: 15px;
        	line-height: 30px;
        	color: #666;
        	padding: 15px;
        }
        .post-content img{
        	max-width: 100%;
        }
        body{background-color: #fff;}
    </style>
@endsection

@section('content')

	<div class="nav_tip">
	  	<div class="img">
	    	<a href="javascript:history.back(-1)"><i class="icon ion-ios-arrow-left"></i></a></div>
	  	<p class="titile">{{ getSettingValueByKeyCache('name') }}</p>
	</div>
    
    <div class="post-title">{{ $page->name }}</div>

    <div class="post-sub-title"> {{ getSettingValueByKeyCache('name') }}发表于 <span>{{ $page->created_at->diffForHumans() }}</span></div>

    <div class="post-content">{!! $page->content !!}</div>
    

@endsection


@section('js')
    
@endsection