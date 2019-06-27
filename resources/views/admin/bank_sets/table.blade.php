<table class="table table-responsive" id="bankSets-table">
    <thead>
        <tr>
        <th>银行卡名称</th>
        <th>图片</th>
        <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($bankSets as $bankSets)
        <tr>
            <td>{!! $bankSets->name !!}</td>
            <td><img src="{{ $bankSets->img }}" style="max-width: 100%; max-height: 50px; display: block;"></td>
            <td>
                {!! Form::open(['route' => ['bankSets.destroy', $bankSets->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('bankSets.show', [$bankSets->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('bankSets.edit', [$bankSets->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>