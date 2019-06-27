@extends('admin.layouts.app_shop')

@section('content')
    <div class="content pdall0-xs">
        <div class="clearfix"></div>

        @include('admin.partials.message')

        <div class="clearfix"></div>
        <div class="box box-default box-solid mb10-xs {!! !$tools?'collapsed-box':'' !!}">
            <div class="box-header with-border">
              <h3 class="box-title">查询</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-{!! !$tools?'plus':'minus' !!}"></i></button>
              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                {!! Form::open(['route' => ['order.report.many'],'id'=>'order_search']) !!}
                    <div class="form-group col-lg-2 col-md-3 col-sm-6 col-xs-6 ">
                        <label for="snumber">订单编号</label>
                        <input type="text" class="form-control" name="snumber" placeholder="订单编号" @if (array_key_exists('snumber', $input))value="{{$input['snumber']}}"@endif>
                    </div>
                    <div class="form-group col-lg-2 col-md-3 col-sm-6 col-xs-6">
                        <label for="snumber">订单金额</label>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <input type="text" class="form-control" name="price_start" placeholder="起" @if (array_key_exists('price_start', $input))value="{{$input['price_start']}}"@endif>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <input type="text" class="form-control" name="price_end" placeholder="止" @if (array_key_exists('price_end', $input))value="{{$input['price_end']}}"@endif>
                            </div>
                        </div>
                    </div>
                       <div class="form-group col-lg-2 col-md-3 col-sm-4 col-xs-6">
                        <label for="order_delivery">订单类型</label>
                        <select class="form-control" name="order_type">
                            <option value="" @if (!array_key_exists('order_type', $input)) selected="selected" @endif>全部</option>
                            <option value="1" @if (array_key_exists('order_type', $input) && $input['order_type'] == '1' || array_key_exists('menu_type', $input) && $input['menu_type'] == '1') selected="selected" @endif>秒杀订单</option>
                             <option value="3" @if (array_key_exists('order_type', $input) && $input['order_type'] == '3' || array_key_exists('menu_type', $input) && $input['menu_type'] == '3') selected="selected" @endif>商品促销订单</option>
                            <option value="4" @if (array_key_exists('order_type', $input) && $input['order_type'] == '4' || array_key_exists('menu_type', $input) && $input['menu_type'] == '4') selected="selected" @endif>促销订单</option>
                            <option value="5" @if (array_key_exists('order_type', $input) && $input['order_type'] == '5' || array_key_exists('menu_type', $input) && $input['menu_type'] == '5') selected="selected" @endif>拼团订单</option>
                            <option value="0" @if (array_key_exists('order_type', $input) && $input['order_type'] == '0' || array_key_exists('menu_type', $input) && $input['menu_type'] == '0') selected="selected" @endif>无促销</option>
                            <option value="6" @if (array_key_exists('order_type', $input) && $input['order_type'] == '6' || array_key_exists('menu_type', $input) && $input['menu_type'] == '6') selected="selected" @endif>发货单</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-2 col-md-3 col-sm-4 col-xs-6">
                        <label for="order_delivery">物流状态</label>
                        <select class="form-control" name="order_delivery">
                            <option value="" @if (!array_key_exists('order_delivery', $input)) selected="selected" @endif>全部</option>
                            <option value="未发货" @if (array_key_exists('order_delivery', $input) && $input['order_delivery'] == '未发货') selected="selected" @endif>未发货</option>
                            <option value="已发货" @if (array_key_exists('order_delivery', $input) && $input['order_delivery'] == '已发货') selected="selected" @endif>已发货</option>
                            <option value="已收货" @if (array_key_exists('order_delivery', $input) && $input['order_delivery'] == '已收货') selected="selected" @endif>已收货</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-2 col-md-3 col-sm-4 col-xs-6">
                        <label for="order_pay">支付状态</label>
                        <select class="form-control" name="order_pay">
                            <option value="" @if (!array_key_exists('order_pay', $input)) selected="selected" @endif>全部</option>
                            <option value="未支付" @if (array_key_exists('order_pay', $input) && $input['order_pay'] == '未支付') selected="selected" @endif>未支付</option>
                            <option value="已支付" @if (array_key_exists('order_pay', $input) && $input['order_pay'] == '已支付') selected="selected" @endif>已支付</option>
                        </select>
                    </div>
                    <!--div class="form-group col-lg-2 col-md-3 col-sm-4 col-xs-6">
                        <label for="order_pay">配送地址</label>
                        <input type="text" class="form-control" name="address" placeholder="配送地址" @if (array_key_exists('address', $input))value="{{$input['address']}}"@endif>
                    </div-->
                    <div class="form-group col-lg-2 col-md-3 col-sm-6 col-xs-6">
                        <label for="order_pay">联系人</label>
                        <input type="text" class="form-control" name="name" placeholder="联系人" @if (array_key_exists('name', $input))value="{{$input['name']}}"@endif>
                    </div>
                    <div class="form-group col-lg-2 col-md-3 col-sm-6 col-xs-6">
                        <label for="order_pay">联系方式</label>
                        <input type="text" class="form-control" name="contact" placeholder="联系方式" @if (array_key_exists('contact', $input))value="{{$input['contact']}}"@endif>
                    </div>
                    <div class="form-group col-lg-4 col-md-8 col-sm-6 col-xs-12">
                        <label>下单时间</label>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <input type="text" class="form-control" name="create_start" id="create_start" placeholder="起" @if (array_key_exists('create_start', $input))value="{{$input['create_start']}}"@endif>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <input type="text" class="form-control" name="create_end" id="create_end" placeholder="止" @if (array_key_exists('create_end', $input))value="{{$input['create_end']}}"@endif>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group col-md-1 hidden-xs hidden-sm" style="padding-top: 25px;">
                        <button type="button" class="btn btn-primary pull-right" onclick="search()">查询</button>
                    </div>

                    <div class="form-group col-md-1 visible-xs visible-sm">
                        <button type="button" class="btn btn-primary pull-left" onclick="search()">查询</button>
                    </div>
          
                     <div class="form-group col-md-1 hidden-xs hidden-sm" style="padding-top: 25px;">
                        <button type="submit" class="btn btn-primary pull-right" onclick="report()">导出</button>
                    </div>

                    <div class="form-group col-md-1 visible-xs visible-sm">
                        <button type="submit" class="btn btn-primary pull-left" onclick="report()">导出</button>
                    </div>
                      {!! Form::close() !!}
            </div><!-- /.box-body -->
        </div><!-- /.box -->

        <div class="box box-primary">
            <div class="box-body">
                    @include('admin.orders.table')
            </div>
        </div>

        <div class="tc"><?php echo $orders->appends($input)->render(); ?></div>
    </div>
@endsection

@include('admin.orders.partial.js')
