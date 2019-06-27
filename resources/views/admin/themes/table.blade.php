<table class="table table-responsive" id="themes-table">
    <thead>
        <th>专题名称</th>
        <th>副标题</th>
        <th>创建日期</th>
        <th>更新日期</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($themes as $theme)
        <tr>
            <td>{!! $theme->title !!}</td>
            <td>{!! $theme->subtitle !!}</td>
            <td>{!! $theme->created_at !!}</td>
            <td>{!! $theme->updated_at !!}</td>
            <td>
                {!! Form::open(['route' => ['themes.destroy', $theme->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('themes.edit', [$theme->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>