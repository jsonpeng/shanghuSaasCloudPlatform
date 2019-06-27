<table class="table table-responsive" id="managers-table">
    <thead>
        <th>名称</th>
        <th>手机号</th>
        <th>是否是会员</th>
        <th>创建时间</th>
        <th>到期时间</th>
        <th>管理店铺</th>
        <th colspan="3">操作</th>
    </thead>
    <tbody>
    @foreach($managers as $manager)
    <?php $shops = $manager->shops()->get(); ?>
    <tr>
        <td>{!! $manager->nickname !!}</td>
        <td>{!! $manager->mobile !!}</td>
        <td>{!! $manager->member ? '是' : '否' !!}</td>
        <td>{!! $manager->created_at !!}</td>
        <td>{!! $manager->member_end !!}</td>
        <td>@if(!empty($shops)) 
                @foreach ($shops as $shop)
                {!! a_link($shop->name,'/zcjy/storeShops/'.$shop->id.'/edit') !!}
                @endforeach 
            @endif</td>
        <td>
            {!! Form::open(['route' => ['shopBranchManagers.destroy', $manager->id], 'method' => 'delete']) !!}
            <div class='btn-group'>
           {{--      <a href="{!! http().$manager->account.'.'.domain('shop') !!}/index" target="_blank" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
 --}}
                <a href="{!! route('shopBranchManagers.edit', [$manager->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
              
               
           {{--      {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认删除吗?')"]) !!} --}}
            
            </div>
            {!! Form::close() !!}
        </td>
    </tr>
    @endforeach
    </tbody>
</table>