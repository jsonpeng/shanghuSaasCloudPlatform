@extends('admin.layouts.app_promp')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">促销商品列表</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('productPromps.create') !!}">添加促销活动</a>
        </h1>
    </section>
    <div class="content pdall0-xs">
        <div class="clearfix"></div>
          <div class="box box-default box-solid mb10-xs {!! !$tools?'collapsed-box':'' !!}">
            <div class="box-header with-border">
              <h3 class="box-title">查询</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-{!! !$tools?'plus':'minus' !!}"></i></button>
              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <form id="order_search">
                    <div class="form-group col-md-2 col-sm-6 col-xs-6">
                        <label for="order_delivery">名称</label>
                       <input type="text" class="form-control" name="name" placeholder="名称" @if (array_key_exists('name', $input))value="{{$input['name']}}"@endif>
                    </div>
                    <div class="form-group col-md-2 col-sm-6 col-xs-6">
                        <label for="recommend">类型</label>
                        <select class="form-control" name="type">
                            <option value="" @if (!array_key_exists('type', $input)) selected="selected" @endif>全部</option>
                            <option value="0" @if (array_key_exists('type', $input) && $input['type'] == '0') selected="selected" @endif>打折优惠</option>
                            <option value="1" @if (array_key_exists('type', $input) && $input['type'] == '1') selected="selected" @endif>减价优惠</option>
                            <option value="2" @if (array_key_exists('type', $input) && $input['type'] == '2') selected="selected" @endif>固定金额出售</option>
                        </select>
                    </div>
            
                    <div class="form-group col-md-4 col-sm-12 col-xs-12">
                        <label for="shelf">时间</label>
                         <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <input type="text" class="form-control" name="start_time" id="datetimepicker_begin" placeholder="开始时间" @if (array_key_exists('start_time', $input))value="{{$input['start_time']}}"@endif>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <input type="text" class="form-control" name="end_time" id="datetimepicker_end" placeholder="结束时间" @if (array_key_exists('end_time', $input))value="{{$input['end_time']}}"@endif>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-1 hidden-xs" style="padding-top: 25px;">
                        <button type="submit" class="btn btn-primary pull-right" onclick="search()">查询</button>
                    </div>
                   <div class="form-group col-md-1 visible-xs">
                        <button type="submit" class="btn btn-primary pull-left" onclick="search()">查询</button>
                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
        @include('admin.partials.message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('admin.product_promps.table')
            </div>
        </div>
        <div class="text-center">
         <div class="tc"><?php echo $productPromps->appends($input)->render(); ?></div>
        </div>
    </div>
@endsection



@section('scripts')
@include('admin.product_promps.partial.js')
@endsection

