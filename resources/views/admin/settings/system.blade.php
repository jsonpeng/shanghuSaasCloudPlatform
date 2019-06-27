@extends('admin.layouts.app')


@section('content')
<section class="content pdall0-xs pt10-xs">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li>
                <a href="javascript:;">
                    <span style="font-weight: bold;">系统功能</span>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <div class="box box-info form">
                    <!-- form start -->
                    <div class="box-body">
                        <form class="form-horizontal" id="form1">
                   

                            @if (Config::get('web.FUNC_PRODUCT_PROMP'))
                            <div class="form-group">
                                <label for="FUNC_PRODUCT_PROMP" class="col-sm-3 control-label">商品促销</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_PRODUCT_PROMP" value="0" @if( '0' == sysOpen('FUNC_PRODUCT_PROMP') )checked="" @endif>关闭</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_PRODUCT_PROMP" value="1" @if( '1' == sysOpen('FUNC_PRODUCT_PROMP') )checked="" @endif>开启</label>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if (Config::get('web.FUNC_ORDER_PROMP'))
                            <div class="form-group">
                                <label for="FUNC_ORDER_PROMP" class="col-sm-3 control-label">订单优惠</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_ORDER_PROMP" value="0" @if( '0' == sysOpen('FUNC_ORDER_PROMP') )checked="" @endif>关闭</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_ORDER_PROMP" value="1" @if( '1' == sysOpen('FUNC_ORDER_PROMP') )checked="" @endif>开启</label>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if (Config::get('web.FUNC_ORDER_CANCEL'))
                            <div class="form-group">
                                <label for="FUNC_ORDER_CANCEL" class="col-sm-3 control-label">订单取消</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_ORDER_CANCEL" value="0" @if( '0' == sysOpen('FUNC_ORDER_CANCEL') )checked="" @endif>关闭</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_ORDER_CANCEL" value="1" @if( '1' == sysOpen('FUNC_ORDER_CANCEL') )checked="" @endif>开启</label>
                                    </div>
                                </div>
                            </div>
                            @endif

              {{--               @if (Config::get('web.FUNC_AFTERSALE'))
                            <div class="form-group">
                                <label for="FUNC_AFTERSALE" class="col-sm-3 control-label">退换货</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_AFTERSALE" value="0" @if( '0' == sysOpen('FUNC_AFTERSALE') )checked="" @endif>关闭</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_AFTERSALE" value="1" @if( '1' == sysOpen('FUNC_AFTERSALE') )checked="" @endif>开启</label>
                                    </div>
                                </div>
                            </div>
                            @endif --}}

                            @if (Config::get('web.FUNC_FLASHSALE'))
                            <div class="form-group">
                                <label for="FUNC_FLASHSALE" class="col-sm-3 control-label">秒杀</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_FLASHSALE" value="0" @if( '0' == sysOpen('FUNC_FLASHSALE') )checked="" @endif>关闭</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_FLASHSALE" value="1" @if( '1' == sysOpen('FUNC_FLASHSALE') )checked="" @endif>开启</label>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if (Config::get('web.FUNC_TEAMSALE'))
                            <div class="form-group">
                                <label for="FUNC_TEAMSALE" class="col-sm-3 control-label">拼团</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_TEAMSALE" value="0" @if( '0' == sysOpen('FUNC_TEAMSALE') )checked="" @endif>关闭</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_TEAMSALE" value="1" @if( '1' == sysOpen('FUNC_TEAMSALE') )checked="" @endif>开启</label>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if (Config::get('web.FUNC_COUPON'))
                            <div class="form-group">
                                <label for="FUNC_COUPON" class="col-sm-3 control-label">优惠券</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_COUPON" value="0" @if( '0' == sysOpen('FUNC_COUPON') )checked="" @endif>关闭</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_COUPON" value="1" @if( '1' == sysOpen('FUNC_COUPON') )checked="" @endif>开启</label>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if (Config::get('web.FUNC_CREDITS'))
                            <div class="form-group">
                                <label for="FUNC_CREDITS" class="col-sm-3 control-label">积分</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_CREDITS" value="0" @if( '0' == sysOpen('FUNC_CREDITS') )checked="" @endif>关闭</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_CREDITS" value="1" @if( '1' == sysOpen('FUNC_CREDITS') )checked="" @endif>开启</label>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if (Config::get('web.FUNC_FUNDS'))
                            <div class="form-group">
                                <label for="FUNC_FUNDS" class="col-sm-3 control-label">余额</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_FUNDS" value="0" @if( '0' == sysOpen('FUNC_FUNDS') )checked="" @endif>关闭</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_FUNDS" value="1" @if( '1' == sysOpen('FUNC_FUNDS') )checked="" @endif>开启</label>
                                    </div>
                                </div>
                            </div>
                            @endif


                            @if (Config::get('web.FUNC_DISTRIBUTION'))
                            <div class="form-group">
                                <label for="FUNC_DISTRIBUTION" class="col-sm-3 control-label">分销</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_DISTRIBUTION" value="0" @if( '0' == sysOpen('FUNC_DISTRIBUTION') )checked="" @endif>关闭</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_DISTRIBUTION" value="1" @if( '1' == sysOpen('FUNC_DISTRIBUTION') )checked="" @endif>开启</label>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if (Config::get('web.FUNC_CASH_WITHDRWA'))
                            <div class="form-group">
                                <label for="FUNC_CASH_WITHDRWA" class="col-sm-3 control-label">提现</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_CASH_WITHDRWA" value="0" @if( '0' == sysOpen('FUNC_CASH_WITHDRWA') )checked="" @endif>关闭</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_CASH_WITHDRWA" value="1" @if( '1' == sysOpen('FUNC_CASH_WITHDRWA') )checked="" @endif>开启</label>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if (Config::get('web.FUNC_MEMBER_LEVEL'))
                            <div class="form-group">
                                <label for="FUNC_MEMBER_LEVEL" class="col-sm-3 control-label">会员等级</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_MEMBER_LEVEL" value="0" @if( '0' == sysOpen('FUNC_MEMBER_LEVEL') )checked="" @endif>关闭</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_MEMBER_LEVEL" value="1" @if( '1' == sysOpen('FUNC_MEMBER_LEVEL') )checked="" @endif>开启</label>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if (Config::get('web.FUNC_FAPIAO'))
                            <div class="form-group">
                                <label for="FUNC_FAPIAO" class="col-sm-3 control-label">开发票</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_FAPIAO" value="0" @if( '0' == sysOpen('FUNC_FAPIAO') )checked="" @endif>关闭</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_FAPIAO" value="1" @if( '1' == sysOpen('FUNC_FAPIAO') )checked="" @endif>开启</label>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if (Config::get('web.FUNC_FOOTER'))
                            <div class="form-group">
                                <label for="FUNC_FOOTER" class="col-sm-3 control-label">页面底部信息</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_FOOTER" value="0" @if( '0' == sysOpen('FUNC_FOOTER') )checked="" @endif>关闭</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_FOOTER" value="1" @if( '1' == sysOpen('FUNC_FOOTER') )checked="" @endif>开启</label>
                                    </div>
                                </div>
                            </div>
                            @endif

            {{--                 @if (Config::get('web.FUNC_COLLECT'))
                            <div class="form-group">
                                <label for="FUNC_COLLECT" class="col-sm-3 control-label">商品收藏</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_COLLECT" value="0" @if( '0' == sysOpen('FUNC_COLLECT') )checked="" @endif>关闭</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_COLLECT" value="1" @if( '1' == sysOpen('FUNC_COLLECT') )checked="" @endif>开启</label>
                                    </div>
                                </div>
                            </div>
                            @endif --}}

                            @if (Config::get('web.FUNC_YUNLIKE'))
                            <div class="form-group">
                                <label for="FUNC_YUNLIKE" class="col-sm-3 control-label">显示技术支持</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_YUNLIKE" value="0" @if( '0' == sysOpen('FUNC_YUNLIKE') )checked="" @endif>关闭</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_YUNLIKE" value="1" @if( '1' == sysOpen('FUNC_YUNLIKE') )checked="" @endif>开启</label>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if (Config::get('web.FUNC_WECHATPAY'))
                            <div class="form-group">
                                <label for="FUNC_WECHATPAY" class="col-sm-3 control-label">微信支付</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_WECHATPAY" value="0" @if( '0' == sysOpen('FUNC_WECHATPAY') )checked="" @endif>关闭</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_WECHATPAY" value="1" @if( '1' == sysOpen('FUNC_WECHATPAY') )checked="" @endif>开启</label>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if (Config::get('web.FUNC_PAYSAPI'))
                            <div class="form-group">
                                <label for="FUNC_PAYSAPI" class="col-sm-3 control-label">微信(个人)支付</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_PAYSAPI" value="0" @if( '0' == sysOpen('FUNC_PAYSAPI') )checked="" @endif>关闭</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_PAYSAPI" value="1" @if( '1' == sysOpen('FUNC_PAYSAPI') )checked="" @endif>开启</label>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if (Config::get('web.FUNC_ALIPAY'))
                            <div class="form-group">
                                <label for="FUNC_ALIPAY" class="col-sm-3 control-label">支付宝</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_ALIPAY" value="0" @if( '0' == sysOpen('FUNC_ALIPAY') )checked="" @endif>关闭</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="FUNC_ALIPAY" value="1" @if( '1' == sysOpen('FUNC_ALIPAY') )checked="" @endif>开启</label>
                                    </div>
                                </div>
                            </div>
                            @endif

                        </form>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(1)">保存</button>
                    </div>
                    <!-- /.box-footer --> 
                </div>
            </div>
        </div>
        <!-- /.tab-content -->
    </div>
</section>
@endsection

@include('admin.partials.imagemodel')

@section('scripts')
<script>
        function saveForm(index){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"/zcjy/settings/setting",
                type:"POST",
                data:$("#form"+index).serialize(),
                success: function(data) {
                  if (data.code == 0) {
                    layer.msg(data.message, {icon: 1});
                    location.reload();
                  }else{
                    layer.msg(data.message, {icon: 5});
                  }
                },
                error: function(data) {
                  //提示失败消息

                },
            });
            
        }
    </script>
@endsection