<table class="table table-responsive" id="managers-table">
    <thead>
        <th>名称</th>
        <th>手机号</th>
        @if($input['type'] == '代理商') 
        <th>account<span class="bitian">(标识):</span></th>
        @endif
        <th>创建时间</th>
        <th>更新时间</th>
        <th colspan="3">操作</th>
    </thead>
    <tbody>
    @foreach($managers as $manager)
    <tr>
        <td>{!! $manager->nickname !!}</td>
        <td>{!! $manager->mobile !!}</td>
        @if($input['type'] == '代理商') 
        <td>{!! $manager->account !!}</td>
        @endif
        <td>{!! $manager->created_at !!}</td>
        <td>{!! $manager->updated_at !!}</td>
        <td>
        @if($manager->id != 1)
            {!! Form::open(['route' => ['managers.destroy', $manager->id], 'method' => 'delete']) !!}
            <div class='btn-group'>
                @if($input['type'] == '代理商')
                <a href="{!! http().$manager->account.'.'.domain('proxy') !!}/index" target="_blank" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                @endif

                <a href="{!! route('managers.edit', [$manager->id]).'?type='.$input['type'] !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
               
              {{--   {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认删除吗?')"]) !!} --}}
            
            </div>
            {!! Form::close() !!}
        @endif
        </td>
    </tr>
    @endforeach
    </tbody>
</table>