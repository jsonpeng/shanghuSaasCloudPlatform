@extends('admin.layouts.app')

@section('css')
	<style>
		ul{
		  list-style: none;
		  margin:0;
			padding:0;
		}
		.section{
			margin:0 50px;
			padding-top:15px;
		}
		
		.content{
			text-align: center;
			overflow: hidden;

		}
		.item{
			background-color:#fff;
			margin-right: 20px;
			width:300px;
			padding:0 6px;
			float:left;
			box-shadow:0 0 8px rgba(0,14,45,0.11);
		}
		.half-top{
			padding-top: 40px;
			padding-bottom:30px;
		}
		.half-top h3{
			font-size: 20px;
			color:#000;
			margin:0;
		}
		.half-top .img{
			margin:25px 0;

		}
		.half-top .price{
			font-size: 22px;
			color:#000;
			margin-bottom: 40px;
		}
		.half-top .dinggou a{
			display: inline-block;
			width:190px;
			height:40px;
			line-height: 40px;
			color:#fff;
			font-size: 14px;
			background-color: #4c84ff;
			border-radius: 5px;
		}
		.half-top .dinggou.had a{
			background-color: #ddd;
		}
		.function-list{
			padding-top: 28px;
			padding-bottom: 20px;
			border-top:1px solid #efefef;
			border-bottom:1px solid #efefef;
			box-sizing: border-box;
		}
		.function-list ul li{
			font-size: 14px;
			color:#8f8f8f;
			margin-bottom: 8px;
		}
		.function-list ul li:last-child{
			margin-top:30px;
		}
		.bottom{
			padding-top:13px;
			padding-bottom:23px;

		}
		.bottom p{
			font-size: 14px;
			color:#8f8f8f;
			line-height: 27px;
			margin-bottom: 0;
		}
		.light{
			color:#4c84ff!important;
		}
	</style>
@endsection

@section('content')
	<div class="section">
		
			@if($admin_package['level'] == 0)
				<div class="hint">
					免费试用期还剩{{ $admin_package['time'] }}天，为了不影响使用，请尽快购买套餐哦。咨询电话：027-88888888 
				<!-- 	<a href="">立即续约</a> -->
				</div>
			@else
				<div class="hint">
					当前{{ $admin_package['package']['package_name'] }}套餐还剩{{ $admin_package['time'] }}天，咨询电话：027-88888888 
					<a href="javascript:;">立即续费</a>
				</div>
			@endif

			<div class="content">
				@foreach ($packages as $package)
					<div class="item">
					<div class="half-top">
						<h3>{{ $package->name }}</h3>
						<div class="img">
							<img src="{{ $package->image }}" alt="">
						</div>
						<div class="price">¥{{ $package->rel_price }}/年</div>
						<p class="dinggou @if($package->status=='已拥有') had @endif" >
							<a href=" @if($package->status=='已拥有') javascript:; @else {{ route('package.detail',$package->id).'?type='.$package->type }} @endif">{{ $package->status }}</a>
						</p>
					</div>
					<div class="function-list">
						<ul>
							<li>适用于{{ $package->canuse_shop_num }}家门店</li>
							<?php $words = $package['words'];?>
								@foreach ($words as $word)
									<li class="light">{{ $word->name }}</li>
								@endforeach
							<li>...</li>
						</ul>
					</div>
					@if(count($package['exclusive_list']))
						<div class="bottom">
							@foreach ($package['exclusive_list'] as $item)
									<p>{{ $item }}</p>
							@endforeach
						</div>
					@endif
				</div>
				@endforeach
			
		
			</div>
		</div>
@endsection

@section('scripts')
		<script>
			var lis=[];
			$('.function-list').each(function(){
				var i=$(this).find('li').length;
				lis.push(i);
			})
			var maxUl=Math.max.apply(null, lis);
			var liHeight=$('.function-list').find('li').height();
			
			var faHeight=(liHeight+8)*maxUl+30-8
			
			$('.function-list').height(faHeight);
			var ps=[];
			$('.bottom').each(function(){
				var j=$(this).find('p').length;
				ps.push(j);
			})
			var maxp=Math.max.apply(null, ps);
			var pHeight=$('.bottom').find('p').height();
			var mpHeight=pHeight*maxp;
			$('.bottom').height(mpHeight);

			$('.hint a').click(function(){
				console.log($(this));
				var that =this;
				$('.item').find('a').each(function(){
					if($(that).text() == $(this).text() ){
						location.href = $(this).attr('href');
					}
				})

			});
		</script>
@endsection