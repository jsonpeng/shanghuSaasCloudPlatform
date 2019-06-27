<table class="table table-responsive" id="coupons-table">
    <thead>
        <th>编号</th>
        <th>名称</th>
        <th class="hidden-xs">最低消费金额</th>
        <th>类型</th>
        <th>优惠</th>
        <!--th class="hidden-sm hidden-xs">折扣</th>
        <th class="hidden-sm hidden-xs">有效期类型</th>
        <th class="hidden-sm hidden-xs">过期时长(天)</th-->
        <th class="hidden-sm hidden-xs">有效期(起)</th>
        <th class="hidden-sm hidden-xs">有效期(止)</th>
        <th class="hidden-xs">适用范围</th>
        <th colspan="3">操作</th>
    </thead>
    <tbody>
    @foreach($coupons as $coupon)
        <tr>
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

            <!--td class="hidden-sm hidden-xs">@if($coupon->time_type == 0) 固定有效日期 @else 领券后固定时间有效 @endif</td>
            <td class="hidden-sm hidden-xs">@if ($coupon->time_type == 1) {!! $coupon->expire_days !!} @endif</td-->
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
            <td>
                {!! Form::open(['route' => ['coupons.destroy', $coupon->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <!--a href="{!! route('coupons.show', [$coupon->id]) !!}" class='btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a-->
                    <a href="{!! route('coupons.edit', [$coupon->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>