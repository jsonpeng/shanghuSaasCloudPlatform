@extends('admin.layouts.app_distribution')

@section('content')
    <section class="content-header">
        <h1 class="pull-left mb15">分销设置</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('admin.partials.message')

        <div class="clearfix"></div>
        <div class="box box-primary form">
            <div class="box-body">
                <form class="form-horizontal" id="form4">
                <div class="form-group">
                    <label for="distribution" class="col-sm-3 control-label">是否开启分销</label>
                    <div class="col-sm-9">
                          <div class="radio">
                            <label>
                              <input type="radio" name="distribution" value="是" @if( '是' == getSettingValueByKey('distribution') )checked="" @endif>
                              是
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" name="distribution" value="否" @if( '否' == getSettingValueByKey('distribution') )checked="" @endif>
                              否
                            </label>
                          </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="distribution_condition" class="col-sm-3 control-label">用户加入分销方式</label>
                    <div class="col-sm-9">
                          <div class="radio">
                            <label>
                              <input type="radio" name="distribution_condition" value="注册用户" @if( '注册用户' == getSettingValueByKey('distribution_condition') )checked="checked" @endif>
                              注册用户
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" name="distribution_condition" value="购买商品" @if( '购买商品' == getSettingValueByKey('distribution_condition') )checked="" @endif>
                              购买商品
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" name="distribution_condition" value="管理员开启" @if( '管理员开启' == getSettingValueByKey('distribution_condition') )checked="" @endif>
                              管理员开启
                            </label>
                          </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="distribution_type" class="col-sm-3 control-label">提成方式</label>
                    <div class="col-sm-9">
                          <div class="radio">
                            <label>
                              <input type="radio" name="distribution_type" value="商品" @if( '商品' == getSettingValueByKey('distribution_type') )checked="" @endif>
                              商品
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" name="distribution_type" value="订单" @if( '订单' == getSettingValueByKey('distribution_type') )checked="" @endif>
                              订单
                            </label>
                          </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="distribution_percent" class="col-sm-3 control-label">订单金额提成比例</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="number" class="form-control" name="distribution_percent" placeholder="" value="{{ getSettingValueByKey('distribution_percent') }}">
                            <span class="input-group-addon">%</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="distribution_selft" class="col-sm-3 control-label">购买者提成点</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="number" class="form-control" name="distribution_selft" placeholder="" value="{{ getSettingValueByKey('distribution_selft') }}">
                            <span class="input-group-addon">%</span>
                        </div>
                        
                        
                    </div>
                </div>
                <div class="form-group">
                    <label for="distribution_level1_name" class="col-sm-3 control-label">一级分销商名称</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="distribution_level1_name" placeholder="" value="{{ getSettingValueByKey('distribution_level1_name') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="distribution_level1_percent" class="col-sm-3 control-label">一级分销商提成比例</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="number" class="form-control" name="distribution_level1_percent" placeholder="" value="{{ getSettingValueByKey('distribution_level1_percent') }}">
                            <span class="input-group-addon">%</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="distribution_level2_name" class="col-sm-3 control-label">二级分销商名称</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="distribution_level2_name" placeholder="" value="{{ getSettingValueByKey('distribution_level2_name') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="distribution_level2_percent" class="col-sm-3 control-label">二级分销商提成比例</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="number" class="form-control" name="distribution_level2_percent" placeholder="" value="{{ getSettingValueByKey('distribution_level2_percent') }}">
                            <span class="input-group-addon">%</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="distribution_level3_name" class="col-sm-3 control-label">三级分销商名称</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="distribution_level3_name" placeholder="" value="{{ getSettingValueByKey('distribution_level3_name') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="distribution_level3_percent" class="col-sm-3 control-label">三级分销商提成比例</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="number" class="form-control" name="distribution_level3_percent" placeholder="" value="{{ getSettingValueByKey('distribution_level3_percent') }}">
                            <span class="input-group-addon">%</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="weixin" class="col-sm-3 control-label">分享二维码底图</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="image3" name="share_qrcode_img" placeholder="分享二维码底图" value="{{ getSettingValueByKey('share_qrcode_img') }}">
                   <div class="input-append">
                            <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image3')">选择图片</a>
                            <img src="@if(getSettingValueByKey('share_qrcode_img')) {{ getSettingValueByKey('share_qrcode_img') }} @endif" style="max-width: 100%; max-height: 300px; display: block;">
                        </div>
                    </div>
                </div>

                </form>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(4)">保存</button>
            </div>
        </div>
    </div>
    @include('admin.partials.imagemodel')
@endsection

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
