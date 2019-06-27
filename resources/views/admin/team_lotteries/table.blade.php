<table class="table table-responsive" id="teamLotteries-table">
    <thead>
        <tr>
            <th>User Id</th>
        <th>Order Id</th>
        <th>Mobile</th>
        <th>Team Id</th>
        <th>Nickname</th>
        <th>Head Pic</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($teamLotteries as $teamLottery)
        <tr>
            <td>{!! $teamLottery->user_id !!}</td>
            <td>{!! $teamLottery->order_id !!}</td>
            <td>{!! $teamLottery->mobile !!}</td>
            <td>{!! $teamLottery->team_id !!}</td>
            <td>{!! $teamLottery->nickname !!}</td>
            <td>{!! $teamLottery->head_pic !!}</td>
            <td>
                {!! Form::open(['route' => ['teamLotteries.destroy', $teamLottery->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('teamLotteries.show', [$teamLottery->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('teamLotteries.edit', [$teamLottery->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>