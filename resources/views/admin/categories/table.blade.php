<table class="table table-responsive" id="categories-table">
    <thead>
        <th>名称</th>
        <th class="hidden-xs">别名</th>
        <th class="hidden-xs">排序</th>
        <th>图片</th>
       {{--  <th class="hidden-xs">推荐</th> --}}
        <th>状态</th>
        <!--th>上级分类</th-->
        <th colspan="3" class="hidden-xs">操作</th>
        <th class="visible-xs">操作</th>
    </thead>
    <tbody>
    @foreach($categories as $category)
        <tr>
            <td>@for ($i = 1; $i < $category->level; $i++) &nbsp;&nbsp;&nbsp;&nbsp; @endfor {!! $category->name !!}</td>
            <td class="hidden-xs">{!! $category->slug !!}</td>
            <td class="hidden-xs">{!! $category->sort !!}</td>
            <td> <img src="{!! $category->image !!}" style="max-width: 100%; max-height: 25px;"> </td>
         {{--    <td class="hidden-xs"> @if($category->recommend == 1) <span class="label label-success">是</span> @else 否 @endif</td> --}}
            <td>  <span class="btn btn-{!! $category->status=='上线'?'success':'danger' !!} btn-xs" >{!! $category->status !!}</span></td>
            <td>
                {!! Form::open(['route' => ['categories.destroy', $category->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('categories.edit', [$category->id]) !!}" class='btn btn-default btn-xs' title="编辑"><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'title' => '删除', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认要删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>