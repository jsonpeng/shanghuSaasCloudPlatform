@extends('admin.layouts.app_shop')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">产品列表</h1>
        <h1 class="pull-right">
            <a class="btn btn-primary pull-right" style="margin-bottom: 5px" href="{!! route('products.create') !!}">添加产品</a>
        </h1>
    </section>
    <div class="content pdall0-xs">
              <div class="clearfix"></div>
        <div class="box box-default box-solid mb10-xs @if(!$tools) collapsed-box @endif">
            <div class="box-header with-border">
              <h3 class="box-title">查询</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-{!! !$tools?'plus':'minus' !!}"></i></button>
              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <form id="order_search">
                    <div class="form-group col-lg-2 col-md-3 col-sm-6 col-xs-6">
                        <label for="product_id_sort">创建时间</label>
                        <select class="form-control" name="product_id_sort">
                            <option value="" @if (!array_key_exists('product_id_sort', $input)) selected="selected" @endif>全部</option>
                            <option value="升序" @if (array_key_exists('product_id_sort', $input) && $input['product_id_sort'] == '升序') selected="selected" @endif>升序</option>
                            <option value="倒序" @if (array_key_exists('product_id_sort', $input) && $input['product_id_sort'] == '倒序') selected="selected" @endif>倒序</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-2 col-md-4 col-sm-6 col-xs-6">
                        <label for="snumber">产品金额</label>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <input type="text" class="form-control" name="price_start" placeholder="起" @if (array_key_exists('price_start', $input))value="{{$input['price_start']}}"@endif>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <input type="text" class="form-control" name="price_end" placeholder="止" @if (array_key_exists('price_end', $input))value="{{$input['price_end']}}"@endif>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                        <label for="order_delivery">产品名称</label>
                       <input type="text" class="form-control" name="product_name" placeholder="产品名称" @if (array_key_exists('product_name', $input))value="{{$input['product_name']}}"@endif>
                    </div>
                    <div class="form-group col-lg-4 col-md-9 col-sm-12 col-xs-12">
                        <label for="order_pay">所有分类</label>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr0-xs">  
                                {!! Form::select('cat_level01',$first_cats, $level01 , ['class' => 'form-control level01']) !!}
                            </div>
                        {{--     <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 pr0-xs">    
                                {!! Form::select('cat_level02',$second_cats,$level02 , ['class' => 'form-control level02']) !!}
                             </div>
                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 pr0-xs">    
                            {!! Form::select('cat_level03', $third_cats, $level03 , ['class' => 'form-control level03']) !!}
                           </div> --}}
                        </div>
                    </div>
                    <div class="form-group col-lg-2 col-md-3 col-sm-6 col-xs-6">
                        <label for="price_sort">价格排序</label>
                        <select class="form-control" name="price_sort">
                            <option value="" @if (!array_key_exists('price_sort', $input)) selected="selected" @endif>全部</option>
                            <option value="升序" @if (array_key_exists('price_sort', $input) && $input['price_sort'] == '升序') selected="selected" @endif>升序</option>
                            <option value="倒序" @if (array_key_exists('price_sort', $input) && $input['price_sort'] == '倒序') selected="selected" @endif>倒序</option>
                        </select>
                    </div>
                    <!--div class="form-group col-lg-2 col-md-3 col-sm-6 col-xs-6">
                        <label for="recommend">是否推荐</label>
                        <select class="form-control" name="recommend">
                            <option value="" @if (!array_key_exists('recommend', $input)) selected="selected" @endif>全部</option>
                            <option value="1" @if (array_key_exists('recommend', $input) && $input['recommend'] == '1') selected="selected" @endif>是</option>
                            <option value="0" @if (array_key_exists('recommend', $input) && $input['recommend'] == '0') selected="selected" @endif>否</option>
                        </select>
                    </div-->
                    <div class="form-group col-lg-2 col-md-3 col-sm-6 col-xs-6">
                        <label for="shelf">是否上架</label>
                        <select class="form-control" name="shelf">
                            <option value="" @if (!array_key_exists('shelf', $input)) selected="selected" @endif>全部</option>
                            <option value="1" @if (array_key_exists('shelf', $input) && $input['shelf'] == '1') selected="selected" @endif>是</option>
                            <option value="0" @if (array_key_exists('shelf', $input) && $input['shelf'] == '0') selected="selected" @endif>否</option>
                        </select> 
                    </div>
           {{--          <div class="form-group col-lg-2 col-md-3 col-sm-6 col-xs-6">
                        <label for="shelf">库存排序</label>
                        <select class="form-control" name="inventory">
                            <option value="" @if (!array_key_exists('inventory', $input)) selected="selected" @endif>全部</option>
                            <option value="升序" @if (array_key_exists('inventory', $input) && $input['inventory'] == '升序') selected="selected" @endif>升序</option>
                            <option value="倒序" @if (array_key_exists('inventory', $input) && $input['inventory'] == '倒序') selected="selected" @endif>倒序</option>
                        </select>
                    </div> --}}
                    <div class="form-group col-lg-1 col-md-1 hidden-xs hidden-sm" style="padding-top: 25px;">
                        <button type="submit" class="btn btn-primary pull-right " onclick="search()">查询</button>
                    </div>
                    <div class="form-group col-xs-6 visible-xs visible-sm" >
                        <button type="submit" class="btn btn-primary pull-left " onclick="search()">查询</button>
                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

        @include('admin.partials.message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('admin.products.table')
            </div>
        </div>
        <div class="tc"><?php echo $products->appends($input)->render(); ?></div>
    </div>
@endsection


@section('scripts')
    <script type="text/javascript">
        $('.selectpicker').selectpicker({
          size: 8
        });

        function search() {
            window.location.href = "/zcjy/orders?"+$('#order_search').serialize();
        }

/*
            $('.level01').on('change', function(){

            $('select.level03').empty();
            $('select.level03').append("<option value='0'>请选择分类</option>");

            var newParentID = $('select.level01').val();
            if (newParentID == 0) {
                $('select.level02').empty();
                $('select.level02').append("<option value='0'>请选择分类</option>");
                return;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"/zcjy/childCategories/"+$('select.level01').val(),
                type:"GET",
                data:'',
                success: function(data) {
                    $('select.level02').empty();
                    $('select.level02').append("<option value='0'>请选择分类</option>");
                    for (var i = data.length - 1; i >= 0; i--) {
                        $('select.level02').append("<option value='"+data[i].id+"'>"+data[i].name+"</option>");
                    }
                },
                error: function(data) {
                  //提示失败消息
                    
                },
            });
        })

        $('.level02').on('change', function(){

            var newParentID = $('select.level02').val();
            if (newParentID == 0) {
                $('select.level03').empty();
                $('select.level03').append("<option value='0'>请选择分类</option>");
                return;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"/zcjy/childCategories/"+$('select.level02').val(),
                type:"GET",
                data:'',
                success: function(data) {
                    $('select.level03').empty();
                    $('select.level03').append("<option value='0'>请选择分类</option>");
                    for (var i = data.length - 1; i >= 0; i--) {
                        $('select.level03').append("<option value='"+data[i].id+"'>"+data[i].name+"</option>");
                    }
                },
                error: function(data) {
                  //提示失败消息
                    
                },
            });
        })
            */
        $('button .btn-box-tool').trigger('click');
    </script>
@endsection
