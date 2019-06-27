<table class="table table-responsive" id="categories-table">
    <thead>
        <tr>
            <th>名称</th>
            <th>图像</th>
            <th>排序</th>
      
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
        <tr>
            <td>{!! $category->name !!}</td>
            <td>
                <img src="{{ asset($category->image) }}" style="height: 25px;"></td>
            <td>{!! $category->sort !!}</td>

            <td>
                {!! Form::open(['route' => ['articlecats.destroy', $category->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                {{--     <a href="{!! $baseurl !!}/cat/{!! $category->
                        id !!}" target="_blank" class='btn btn-default btn-xs'> <i class="glyphicon glyphicon-eye-open"></i>
                    </a> --}}
                    <a href="{!! route('articlecats.edit', [$category->
                        id]) !!}" class='btn btn-default btn-xs'> <i class="glyphicon glyphicon-edit"></i>
                    </a>
                    {!! Form::button('
                    <i class="glyphicon glyphicon-trash"></i>
                    ', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>