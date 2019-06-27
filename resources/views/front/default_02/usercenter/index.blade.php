@extends('front.default.layout.base')

@section('css')
    <style>
        .weui-grid{width: 25%;}
    </style>
@endsection

@section('content')
    <div class="nav_tip">
      <div class="img">
        <a href="javascript:history.back(-1)"><img src="{{ asset('images/return.png') }}" alt=""></a></div>
      <p class="titile">我的</p>
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
                    <img src="{{ asset('images/theme02/g1.jpg') }}" alt="">
                </div>
                <p class="weui-grid__label">待付款</p>
            </a>
{{--             <a href="/orders/3" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{ asset('images/theme02/g2.jpg') }}" alt="">
                </div>
                <p class="weui-grid__label">待消费</p>
            </a> --}}
            <a href="/orders/4" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{ asset('images/theme02/g3.jpg') }}" alt="">
                </div>
                <p class="weui-grid__label">已完成</p>
            </a>
            <a href="/orders/5" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{ asset('images/theme02/g4.jpg') }}" alt="">
                </div>
                <p class="weui-grid__label">待发货</p>
            </a>
            <a href="/orders/5" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{ asset('images/theme02/g5.jpg') }}" alt="">
                </div>
                <p class="weui-grid__label">待收货</p>
            </a>
            <a href="/orders/5" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{ asset('images/theme02/g6.jpg') }}" alt="">
                </div>
                <p class="weui-grid__label">待评价</p>
            </a>
            @if(funcOpen('FUNC_AFTERSALE'))
            <a href="/refunds" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{ asset('images/theme02/g7.jpg') }}" alt="">
                </div>
                <p class="weui-grid__label">售后</p>
            </a>
            @endif

            @if(funcOpen('FUNC_TEAMSALE'))
            <a href="/usercenter/team" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{ asset('images/theme02/g8.jpg') }}" alt="">
                </div>
                <p class="weui-grid__label">拼单记录</p>
            </a>
            @endif
        </div>
    </div>

    <div class="weui-cells section-margin">
        <div class="weui-cells__title">账户</div>
        <div class="weui-grids index-function-grids">
            @if(funcOpen('FUNC_CREDITS'))
            <a href="/usercenter/credits" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{ asset('images/theme02/g9.jpg') }}" alt="">
                </div>
                <p class="weui-grid__label">{{ getSettingValueByKeyCache('credits_alias') }}{{ $user->credits }}</p>
            </a>
            @endif

            @if(funcOpen('FUNC_FUNDS'))
            <a href="/usercenter/blances" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{ asset('images/theme02/g10.jpg') }}" alt="">
                </div>
                <p class="weui-grid__label">余额</p>
            </a>
            @endif

            @if(funcOpen('FUNC_CASH_WITHDRWA'))
            <a href="/usercenter/withdrawal" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{ asset('images/theme02/g11.jpg') }}" alt="">
                </div>
                <p class="weui-grid__label">提现</p>
            </a>


            @endif

            @if(funcOpen('FUNC_COUPON'))
            <a href="/coupon" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{ asset('images/theme02/g12.jpg') }}" alt="">
                </div>
                <p class="weui-grid__label">优惠券</p>
            </a>
            @endif
            
            @if(funcOpen('FUNC_COLLECT'))
            <a href="/usercenter/collections" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{ asset('images/theme02/g13.jpg') }}" alt="">
                </div>
                <p class="weui-grid__label">收藏</p>
            </a>
            @endif

            <a href="/address" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{ asset('images/theme02/g14.jpg') }}" alt="">
                </div>
                <p class="weui-grid__label">地址管理</p>
            </a>
        </div>
    </div>

    @if(funcOpen('FUNC_DISTRIBUTION'))
    <div class="weui-cells section-margin">
        <div class="weui-cells__title">合伙人</div>
        <div class="weui-grids index-function-grids">
            <a href="/usercenter/fellow" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{ asset('images/theme02/g15.jpg') }}" alt="">
                </div>
                <p class="weui-grid__label">推荐{{ $user->level1 + $user->level2 + $user->level3 }}人</p>
            </a>
            <a href="/usercenter/bankcards" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{ asset('images/theme02/g16.jpg') }}" alt="">
                </div>
                <p class="weui-grid__label">银行卡</p>
            </a>
            <a href="/usercenter/bonus" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{ asset('images/theme02/g17.jpg') }}" alt="">
                </div>
                <p class="weui-grid__label">分佣记录</p>
            </a>
            
            <a href="/usercenter/qrcode" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{ asset('images/theme02/g18.jpg') }}" alt="">
                </div>
                <p class="weui-grid__label">分享二维码</p>
            </a>
        </div>
    </div>
    @endif

    @include(frontView('layout.nav'), ['tabIndex' => 4])
@endsection


@section('js')
    
@endsection