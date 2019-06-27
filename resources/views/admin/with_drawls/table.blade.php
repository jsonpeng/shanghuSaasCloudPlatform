<table class="table table-responsive" id="withDrawls-table">
    <thead>
        <tr>
        <th>单号</th>
        <th>操作用户</th>
        <th>类型</th>
        <th>交易金额</th>
        <th>交易状态</th>
        <th>预计到账时间</th>
        <th>临时余额</th>
        <th>银行卡名称</th>
        <th>银行卡号</th>
        <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($withDrawls as $withDrawl)
        <tr>
            <td>{!! $withDrawl->no !!}</td>
            <td>{!! $withDrawl->UserName !!}</td>
            <td>{!! $withDrawl->type !!}</td>
            <td>{!! $withDrawl->price !!}</td>
            <td>{!! $withDrawl->status !!}</td>
            <td>{!! $withDrawl->arrive_time !!}</td>
            <td>{!! $withDrawl->account_tem !!}</td>
            <td>{!! $withDrawl->card_name !!}</td>
            <td>{!! $withDrawl->card_no !!}</td>
            <td>
                {!! Form::open(['route' => ['withDrawls.destroy', $withDrawl->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
              {{--       <a href="{!! route('withDrawls.show', [$withDrawl->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{!! route('withDrawls.edit', [$withDrawl->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>