<table class="table table-responsive" id="managers-table">
    <thead>
        <th>名称</th>
        <th>手机号</th>
        @if($input['type'] == '商户')
        <th>是否是会员</th>
        @endif
        <th>创建时间</th>
        @if($input['type'] == '商户')
        <th>到期时间</th>
        @endif
        <th colspan="3">操作</th>
    </thead>
    <tbody>
    @foreach($managers as $manager)
    <tr>
        <td>{!! $manager->nickname !!}</td>
        <td>{!! $manager->mobile !!}</td>
        @if($input['type'] == '商户')
        <td>{!! $manager->member ? '是' : '否' !!}</td>
        @endif
        <td>{!! $manager->created_at !!}</td>
        @if($input['type'] == '商户')
        <td>{!! $manager->member_end !!}</td>
        @endif
        <td>
            {!! Form::open(['route' => ['shopManagers.destroy', $manager->id], 'method' => 'delete']) !!}
            <div class='btn-group'>
                @if($input['type'] == '商户')
                    <a href="{!! http().$manager->account.'.'.domain('shop') !!}/index" target="_blank" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                @endif

                <a href="{!! route('shopManagers.edit', [$manager->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
              
               
           {{--      {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认删除吗?')"]) !!} --}}
            
            </div>
            {!! Form::close() !!}
        </td>
    </tr>
    @endforeach
    </tbody>
</table>