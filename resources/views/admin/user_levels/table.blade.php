<table class="table table-responsive" id="userLevels-table">
    <thead>
        <tr>
            <th>用户等级</th>
            <th>需要成长值</th>
            <th>折扣率</th>
            <th>描述</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($userLevels as $userLevel)
        <tr>
            <td>{!! $userLevel->name !!}</td>
            <td>{!! $userLevel->growth !!}</td>
            <td>{!! $userLevel->discount !!}</td>
            <td>{!! $userLevel->discribe !!}</td>
            <td>
                {!! Form::open(['route' => ['userLevels.destroy', $userLevel->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('userLevels.edit', [$userLevel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>