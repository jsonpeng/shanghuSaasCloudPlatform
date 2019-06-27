@extends('admin.layouts.app_promp')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">秒杀管理</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('flashSales.create') !!}">添加</a>
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
                        <label for="recommend">价格排序</label>
                        <select class="form-control" name="price_sort">
                            <option value="" @if (!array_key_exists('price_sort', $input)) selected="selected" @endif>全部</option>
                            <option value="0" @if (array_key_exists('price_sort', $input) && $input['price_sort'] == '0') selected="selected" @endif>顺序</option>
                            <option value="1" @if (array_key_exists('price_sort', $input) && $input['price_sort'] == '1') selected="selected" @endif>倒序</option>
                        </select>
                    </div>
            
                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
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

         {{--            <div class="form-group col-md-2 col-sm-6 col-xs-12">
                        <label for="recommend">每页显示(默认是{!! $page_list !!}条)</label>
                        <select class="form-control" name="page_list">
                            <option value="{!! $page_list !!}" @if (!array_key_exists('page_list', $input)) selected="selected" @endif>默认</option>
                            <option value="5" @if (array_key_exists('page_list', $input) && $input['page_list'] == '5') selected="selected" @endif>5条</option>
                            <option value="10" @if (array_key_exists('page_list', $input) && $input['page_list'] == '10') selected="selected" @endif>10条</option>
                            <option value="15" @if (array_key_exists('page_list', $input) && $input['page_list'] == '15') selected="selected" @endif>15条</option>
                            <option value="25" @if (array_key_exists('page_list', $input) && $input['page_list'] == '25') selected="selected" @endif>25条</option>
                        </select>
                    </div> --}}
                    <div class="form-group col-md-1 hidden-xs hidden-sm" style="padding-top: 25px;">
                        <button type="submit" class="btn btn-primary pull-right" onclick="search()">查询</button>
                    </div>
                    <div class="form-group col-md-1 visible-xs visible-sm">
                        <button type="submit" class="btn btn-primary pull-left" onclick="search()">查询</button>
                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
        @include('admin.partials.message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('admin.flash_sales.table')
            </div>
        </div>
        <div class="text-center">
         <div class="tc"><?php echo $flashSales->appends($input)->render(); ?></div>
        </div>
    </div>
@endsection

