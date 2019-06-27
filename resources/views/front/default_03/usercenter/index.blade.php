    @extends('front.default.layout.base')

@section('css')
    <style>
        .weui-grid{width: 25%;}
        .user-zone .weui-cell{border-bottom:1px solid #e0e0e0;}
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
                <img src="{{ asset('images/vip.png') }}" alt="">
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
            <div class="weui-cell__ft">查看更多订单</div>
        </a>
    </div>

    <div class="weui-cells section-margin user-zone">
        <a class="weui-cell weui-cell_access" href="/orders/2">
            <div class="weui-cell__bd">
                <p>待付款</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="/orders/3">
            <div class="weui-cell__bd">
                <p>待发货</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="/orders/4">
            <div class="weui-cell__bd">
                <p>待收货</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="/orders/5">
            <div class="weui-cell__bd">
                <p>已完成</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="/refunds">
            <div class="weui-cell__bd">
                <p>售后</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="/usercenter/team">
            <div class="weui-cell__bd">
                <p>拼单记录</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
    </div>

    <div class="weui-cells section-margin">
        <a class="weui-cell" href="/page/shopinfo">
            <div class="weui-cell__bd">
                <p>账户</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
    </div>

    <div class="weui-cells section-margin user-zone">
        <a class="weui-cell weui-cell_access" href="/usercenter/credits">
            <div class="weui-cell__bd">
                <p>积分</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="/usercenter/blances">
            <div class="weui-cell__bd">
                <p>余额</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="/usercenter/withdrawal">
            <div class="weui-cell__bd">
                <p>提现</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="/usercenter/bankcards">
            <div class="weui-cell__bd">
                <p>银行卡</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="/coupon">
            <div class="weui-cell__bd">
                <p>优惠券</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="/usercenter/collections">
            <div class="weui-cell__bd">
                <p>收藏</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="/address">
            <div class="weui-cell__bd">
                <p>地址管理</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
    </div>

    <div class="weui-cells section-margin">
        <a class="weui-cell" href="/page/shopinfo">
            <div class="weui-cell__bd">
                <p>合伙人</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
    </div>


    <div class="weui-cells section-margin user-zone">
        <a class="weui-cell weui-cell_access" href="/usercenter/fellow">
            <div class="weui-cell__bd">
                <p>推荐人</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="/usercenter/bonus">
            <div class="weui-cell__bd">
                <p>分佣记录</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="/usercenter/qrcode">
            <div class="weui-cell__bd">
                <p>分享二维码</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
    </div>

    @include(frontView('layout.nav'), ['tabIndex' => 4])
@endsection


@section('js')
    
@endsection