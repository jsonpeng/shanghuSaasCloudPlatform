@extends('admin.layouts.app_shop')
<!--商品多选-->
@section('content')
<section class="content-header mb10-xs">
    <h1 class="pull-left">产品列表</h1>
    <div>(共{!! $product_num !!}条记录)</div>
</section>

<div class="content pdall0-xs">
    <div class="clearfix"></div>
    <div class="box box-default box-solid mb10-xs {!! !$tools?'collapsed-box':'' !!}">
        <div class="box-header with-border">
            <h3 class="box-title">查询</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"> <i class="fa fa-{!! !$tools?'plus':'minus' !!}"></i>
                </button>
            </div>
            <!-- /.box-tools --> </div>
        <!-- /.box-header -->
        <div class="box-body">
            <form id="order_search">

                <div class="form-group col-md-4">
                    <label for="order_pay">所有产品分类</label>
                    <div class="row">
                        <div class="col-md-4 col-xs-4 pr0-xs">
                            {!! Form::select('cat_level01',$cats, $level01 , ['class' => 'form-control level01']) !!}
                        </div>
                        <div class="col-md-4 col-xs-4 pr0-xs">
                            {!! Form::select('cat_level02',$second_cats,$level02 , ['class' => 'form-control level02']) !!}
                        </div>
                        <div class="col-md-4 col-xs-4">
                            {!! Form::select('cat_level03', $third_cats, $level03 , ['class' => 'form-control level03']) !!}
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-2">
                    <label for="order_delivery">产品名称</label>
                    <input type="text" class="form-control" name="keywords" placeholder="产品名称" @if (array_key_exists('keywords', $input))value="{{$input['keywords']}}"@endif></div>

                <div class="form-group col-md-1 hidden-xs hidden-sm" style="padding-top: 25px;">
                    <button type="submit" class="btn btn-primary pull-right" >查询</button>
                </div>

                <div class="form-group col-md-1 visible-xs visible-sm" >
                    <button type="submit" class="btn btn-primary pull-left" >查询</button>
                </div>
            </form>
        </div>
        <!-- /.box-body --> </div>
    <!-- /.box -->

    <div class="clearfix"></div>
    <div class="box box-primary">
        <div class="box-body">
            <table class="table table-responsive" id="products-table">
                <thead>
                  {{--   <th>
                        <div>
                            <input type="checkbox" class="checkAll"></div>
                    </th> --}}
                    <th>产品名称</th>
                    <th>规格</th>
                    <th class="hidden-xs">价格</th>
                    <th>库存</th>
                </thead>
                <tbody id="products-tbody">
                    @foreach($product as $item)
                    <?php $items=$item->
                    specs;?>
                @if(count($items)>0)
                    <!--有商品规格的商品-->
                    @foreach($items as $item)
                    <tr data-productid="{!! $item->
                        product()->first()->id !!}" data-specid="{!! $item->id !!}" data-productname="{!! $item->product()->first()->name !!}" data-price="{!! $item->price !!}" data-keyname="{!! $item->key_name !!}" data-prom="{!! $item->prom_type==0?'false':'true' !!}">
                     {{--    <td></td> --}}
                        <td>
                            @if(!empty($item->prom_type)) <strong style="color: red">[ @if($item->prom_type=='1')秒杀抢购中@endif @if($item->prom_type==2)团购中@endif @if($item->prom_type==3)促销中@endif @if($item->prom_type==4)订单促销中@endif @if($item->prom_type==5)拼团中@endif ]</strong> 
                            @endif <a href="{!! route('products.edit',[$item->
                        product()->first()->id])!!}?spec=true" target="_blank">{!! $item->product()->first()->name !!}</a>
                        </td>
                        <td>{!! $item->key_name !!}</td>
                        <td class="hidden-xs">{!! $item->price !!}</td>
                        <td><small class="label label-danger">警: {!! $item->inventory !!}</small></td>
                    </tr>
                    @endforeach
                @else
                    <tr data-productid="{!! $item->
                        id !!}" data-specid="0" data-productname="{!! $item->name !!}" data-price="{!! $item->price !!}" data-keyname="--" data-prom="{!! empty($item->prom_type)?'false':'true' !!}">
                      {{--   <td></td> --}}
                        <td>
                            @if(!empty($item->prom_type)) <strong style="color: red">[ @if($item->prom_type=='1')秒杀抢购中@endif @if($item->prom_type==2)团购中@endif @if($item->prom_type==3)促销中@endif @if($item->prom_type==4)订单促销中@endif @if($item->prom_type==5)拼团中@endif ]</strong> 
                            @endif <a href="{!! route('products.edit',[$item->id])!!}" target="_blank">{!! $item->name !!}</a>
                        </td>
                        <td>--</td>
                        <td class="hidden-xs">{!! $item->price !!}</td>
                        <td><small class="label label-danger">警: {!! $item->inventory !!}</small></td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>

        </div>
       {{--  <div class="pull-left" style="margin-top:15px;">
            <input type="button" class="btn btn-success"  value="确定" id="product_enter"></div> --}}
    </div>
    <div class="tc">
        <?php echo $products->appends($input)->render(); ?></div>
</div>
@endsection


@section('scripts')


@endsection