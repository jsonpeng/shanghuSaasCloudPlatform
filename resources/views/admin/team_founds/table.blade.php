<table class="table table-responsive" id="teamFounds-table">
    <thead>
        <tr>
            <th>Name</th>
        <th>Time Begin</th>
        <th>Time End</th>
        <th>User Id</th>
        <th>Team Id</th>
        <th>Nickname</th>
        <th>Head Pic</th>
        <th>Order Id</th>
        <th>Join Num</th>
        <th>Need Mem</th>
        <th>Price</th>
        <th>Origin Price</th>
        <th>Status</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($teamFounds as $teamFound)
        <tr>
            <td>{!! $teamFound->name !!}</td>
            <td>{!! $teamFound->time_begin !!}</td>
            <td>{!! $teamFound->time_end !!}</td>
            <td>{!! $teamFound->user_id !!}</td>
            <td>{!! $teamFound->team_id !!}</td>
            <td>{!! $teamFound->nickname !!}</td>
            <td>{!! $teamFound->head_pic !!}</td>
            <td>{!! $teamFound->order_id !!}</td>
            <td>{!! $teamFound->join_num !!}</td>
            <td>{!! $teamFound->need_mem !!}</td>
            <td>{!! $teamFound->price !!}</td>
            <td>{!! $teamFound->origin_price !!}</td>
            <td>{!! $teamFound->status !!}</td>
            <td>
                {!! Form::open(['route' => ['teamFounds.destroy', $teamFound->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('teamFounds.show', [$teamFound->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('teamFounds.edit', [$teamFound->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>