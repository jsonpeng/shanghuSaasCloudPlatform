@extends('admin.layouts.app_shop')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">预约列表</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('subscribes.create') !!}">新建预约</a>
        </h1>
    </section>
    <div class="content">
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
                        <label for="order_delivery">预约人</label>
                       <input type="text" class="form-control" name="subman" placeholder="预约人名称" @if (array_key_exists('subman', $input))value="{{$input['subman']}}"@endif>
                    </div>

                    <div class="form-group col-md-2 col-sm-6 col-xs-6">
                        <label for="order_delivery">预约人手机号</label>
                       <input type="text" class="form-control" name="mobile" placeholder="预约人手机号" @if (array_key_exists('mobile', $input))value="{{$input['mobile']}}"@endif>
                    </div>

                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                        <label for="shelf">到店时间</label>
                         <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <input type="text" class="form-control" name="start_time" id="datetimepicker_begin" placeholder="开始时间" @if (array_key_exists('start_time', $input))value="{{$input['start_time']}}"@endif>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <input type="text" class="form-control" name="end_time" id="datetimepicker_end" placeholder="结束时间" @if (array_key_exists('end_time', $input))value="{{$input['end_time']}}"@endif>
                            </div>
                        </div>
                    </div>

                   <div class="form-group col-md-3 col-sm-6 col-xs-6">
                        <label for="recommend">预约门店</label>
                        <select class="form-control" name="shop">
                            <option value="" @if (!array_key_exists('shop', $input)) selected="selected" @endif>全部</option>
                            @foreach ($shops as $item)
                            <option value="{{ $item->id }}" @if (array_key_exists('shop', $input) && $item->id==$input['shop']) selected="selected" @endif>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                     <div class="form-group col-md-3 col-sm-6 col-xs-6">
                        <label for="recommend">状态</label>
                        <select class="form-control" name="status">
                            <option value="" @if (!array_key_exists('status', $input)) selected="selected" @endif>全部</option>
                            @foreach ($status as $item)
                            <option value="{{ $item }}" @if (array_key_exists('status', $input) && $item==$input['status']) selected="selected" @endif>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group col-md-1 hidden-sm hidden-xs" style="padding-top: 25px;">
                        <button type="submit" class="btn btn-primary pull-right" onclick="search()">查询</button>
                    </div>

                     <div class="form-group col-md-1 visible-xs visible-sm">
                        <button type="submit" class="btn btn-primary pull-left" onclick="search()">查询</button>
                    </div>

                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('admin.subscribes.table')
            </div>
        </div>
        <div class="text-center">
        {!! $subscribes->appends($input)->links() !!}
        </div>
    </div>
@endsection

@section('scripts')
<script>
         $('#datetimepicker_begin').datetimepicker({
            format: "yyyy-mm-dd hh:ii",
            language: "zh-CN",
            todayHighlight: true
        });
         $('#datetimepicker_end').datetimepicker({
            format: "yyyy-mm-dd hh:ii",
            language: "zh-CN",
            todayHighlight: true
        });
</script>
@endsection

