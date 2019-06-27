<table class="table table-responsive" id="minichats-table">
    <thead>
        <tr>
            <th>App Name</th>
        <th>App Id</th>
        <th>Access Token</th>
        <th>Expires</th>
        <th>Refresh Token</th>
        <th>Admin Id</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($minichats as $minichat)
        <tr>
            <td>{!! $minichat->app_name !!}</td>
            <td>{!! $minichat->app_id !!}</td>
            <td>{!! $minichat->access_token !!}</td>
            <td>{!! $minichat->expires !!}</td>
            <td>{!! $minichat->refresh_token !!}</td>
            <td>{!! $minichat->admin_id !!}</td>
            <td>
                {!! Form::open(['route' => ['minichats.destroy', $minichat->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('minichats.show', [$minichat->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('minichats.edit', [$minichat->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>