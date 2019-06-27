<table class="table table-responsive" id="teamFollows-table">
    <thead>
        <tr>
            <th>User Id</th>
        <th>Nickname</th>
        <th>Head Pic</th>
        <th>Order Id</th>
        <th>Found Id</th>
        <th>Found User Id</th>
        <th>Team Id</th>
        <th>Status</th>
        <th>Is Winner</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($teamFollows as $teamFollow)
        <tr>
            <td>{!! $teamFollow->user_id !!}</td>
            <td>{!! $teamFollow->nickname !!}</td>
            <td>{!! $teamFollow->head_pic !!}</td>
            <td>{!! $teamFollow->order_id !!}</td>
            <td>{!! $teamFollow->found_id !!}</td>
            <td>{!! $teamFollow->found_user_id !!}</td>
            <td>{!! $teamFollow->team_id !!}</td>
            <td>{!! $teamFollow->status !!}</td>
            <td>{!! $teamFollow->is_winner !!}</td>
            <td>
                {!! Form::open(['route' => ['teamFollows.destroy', $teamFollow->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('teamFollows.show', [$teamFollow->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('teamFollows.edit', [$teamFollow->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>