@extends('front.default.layout.base')

@section('css')
    <style type="text/css">
        body{
            background-color: #fff;
        }
    </style>
@endsection

@section('title')
    <title>支付成功</title>
@endsection

@section('content')
    <div class="page">
        <div class="weui-msg">
            <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
            <div class="weui-msg__text-area">
                <h2 class="weui-msg__title">支付成功</h2>
                <p class="weui-msg__desc">恭喜您成功支付订单，本页面将在<span id='seconds'>3</span>秒钟后自动跳转</p>
            </div>
            <div class="weui-msg__opr-area">
                <p class="weui-btn-area">
                    <a href="/orders" class="weui-btn weui-btn_primary">返回订单首页</a>
                </p>
            </div>
        </div>
    </div>
@endsection

@section('js')

    <script type="text/javascript">
        $(document).ready(function(){
            var seconds = 3;
            setInterval(function(){
                $('#seconds').text(--seconds);
            }, 1000)
            setTimeout(function(){
                window.location.href = '/orders';
            }, 4000);
        });
    </script>

@endsection

