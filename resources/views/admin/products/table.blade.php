<table class="table table-responsive" id="products-table">
    <thead>
        <th>ID</th>
        <th>名称</th>
        <th>适用于</th>
        <th>分类</th>
        <th>价格</th>
        <th class="hidden-xs">热销</th>
        <th class="hidden-sm hidden-xs">新品</th>
        <th class="hidden-xs">上架</th>

    {{--     <th class="hidden-xs">库存</th> --}}
        <th class="hidden-xs">促销</th>
        <th class="hidden-sm hidden-xs">排序</th>
        <th width="120" class="hidden-sm">操作</th>
        <th class="visible-sm">操作</th>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr>
            <td>{!! $product->id !!}</td>
            <td>{!! $product->name !!}</td>
            <td >@if(!empty($product->shop_id)) 适用于 {!! a_link(shop($product->shop_id)->name,'javascript:;') !!} @endif</td>
            <td>{!! $product->Cat !!}</td>
            <td>{!! $product->price !!}</td>
            <td class="hidden-xs">@if($product->hot == '是') <span class="label label-success">是</span> @else 否 @endif</td>
            <td class="hidden-sm hidden-xs">@if($product->new == '是') <span class="label label-success">是</span> @else 否 @endif</td>
            <td class="hidden-xs">@if($product->isShelf == '是') 是 @else <span class="label label-warning">否</span>  @endif</td>
            <td class="hidden-xs">{!! varifyCuXiao($product->prom_type) !!}</td>
            <td class="hidden-sm hidden-xs">{!! $product->sort !!}</td>
            <td>
                {!! Form::open(['route' => ['products.destroy', $product->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                {{--     a href="{!! route('front.mobile.product', [$product->id]) !!}" class='btn btn-default btn-xs' target="_blank"><i class="glyphicon glyphicon-eye-open"></i></a --}}
                    <a href="{!! route('products.edit', [$product->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>

        <?php $services = $product->services()->orderBy('id','asc')->get();?>
        @if(count($services))
            @foreach ($services as $service)
                    <tr>
                        <td></td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{ route('services.edit', [$service->id]) }}" target="_blank">{!! $service->name !!}</a>(服务数量<strong>{!! tag($service->pivot->num) !!}</strong>)</td>
                    </tr>
            @endforeach
        @endif
    @endforeach
    </tbody>
</table>


