@extends('front.default.layout.base')

@section('css')
    <style>

    </style>
@endsection

@section('title')
  <title>用户注册</title>
@endsection

@section('content')
  @include('front.default.partial.error')

  <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">手机号</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="tel" placeholder="请输入手机号" id="tel"/>
            </div>
        </div>
        <div class="weui-cell weui-cell_vcode">
            <div class="weui-cell__hd">
                <label class="weui-label">验证码</label>
            </div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="number" pattern="[0-9]*" placeholder="请输入验证码" id="code"/>
            </div>
            <div class="weui-cell__ft">
                <button class="weui-vcode-btn" id="getcode" onclick="sendCode()">获取验证码</button>
            </div>
        </div>
    </div>
    <div class="weui-btn-area">
        <a class="weui-btn weui-btn_primary" href="javascript:" id="showTooltips"  onclick="submit()">确定</a>
    </div>

@endsection


@section('js')
    <script type="text/javascript">
        function sendCode() {

            var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/; 
            if(!myreg.test($("#tel").val())) 
            { 
                //alert('请输入有效的手机号码！'); 
                $('#g_iosDialog2_text').text('请输入有效的手机号码！');
                $('#g_iosDialog2').fadeIn(200);
                return false; 
            } 

            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/sendCode',
                type: 'GET',
                data: {mobile: $('#tel').val()},
            });

            time();
        }

        function submit() {
            var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/; 
            if(!myreg.test($("#tel").val())) 
            { 
                //alert('请输入有效的手机号码！'); 
                $('#g_iosDialog2_text').text('请输入有效的手机号码！');
                $('#g_iosDialog2').fadeIn(200);
                return false; 
            } 
            if ($("#code").val() == '' || $("#code").val().length != 4) {
                $('#g_iosDialog2_text').text('请输入有效验证码！');
                $('#g_iosDialog2').fadeIn(200);
                return false; 
            }
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/mobile',
                type: 'POST',
                data: {mobile: $('#tel').val(), code: $('#code').val()},
                success: function(data) {
                    //提示成功消息
                    if (data.code == 0) {
                        window.location.href = "/";
                    } else {
                      alert('输入信息不正确');
                        $('#g_iosDialog2_text').text('输入信息不正确');
                        $('#g_iosDialog2').fadeIn(200);
                    }                   
                },
            });
        }

        var wait=60;
        function time() {
            o = $('#getcode');
            if (wait == 0) {
                o.removeAttr("disabled");   
                o.text("获取验证码");
                wait = 60;
            } else { 

                o.attr("disabled", true);
                o.text("重新发送(" + wait + ")");
                wait--;
                setTimeout(function() {
                    time()
                }, 1000)
            }
        }

    </script>
@endsection

