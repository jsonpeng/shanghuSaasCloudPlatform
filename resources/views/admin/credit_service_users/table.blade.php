<table class="table table-responsive" id="creditServiceUsers-table">
    <thead>
        <tr>
        <th>订单编号</th>
        <th>积分产品</th>
        <th>积分产品类型</th>
        <th>兑换人</th>
        <th>当前状态</th>
        <th>自提/使用时间</th>
        <th>自提/使用店铺</th>
     {{--        <th colspan="3">Action</th> --}}
        </tr>
    </thead>
    <tbody>
    @foreach($creditServiceUsers as $creditServiceUser)
        <tr>
            <td>{!! $creditServiceUser->snumber !!}</td>
            <td>{!! !empty($creditServiceUser->creditservice()->first()) ? $creditServiceUser->creditservice()->first()->name : '' !!}</td>
              <td>{!! !empty($creditServiceUser->creditservice()->first()) ? $creditServiceUser->creditservice()->first()->type : '' !!}</td>
            <td>{!! !empty($creditServiceUser->user()->first()) ? $creditServiceUser->user()->first()->nickname : '' !!}</td>
            <td>{!! $creditServiceUser->status !!}</td>
            <td>{!! $creditServiceUser->pick_time !!}</td>
            <td>{!! $creditServiceUser->pick_shop_id !!}</td>
     {{--        <td>
                {!! Form::open(['route' => ['creditServiceUsers.destroy', $creditServiceUser->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('creditServiceUsers.show', [$creditServiceUser->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('creditServiceUsers.edit', [$creditServiceUser->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td> --}}
        </tr>
    @endforeach
    </tbody>
</table>