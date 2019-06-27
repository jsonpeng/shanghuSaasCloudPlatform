<table class="table table-responsive" id="packageLogs-table">
    <thead>
        <tr>
        <th>套餐名称</th>
        <th>套餐金额</th>
        <th>实付金额</th>
        <th>购买商户</th>
        <th>类型</th>
        <th>一级分佣代理商</th>
        <th>二级分佣代理商</th>
        <th>一级分佣金额</th>
        <th>二级级分佣金额</th>
        <th>状态</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($packageLogs as $packageLog)
        <tr>
            <td>{!! $packageLog->package_name !!}</td>
            <td>{!! $packageLog->price !!}</td>
            <td>{!! $packageLog->pay_price !!}</td>
            <td>{!! $packageLog->admin()->first()->nickname !!}</td>
            <td>{!! $packageLog->type !!}</td>
            <td>{!! $packageLog->distribution_one !!}</td>
            <td>{!! $packageLog->distribution_two !!}</td>
            <td>{!! $packageLog->bonus_one !!}</td>
            <td>{!! $packageLog->bonus_two !!}</td>
            <td>{!! $packageLog->status !!}</td>
            <td>
                {!! Form::open(['route' => ['packageLogs.destroy', $packageLog->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
           {{--          <a href="{!! route('packageLogs.show', [$packageLog->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('packageLogs.edit', [$packageLog->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a> --}}
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>