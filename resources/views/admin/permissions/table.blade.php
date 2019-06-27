<table class="table table-responsive" >
    <thead>
        <th>显示名称</th>
        <th>所属模块</th>
        <th>所属组</th>
        <th>路由</th>
      {{--   <th>图标</th> --}}
        <th>说明</th>
    {{--     <th>是否菜单</th>
        <th colspan="3">操作</th> --}}
        <th>是否有此权限</th>
    </thead>
    <tbody>
    @foreach($pemissions_list as $perm)
        <tr>
            <td>{!! $perm->display_name !!}</td>
            <td>{!! $perm->model !!}</td>
            <td>{!! $perm->GroupFunc !!}</td>
            <td>{!! $perm->name !!}</td>
         {{--    <td>{!! $perm->IconHtml !!}</td> --}}
            <td>{!! $perm->description !!}</td>
            <td data-permid="{!! $perm->id !!}"> {!! varifyAdminPermByRouteName($perm->name)?'<span class="label label-success" onclick="permAddOrDel(this,false)">是</span>':'<span class="label label-danger" onclick="permAddOrDel(this,true)">否</span>' !!}</td>
        {{--     <td>{!! $perm->IsMenus !!}</td> --}}
          {{--   <td>
                {!! Form::open(['route' => ['permissions.destroy', $perm->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('permissions.show', [$role->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> 
                    <a href="javascript:;" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td> --}}
        </tr>
    @endforeach
    </tbody>
</table>