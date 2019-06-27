@extends('admin.layouts.app')


@section('content')
<?php $admin = admin();?>
<section class="content pdall0-xs pt10-xs">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li>
                <a href="javascript:;">
                    <span style="font-weight: bold;"> @if($admin->type == '商户')店铺设置@elseif($admin->type == '管理员' || $admin->type == '代理商')系统设置@endif</span>
                </a>
            </li>

            @if($admin->type == '商户')
                <li class="active">
                    <a href="#tab_1" data-toggle="tab">基本设置</a>
                </li>
                 <li>
                <a href="#tab_6" data-toggle="tab">管理成长任务</a>
                </li>
               {{--  <li>
                    <a href="#tab_2" data-toggle="tab">购物设置</a>
                </li> --}}
                @if(funcOpen('FUNC_CREDITS'))
                <li>
                    <a href="#tab_3" data-toggle="tab">积分设置</a>
                </li>
                @endif

           {{--      <li>
                <a href="#tab_4" data-toggle="tab">显示设置</a>
                </li> --}}

                <li>
                    <a href="#tab_7" data-toggle="tab">小票打印设置</a>
                </li>
                <li>
                    <a href="#tab_8" data-toggle="tab">其他设置</a>
                </li>
            @endif

            @if($admin->type == '管理员')
                <li class="active">
                    <a href="#tab_5" data-toggle="tab">短信设置</a>
                </li>
                <li>
                    <a href="#tab_6" data-toggle="tab">商户设置</a>
                </li>
            @endif

            @if($admin->type == '代理商')
                <li class="active">
                <a href="#tab_1" data-toggle="tab">基本设置</a>
                </li>
            @endif
          {{--   <li>
                <a href="#tab_9" data-toggle="tab">其他设置</a>
            </li> --}}
        </ul>
        <div class="tab-content">
           @if($admin->type == '代理商')
                   <div class="tab-pane active" id="tab_5">
                        <div class="box box-info form">
                            <div class="box-body">
                                <form class="form-horizontal" id="form5">
                                    <div class="form-group">
                                        <label for="sms_platform" class="col-sm-3 control-label">推广链接</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="" disabled="" placeholder="推广链接首页" readonly="readonly" value="{{ http().admin()->account.'.'.domain('proxy').'/index' }}"></div>
                                    </div>
                               </form>
                            </div>
                        </div>
                  </div>
           @endif

           @if($admin->type == '商户')
                <div class="tab-pane active" id="tab_1">
                    <div class="box box-info form">
                        <!-- form start -->
                        <div class="box-body">
                            <form class="form-horizontal" id="form1">
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">店铺名称<span class="bitian">(必填)</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="name" maxlength="60" placeholder="店铺名称" value="{{ getSettingValueByKey('name') }}"></div>
                                </div>

                                
                                <div class="form-group">
                                     <label for="shop_time_begin" class="col-sm-3 control-label">店铺工作时间(起始)</label>
                                    <div class='col-sm-9' >
                                        <div class='input-group date' id='datetimepicker_begin'>
                                            {!! Form::text('shop_time_begin', getSettingValueByKey('shop_time_begin'), ['class' => 'form-control', 'maxlength' => '10']) !!}
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                     <label for="shop_time_end" class="col-sm-3 control-label">店铺工作时间(结束)</label>
                                    <div class='col-sm-9'>
                                        <div class='input-group date' id='datetimepicker_end'>
                                            {!! Form::text('shop_time_end', getSettingValueByKey('shop_time_end') , ['class' => 'form-control', 'maxlength' => '10']) !!}
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="service_tel" class="col-sm-3 control-label">客服电话</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="service_tel" maxlength="60" placeholder="客服电话" value="{{ getSettingValueByKey('service_tel') }}"></div>
                                </div>





                               
                            </form>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(1)">保存</button>
                        </div>
                        <!-- /.box-footer --> </div>
                </div>

                <!-- /.tab-pane -->

                @if(funcOpen('FUNC_CREDITS'))
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_3">
                    <div class="box box-info form">
                        <!-- form start -->
                        <div class="box-body">
                            <form class="form-horizontal" id="form3">
                                <div class="form-group">
                                    <label for="credits_alias" class="col-sm-3 control-label">积分别名</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="credits_alias" maxlength="10" placeholder="积分别名" value="{{ getSettingValueByKey('credits_alias') }}"></div>
                                </div>
                                <div class="form-group">
                                    <label for="register_credits" class="col-sm-3 control-label">注册赠送积分</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" name="register_credits" maxlength="10" placeholder="赠送数值" value="{{ getSettingValueByKey('register_credits') }}"></div>
                                </div>
                                <div class="form-group">
                                    <label for="invite_credits" class="col-sm-3 control-label">邀请人获赠积分</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="invite_credits" maxlength="10" placeholder="" value="{{ getSettingValueByKey('invite_credits') }}"></div>
                                </div>
                                <div class="form-group">
                                    <label for="consume_credits" class="col-sm-3 control-label">购物送积分比例(占商品总金额)</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="consume_credits" maxlength="3" placeholder="" value="{{ getSettingValueByKey('consume_credits') }}">
                                            <span class="input-group-addon">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="credits_rate" class="col-sm-3 control-label">1元能兑换多少积分</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="credits_rate" maxlength="10" placeholder="" value="{{ getSettingValueByKey('credits_rate') }}"></div>
                                </div>

                                <div class="form-group">
                                    <label for="credits_switch" class="col-sm-3 control-label">积分可抵扣订单金额</label>
                                    <div class="col-sm-9">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="credits_switch" value="是" @if( '是' == getSettingValueByKey('credits_switch') )checked="" @endif>是</label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="credits_switch" value="否" @if( '否' == getSettingValueByKey('credits_switch') )checked="" @endif>否</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="credits_min" class="col-sm-3 control-label">最低多少积分才能使用</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="credits_min" maxlength="10" placeholder="" value="{{ getSettingValueByKey('credits_min') }}"></div>
                                </div>

                                <div class="form-group">
                                    <label for="credits_max" class="col-sm-3 control-label">积分抵扣订单金额上限(比例)</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="credits_max"  maxlength="3" placeholder="" value="{{ getSettingValueByKey('credits_max') }}">
                                            <span class="input-group-addon">%</span>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(3)">保存</button>
                        </div>
                    </div>
                </div>
                @endif

                
                <!-- /.tab-pane -->
                 <div class="tab-pane" id="tab_6">
                    <div class="box box-info form">
                        <!-- form start -->
                        <div class="box-body">
                            <form class="form-horizontal" id="form6">
                                
                                <div class="form-group">
                                    <label for="recharge_get_growth" class="col-sm-3 control-label">成长值累计方式</label>
                                    <div class="col-sm-9">
                                        <select name="growth_type" class="form-control">
                                                <option value="1" @if(getSettingValueByKey('growth_type') == 1) selected="selected" @endif>一直累计(没有时间限制,不清零)</option>
                                                <option value="0" @if(getSettingValueByKey('growth_type') == 0) selected="selected" @endif>时间段(当前到一年前)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="recharge_get_growth" class="col-sm-3 control-label">充值</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="recharge_get_growth" maxlength="10" placeholder="充值可获得成长值" value="{{ getSettingValueByKey('recharge_get_growth') }}">
                                            <span class="input-group-addon">点/元</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="product_get_growth" class="col-sm-3 control-label">购买产品(以结算时实际支付金额为主)
                                    </label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="product_get_growth" maxlength="10" placeholder="购买产品
    可获得成长值" value="{{ getSettingValueByKey('product_get_growth') }}">
                                            <span class="input-group-addon">点/元</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="subscribe
    _get_growth" class="col-sm-3 control-label">完成预约
                                    </label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="subscribe
    _get_growth" maxlength="10" placeholder="完成预约可获得成长值" value="{{ getSettingValueByKey('subscribe
    _get_growth') }}">
                                            <span class="input-group-addon">点/次</span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(6)">保存</button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_7">
                    <div class="box box-info form">
                        <!-- form start -->
                        <div class="box-body">
                            <form class="form-horizontal" id="form7">
                                <div class="form-group">
                                    <label for="feie_sn" class="col-sm-3 control-label">飞蛾小票打印机SN</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="feie_sn" maxlength="60" placeholder="" value="{{ getSettingValueByKey('feie_sn') }}"></div>
                                </div>
                                <div class="form-group">
                                    <label for="feie_user" class="col-sm-3 control-label">飞蛾小票打印机USER</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="feie_user" maxlength="60" placeholder="" value="{{ getSettingValueByKey('feie_user') }}"></div>
                                </div>
                                <div class="form-group">
                                    <label for="feie_ukey" class="col-sm-3 control-label">飞蛾小票打印机UKEY</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="feie_ukey" maxlength="60" placeholder="" value="{{ getSettingValueByKey('feie_ukey') }}"></div>
                                </div>
                            </form>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(7)">保存</button>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="tab_8">
                    <div class="box box-info form">
                        <!-- form start -->
                        <div class="box-body">
                            <form class="form-horizontal" id="form8">
                                <div class="form-group">
                                    <label for="feie_sn" class="col-sm-3 control-label">每页显示记录数量</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" name="records_per_page" value="{{ getSettingValueByKey('records_per_page') }}"></div>
                                </div>
                                <div class="form-group">
                                    <label for="feie_sn" class="col-sm-3 control-label">订单提醒邮箱</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="email" value="{{ getSettingValueByKey('email') }}"></div>
                                </div>
                            </form>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(8)">保存</button>
                        </div>
                    </div>
                </div>
            @endif

            @if($admin->type == '管理员')
                <!-- /.tab-pane -->
                <div class="tab-pane active" id="tab_5">
                    <div class="box box-info form">
                        <div class="box-body">
                            <form class="form-horizontal" id="form5">
                                <div class="form-group">
                                    <label for="sms_platform" class="col-sm-3 control-label">短信平台(目前只支持阿里云)</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="sms_platform" disabled="" placeholder="短信平台" value="{{ getSettingValueByKey('sms_platform') }}"></div>
                                </div>
                                <div class="form-group">
                                    <label for="sms_appkey" class="col-sm-3 control-label">短信平台[APP_KEY]</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="sms_appkey"   maxlength="60" placeholder="Access Key ID" value="{{ getSettingValueByKey('sms_appkey') }}"></div>
                                </div>
                                <div class="form-group">
                                    <label for="sms_secretKey" class="col-sm-3 control-label">短信平台[APP_SECRET]</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="sms_secretKey" maxlength="60" placeholder="Access Key Secret" value="{{ getSettingValueByKey('sms_secretKey') }}"></div>
                                </div>

                                <div class="form-group">
                                    <label for="sms_sign" class="col-sm-3 control-label">签名</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="sms_sign" maxlength="60" placeholder="Access Key Secret" value="{{ getSettingValueByKey('sms_sign') }}"></div>
                                </div>

                                <div class="form-group">
                                    <label for="sms_vevify_template" class="col-sm-3 control-label">验证短信模板</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="sms_vevify_template" maxlength="60" placeholder="Access Key Secret" value="{{ getSettingValueByKey('sms_vevify_template') }}"></div>
                                </div>

                                <div class="form-group">
                                    <label for="sms_notify_template" class="col-sm-3 control-label">通知消息模板</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="sms_notify_template" maxlength="60" placeholder="Access Key Secret" value="{{ getSettingValueByKey('sms_notify_template') }}"></div>
                                </div>

                                <div class="form-group">
                                    <label for="sms_send_register" class="col-sm-3 control-label">用户注册时是否发送短信</label>
                                    <div class="col-sm-9">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="sms_send_register" value="是" @if( '是' == getSettingValueByKey('sms_send_register') )checked="" @endif>是</label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="sms_send_register" value="否" @if( '否' == getSettingValueByKey('sms_send_register') )checked="" @endif>否</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sms_send_password" class="col-sm-3 control-label">用户找回密码时是否发送短信</label>
                                    <div class="col-sm-9">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="sms_send_password" value="是" @if( '是' == getSettingValueByKey('sms_send_password') )checked="" @endif>是</label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="sms_send_password" value="否" @if( '否' == getSettingValueByKey('sms_send_password') )checked="" @endif>否</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sms_send_account_check" class="col-sm-3 control-label">身份验证时是否发送短信</label>
                                    <div class="col-sm-9">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="sms_send_account_check" value="是" @if( '是' == getSettingValueByKey('sms_send_account_check') )checked="" @endif>是</label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="sms_send_account_check" value="否" @if( '否' == getSettingValueByKey('sms_send_account_check') )checked="" @endif>否</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sms_send_order" class="col-sm-3 control-label">用户下单时是否发送短信给商家</label>
                                    <div class="col-sm-9">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="sms_send_order" value="是" @if( '是' == getSettingValueByKey('sms_send_order') )checked="" @endif>是</label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="sms_send_order" value="否" @if( '否' == getSettingValueByKey('sms_send_order') )checked="" @endif>否</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sms_send_pay" class="col-sm-3 control-label">客户支付时是否发短信给商家</label>
                                    <div class="col-sm-9">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="sms_send_pay" value="是" @if( '是' == getSettingValueByKey('sms_send_pay') )checked="" @endif>是</label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="sms_send_pay" value="否" @if( '否' == getSettingValueByKey('sms_send_pay') )checked="" @endif>否</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sms_send_deliver" class="col-sm-3 control-label">商家发货时是否给客户发短信</label>
                                    <div class="col-sm-9">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="sms_send_deliver" value="是" @if( '是' == getSettingValueByKey('sms_send_deliver') )checked="" @endif>是</label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="sms_send_deliver" value="否" @if( '否' == getSettingValueByKey('sms_send_deliver') )checked="" @endif>否</label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(5)">保存</button>
                        </div>
                    </div>
                </div>  

                <div class="tab-pane" id="tab_6">
                    <div class="box box-info form">
                        <!-- form start -->
                        <div class="box-body">
                            <form class="form-horizontal" id="form6">
                                
                         

                                <div class="form-group">
                                    <label for="recharge_get_growth" class="col-sm-3 control-label">注册商户默认使用期限</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="reg_shop_account_timer" maxlength="10" placeholder="注册商户默认可使用多少天" value="{{ getSettingValueByKey('reg_shop_account_timer') }}">
                                            <span class="input-group-addon">天</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="recharge_get_growth" class="col-sm-3 control-label">主营商品类目(多个用回车)</label>
                                    <div class="col-sm-9">
                                        
                                            <textarea name="main_shop_cat" rows="5" class="form-control">  {{ getSettingValueByKey('main_shop_cat') }}</textarea>
                                          
                                            
                                    
                                    </div>
                                </div>

                          
                            </form>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(6)">保存</button>
                        </div>
                    </div>
                </div>

       
            @endif


        </div>
        <!-- /.tab-content -->
    </div>
</section>
@endsection

@include('admin.partials.imagemodel')

@section('scripts')
<script>
        //序列化时间
         $('#datetimepicker_begin').datetimepicker({
                format: 'hh:ii',
                autoclose: true,
                startView: 1,  
                minView: 0, 
                minuteStep:1,
                language: 'zh-CN'
        });

        $('#datetimepicker_end').datetimepicker({
                format: 'hh:ii',
                autoclose: true,
                startView: 1,  
                minView: 0, 
                minuteStep:1,
                language: 'zh-CN'
        });

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
                  }else{
                    layer.msg(data.message, {icon: 5});
                  }
                },
                error: function(data) {
                  //提示失败消息

                },
            });
        }

        function openMap(type=''){
            var name =type==''?'detail':'address';
            var address=$('input[name='+name+']').val();
            var url="/zcjy/settings/map?address="+address;
                if($(window).width()<479){
                        layer.open({
                            type: 2,
                            title:'请选择详细地址',
                            shadeClose: true,
                            shade: 0.8,
                            area: ['100%', '100%'],
                            content: url, 
                        });
                }else{
                     layer.open({
                        type: 2,
                        title:'请选择详细地址',
                        shadeClose: true,
                        shade: 0.8,
                        area:['60%', '680px'],
                        content: url, 
                    });
                }
        }

        function call_back_by_map(address,jindu,weidu){
            $('input[name=detail],input[name=address]').val(address);
            $('input[name=weidu]').val(weidu);
            $('input[name=jindu]').val(jindu);
            layer.closeAll();
        }
    </script>
@endsection