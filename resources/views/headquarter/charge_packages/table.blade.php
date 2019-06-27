<table class="table table-responsive" id="chargePackages-table">
    <thead>
        <tr>
        <th>套餐名称</th>
{{--         <th>首购/续费</th> --}}
        <th>适用店铺数量</th>
    {{--     <th>会员时长(天)</th>
        <th>代理商分润</th> --}}
        <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($chargePackages as $chargePackage)
        <tr>
            <td>{!! $chargePackage->name !!}</td>
      {{--       <td>{!! $chargePackage->type !!}</td> --}}
            <td>{!! $chargePackage->canuse_shop_num !!}</td>
 {{--            <td>{!! $chargePackage->days !!}</td> --}}
    {{--         <td>{!! $chargePackage->bonus !!}</td> --}}
            <td>
                {!! Form::open(['route' => ['chargePackages.destroy', $chargePackage->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                   {{--  <a href="{!! route('chargePackages.show', [$chargePackage->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{!! route('chargePackages.edit', [$chargePackage->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定要删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
        <?php $prices = $chargePackage->prices()->orderBy('years','asc')->get(); ?>

        @if(count($prices))
            @foreach ($prices as $item)
                <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;{!!  $item->years.'年收费'.tag($item->price).',一级代理商分润'.tag($item->bonus_one).'二级代理商分润'.tag($item->bonus_two) !!} </td></tr>
            @endforeach
        @endif

    @endforeach
    </tbody>
</table>