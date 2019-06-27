@extends('front.default.layout.base')

@section('css')
    <style>
        /*.weui-grid{width: 25%;}*/
    </style>
@endsection

@section('content')
    <div class="nav_tip">
      <div class="img">
        <a href="javascript:history.back(-1)"><img src="{{ asset('images/return.png') }}" alt=""></a></div>
      <p class="titile">个人中心</p>
    </div>
    <div class="userInfo">
        <img class="bg" src="{{ asset('images/default_01/usercenter.png') }}" alt="">
{{--         <div class="add">
            <img src="{{asset('images/place.png')}}" alt=""><a>查看商家地址</a>
        </div> --}}
        <div class="userImg">
            <img src="{{ $user->head_image }}" alt="">
        </div>
        @if(funcOpen('FUNC_MEMBER_LEVEL') && !empty($userLevel))
            <div class="menber">
                <img src="{{ asset('images/vip.png') }}" alt=""><span>尊敬的</span><span>{{ $userLevel->name }}</span>
            </div>
        @endif
        <div class="name">
            {{ $user->nickname }}
        </div>
    </div>
    <div class="weui-cells section-margin">
        <a class="weui-cell weui-cell_access" href="/orders">
            <div class="weui-cell__bd">
                <p>我的订单</p>
            </div>
            <div class="weui-cell__ft">查看全部订单</div>
        </a>
        <div class="weui-grids index-function-grids">
            <a href="/orders/2" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{ asset('images/default_01/c1.png') }}" alt="">
                </div>
                <p class="weui-grid__label">待付款</p>
            </a>
            <a href="/orders/3" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{ asset('images/default_01/c2.png') }}" alt="">
                </div>
                <p class="weui-grid__label">待发货</p>
            </a>
            <a href="/orders/4" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{ asset('images/default_01/c3.png') }}" alt="">
                </div>
                <p class="weui-grid__label">待收货</p>
            </a>
        </div>
    </div>
    <div class="weui-cells">
        <a class="weui-cell weui-cell_access" href="/address">
            <div class="weui-cell__bd">
                <p>收货地址</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>  
    </div>

    @if(funcOpen('FUNC_DISTRIBUTION') && $user->is_distribute)
    <div class="weui-cells">
        <a class="weui-cell weui-cell_access" href="/usercenter/bonus">
            <div class="weui-cell__bd">
                <p>推荐记录</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>  
    </div>
    @endif

    @include(frontView('layout.nav'), ['tabIndex' => 4])
@endsection


@section('js')
    
@endsection