<table class="table table-responsive" id="singelPages-table">
    <thead>
        <tr>
        <th>名称</th>
        <th>别名</th>
        <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($singelPages as $singelPage)
        <tr>
            <td>{!! $singelPage->name !!}</td>
            <td>{!! $singelPage->slug !!}</td>
            <td>
                {!! Form::open(['route' => ['singelPages.destroy', $singelPage->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                {{--     <a href="{!! route('singelPages.show', [$singelPage->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{!! route('singelPages.edit', [$singelPage->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {{-- {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!} --}}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>