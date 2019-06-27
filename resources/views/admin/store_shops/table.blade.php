<table class="table table-responsive" id="storeShops-table">
    <thead>
        <tr>
        <th>店铺名称</th>
        <th>地址</th>
        <th>经度</th>
        <th>纬度</th>
        <th>客服电话</th>
        <th>店铺logo</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($storeShops as $storeShop)
        <tr>
            <td>{!! $storeShop->name !!}</td>
            <td>{!! $storeShop->address !!}</td>
            <td>{!! $storeShop->jindu !!}</td>
            <td>{!! $storeShop->weidu !!}</td>
            <td>{!! $storeShop->tel !!}</td>
            <td>{!! $storeShop->logo !!}</td>
            <td>
                {!! Form::open(['route' => ['storeShops.destroy', $storeShop->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                {{--     <a href="{!! route('storeShops.show', [$storeShop->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{!! route('storeShops.edit', [$storeShop->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>