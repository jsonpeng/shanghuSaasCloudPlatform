@extends('admin.layouts.app_shop')

@section('content')
    <section class="content-header mb10-xs">
        <h1>销售统计</h1>
        <div class="form-group col-md-12" id="search_tools" style="margin-top: 15px;display: @if(empty($show)) none @else block @endif ;">
             <form action="" method="get">
                <div class="row">
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="start_time" id="start_time" placeholder="开始时间"  @if (array_key_exists('start_time', $input))value="{{$input['start_time']}}"@endif>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="end_time" id="end_time" placeholder="结束时间" @if (array_key_exists('end_time', $input))value="{{$input['end_time']}}"@endif>
                    </div>
                    <div class="col-md-1">
                        {!! Form::submit('查询', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
              </form>
          </div>
    </section>

    <div class="content pdall0-xs">
        <div class="clearfix"></div>

        @include('admin.partials.message')

        <div class="clearfix"></div>
        <div class="">

            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li @if(empty($show)) class="active" @endif><a href="#tab_1" data-toggle="tab">今日统计</a></li>
                    <li><a href="#tab_2" data-toggle="tab">本周统计</a></li>
                    <li><a href="#tab_3" data-toggle="tab">本月统计</a></li>
                    <li @if(!empty($show)) class="active" @endif ><a href="#tab_4" data-toggle="tab">自定义</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane @if(empty($show)) active @endif" id="tab_1">
                        <div class="box box-primary" style="border-top: none;">
                            <div class="row">
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <div class="info-box">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-jpy"></i></span>
                                    <div class="info-box-content">
                                      <span class="info-box-text">营业额</span>
                                      <span class="info-box-number">{{$todaySales->total_sales}} 元</span>
                                    </div><!-- /.info-box-content -->
                                  </div><!-- /.info-box -->
                                </div><!-- /.col -->
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <div class="info-box">
                                    <span class="info-box-icon bg-green"><i class="fa fa-jpy"></i></span>
                                    <div class="info-box-content">
                                      <span class="info-box-text">成本</span>
                                      <span class="info-box-number">{{$todaySales->total_costs}} 元</span>
                                    </div><!-- /.info-box-content -->
                                  </div><!-- /.info-box -->
                                </div><!-- /.col -->
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <div class="info-box">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-user"></i></span>
                                    <div class="info-box-content">
                                      <span class="info-box-text">新增用户数</span>
                                      <span class="info-box-number">{{$todayUsers->total}} 位</span>
                                    </div><!-- /.info-box-content -->
                                  </div><!-- /.info-box -->
                                </div><!-- /.col -->
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <div class="info-box">
                                    <span class="info-box-icon bg-red"><i class="fa fa-shopping-cart"></i></span>
                                    <div class="info-box-content">
                                      <span class="info-box-text">订单数</span>
                                      <span class="info-box-number">{{$todaySales->total_orders}} 笔</span>
                                    </div><!-- /.info-box-content -->
                                  </div><!-- /.info-box -->
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                            <div class="box-header">
                                今日商品服务销量统计
                            </div>
                            <div class="box-body">
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <th>商品</th>
                                            <th>商品服务</th>
                                            <th>销量</th>
                                            <th>金额</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($todayItems as $item)
                                            <tr>
                                                <td>{{$item->name}}</td>
                                                <td>{!! setProductServiceHtml($item->name) !!}</td>
                                                <td>{{$item->total_sales}}</td>
                                                <td>{{$item->total_prices}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                        <div class="box box-primary" style="border-top: none;">

                            <div class="row">
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <div class="info-box">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>
                                    <div class="info-box-content">
                                      <span class="info-box-text">营业额</span>
                                      <span class="info-box-number">{{$weekSales->total_sales}} 元</span>
                                    </div><!-- /.info-box-content -->
                                  </div><!-- /.info-box -->
                                </div><!-- /.col -->
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <div class="info-box">
                                    <span class="info-box-icon bg-green"><i class="fa fa-flag-o"></i></span>
                                    <div class="info-box-content">
                                      <span class="info-box-text">成本</span>
                                      <span class="info-box-number">{{$weekSales->total_costs}} 元</span>
                                    </div><!-- /.info-box-content -->
                                  </div><!-- /.info-box -->
                                </div><!-- /.col -->
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <div class="info-box">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>
                                    <div class="info-box-content">
                                      <span class="info-box-text">新增用户数</span>
                                      <span class="info-box-number">{{$weekUsers->total}} 位</span>
                                    </div><!-- /.info-box-content -->
                                  </div><!-- /.info-box -->
                                </div><!-- /.col -->
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <div class="info-box">
                                    <span class="info-box-icon bg-red"><i class="fa fa-star-o"></i></span>
                                    <div class="info-box-content">
                                      <span class="info-box-text">订单数</span>
                                      <span class="info-box-number">{{$weekSales->total_orders}} 笔</span>
                                    </div><!-- /.info-box-content -->
                                  </div><!-- /.info-box -->
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                            <div class="box-header">
                                本周商品服务销量统计
                            </div>
                            <div class="box-body">
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <th>商品</th>
                                            <th>商品服务</th>
                                            <th>销量</th>
                                            <th>金额</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($weekItems as $item)
                                            <tr>
                                                <td>{{$item->name}}</td>
                                                <td>{!! setProductServiceHtml($item->name) !!}</td>
                                                <td>{{$item->total_sales}}</td>
                                                <td>{{$item->total_prices}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_3">
                        <div class="box box-primary" style="border-top: none;">
                            <div class="row">
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <div class="info-box">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>
                                    <div class="info-box-content">
                                      <span class="info-box-text">营业额</span>
                                      <span class="info-box-number">{{$monthSales->total_sales}} 元</span>
                                    </div><!-- /.info-box-content -->
                                  </div><!-- /.info-box -->
                                </div><!-- /.col -->
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <div class="info-box">
                                    <span class="info-box-icon bg-green"><i class="fa fa-flag-o"></i></span>
                                    <div class="info-box-content">
                                      <span class="info-box-text">成本</span>
                                      <span class="info-box-number">{{$monthSales->total_costs}} 元</span>
                                    </div><!-- /.info-box-content -->
                                  </div><!-- /.info-box -->
                                </div><!-- /.col -->
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <div class="info-box">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>
                                    <div class="info-box-content">
                                      <span class="info-box-text">新增用户数</span>
                                      <span class="info-box-number">{{$monthUsers->total}} 位</span>
                                    </div><!-- /.info-box-content -->
                                  </div><!-- /.info-box -->
                                </div><!-- /.col -->
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <div class="info-box">
                                    <span class="info-box-icon bg-red"><i class="fa fa-star-o"></i></span>
                                    <div class="info-box-content">
                                      <span class="info-box-text">订单数</span>
                                      <span class="info-box-number">{{$monthSales->total_orders}} 笔</span>
                                    </div><!-- /.info-box-content -->
                                  </div><!-- /.info-box -->
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                           <div class="box-header">
                                本月商品服务销量统计
                            </div>
                            <div class="box-body">
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <th>商品</th>
                                            <th>商品服务</th>
                                            <th>销量</th>
                                            <th>金额</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($monthItems as $item)
                                            <tr>
                                                <td>{{$item->name}}</td>
                                                <td>{!! setProductServiceHtml($item->name) !!}</td>
                                                <td>{{$item->total_sales}}</td>
                                                <td>{{$item->total_prices}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- /.tab-pane -->

                    <div class="tab-pane @if(!empty($show)) active @endif" id="tab_4">
         
                        <div class="box-body">
                            <!-- Date range -->
            

                            <div class="box box-primary" style="border-top: none;">
                            <div class="row">
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <div class="info-box">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>
                                    <div class="info-box-content">
                                      <span class="info-box-text">营业额</span>
                                      <span class="info-box-number">@if(!empty($customSales)) {{$customSales->total_sales}}@endif 元</span>
                                    </div><!-- /.info-box-content -->
                                  </div><!-- /.info-box -->
                                </div><!-- /.col -->
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <div class="info-box">
                                    <span class="info-box-icon bg-green"><i class="fa fa-flag-o"></i></span>
                                    <div class="info-box-content">
                                      <span class="info-box-text">成本</span>
                                      <span class="info-box-number">@if(!empty($customSales)) {{$customSales->total_costs}} @endif 元</span>
                                    </div><!-- /.info-box-content -->
                                  </div><!-- /.info-box -->
                                </div><!-- /.col -->
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <div class="info-box">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>
                                    <div class="info-box-content">
                                      <span class="info-box-text">新增用户数</span>
                                      <span class="info-box-number">@if(!empty($customUsers)) {{$customUsers->total}} @endif 位</span>
                                    </div><!-- /.info-box-content -->
                                  </div><!-- /.info-box -->
                                </div><!-- /.col -->
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <div class="info-box">
                                    <span class="info-box-icon bg-red"><i class="fa fa-star-o"></i></span>
                                    <div class="info-box-content">
                                      <span class="info-box-text">订单数</span>
                                      <span class="info-box-number">@if(!empty($customSales)) {{$customSales->total_orders}} @endif 笔</span>
                                    </div><!-- /.info-box-content -->
                                  </div><!-- /.info-box -->
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                           <div class="box-header">
                                自定义时间段商品服务销量统计
                            </div>
                            <div class="box-body">
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <th>商品</th>
                                            <th>商品服务</th>
                                            <th>销量</th>
                                            <th>金额</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @if(!empty($customItems))
                                        @foreach ($customItems as $item)
                                            <tr>
                                                <td>{{$item->name}}</td>
                                                <td>{!! setProductServiceHtml($item->name) !!}</td>
                                                <td>{{$item->total_sales}}</td>
                                                <td>{{$item->total_prices}}</td>
                                            </tr>
                                        @endforeach
                                      @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

        
                            
                        </div>
                    </div>

                </div><!-- /.tab-content -->
            </div><!-- nav-tabs-custom -->
        </div><!-- /.col -->
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        //Date range picker
        //$('#reservation').daterangepicker({format: 'YYYY-MM-DD'});
        $('#start_time, #end_time').datepicker({
            format: "yyyy-mm-dd",
            language: "zh-CN",
            todayHighlight: true
        });
        $('.nav-tabs >li').click(function(){
          if($(this).index()==3){
          $('#search_tools').show();
        }else{
           $('#search_tools').hide();
        }
        });
    </script>
@endsection