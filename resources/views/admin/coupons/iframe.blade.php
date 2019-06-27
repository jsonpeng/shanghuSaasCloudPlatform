@extends('admin.layouts.app_tem')

@section('content')
<section class="content-header mb10-xs">
    <h1 class="pull-left">优惠券列表</h1>
    <div>(共{!! $counpons_num !!}条记录)</div>
</section>

<div class="content pdall0-xs">
    <div class="clearfix"></div>
    <div class="box box-default box-solid mb10-xs">
        <div class="box-header with-border">
            <h3 class="box-title">查询</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
            <!-- /.box-tools --> </div>
        <!-- /.box-header -->
        <div class="box-body">
            <form id="service_search" action="">

                <div class="form-group col-md-2">
                    <label for="order_delivery">优惠券名称</label>
                    <input type="text" class="form-control" name="name" placeholder="优惠券名称" @if (array_key_exists('name', $input))value="{{$input['name']}}"@endif></div>
                <div class="form-group col-md-1" style="padding-top: 25px;">
                    <button type="submit" class="btn btn-primary pull-right">查询</button>
                </div>
            </form>
        </div>
        <!-- /.box-body --> </div>
    <!-- /.box -->

    <div class="clearfix"></div>
    <div class="box box-primary">
        <div class="box-body">
           <table class="table table-responsive" id="coupons-table">
                <thead>
                    <th>编号</th>
                    <th>名称</th>
                    <th class="hidden-xs">最低消费金额</th>
                    <th>类型</th>
                    <th>优惠</th>
                    <th class="hidden-sm hidden-xs">有效期(起)</th>
                    <th class="hidden-sm hidden-xs">有效期(止)</th>
                    <th class="hidden-xs">适用范围</th>
                 
                </thead>
                <tbody id="coupons-tbody">
                @foreach($coupons as $coupon)
                    <tr data-name="{{ $coupon->name }}" data-id="{{ $coupon->id }}">
                        <td>{!! $coupon->id !!}</td>
                        <td>{!! $coupon->name !!}</td>
                        <td class="hidden-xs">{!! $coupon->base !!}</td>
                        <td>{!! $coupon->type !!}</td>
                        <td>
                            @if ($coupon->type == '满减')
                            优惠{!! $coupon->given !!}元
                            @elseif ($coupon->type == '打折')
                            打{!! $coupon->discount !!}折
                            @endif
                        </td> 
                        <td class="hidden-sm hidden-xs">
                            @if ($coupon->time_type == 0)
                            {!! $coupon->time_begin->format('Y-m-d') !!}
                            @else
                            领券当日
                            @endif
                        </td>
                        <td class="hidden-sm hidden-xs">
                            @if ($coupon->time_type == 0)
                            {!! $coupon->time_end->format('Y-m-d') !!}
                            @else
                            领券后{!! $coupon->expire_days !!}天
                            @endif
                        </td>
                        <td class="hidden-xs">@if($coupon->range == 0) 全场通用 @elseif($coupon->range == 1) 指定分类 @else 指定商品 @endif</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
         <div class="pull-left" style="margin-top:15px;">
            <input type="button" class="btn btn-primary"  value="确定" id="product_enter"></div>
    </div>
    <div class="tc">
        <?php echo $coupons->appends($input)->links(); ?>
    </div>
</div>
@endsection


@section('scripts')
<script type="text/javascript">
        //多选服务
        $('#coupons-tbody >tr').click(function(){
                $('#coupons-tbody >tr').each(function(){
                    if($(this).hasClass('trSelected')){
                    
                         $(this).removeClass('trSelected');
                     

                    }
                });
               $(this).toggleClass('trSelected');
        });
        //确定
        $('#product_enter').click(function(){
            var selected=$('#coupons-tbody >tr').hasClass('trSelected');
            if(!selected){
               layer.alert('请选择优惠券', {icon: 2}); 
               return false;
            }
            $('#coupons-tbody >tr').each(function(){
                if(!$(this).hasClass('trSelected')){
                    $(this).remove();
                }
            });
            var tabHtml=$('#coupons-tbody').html();
            console.log(tabHtml);
            var type =null;
            @if(array_key_exists('type',$input))
            type = {{ $input['type'] }};
            @endif
            javascript:window.parent.call_back_by_many_with_coupons(tabHtml,type);
        });
</script>
@endsection