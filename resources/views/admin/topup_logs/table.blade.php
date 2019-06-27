<table class="table table-responsive" id="topupLogs-table">
    <thead>
        <tr>
        <th>充值金额</th>
        <th>充值用户</th>
        <th>充值时间</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($topupLogs as $topupLog)
    <?php $user=$topupLog->user()->first();?>
        <tr>
            <td>{!! $topupLog->price !!}</td>
            <td>{!! a_link($user->nickname,'/zcjy/users/'.$user->id) !!}</td>
            <td>{!! $topupLog->created_at !!}</td>
            <td>
                {!! Form::open(['route' => ['topupLogs.destroy', $topupLog->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                {{--     <a href="{!! route('topupLogs.show', [$topupLog->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('topupLogs.edit', [$topupLog->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a> --}}
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>