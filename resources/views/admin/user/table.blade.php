<table class="table table-responsive" id="users-table">
    <thead>
        <tr>
            <th class="hidden-xs">会员ID</th>
            <th>昵称</th>
            <th>成长值</th>
            @if (funcOpen('FUNC_MEMBER_LEVEL'))
            <th>会员等级</th>
            @endif

            <th>累计消费</th>

            @if (funcOpen('FUNC_FUNDS'))
            <th class="hidden-xs">余额</th>
            @endif

            @if (funcOpen('FUNC_CREDITS'))
            <th class="hidden-xs">积分</th>
            @endif

            @if (funcOpen('FUNC_DISTRIBUTION'))
            <th class="hidden-sm hidden-xs">分销</th>
            <th class="hidden-sm hidden-xs">一级代理人数</th>
            <th class="hidden-sm hidden-xs">二级代理人数</th>
            <th class="hidden-sm hidden-xs">三级代理人数</th>
            @endif

            <th>手机</th>
            <th>注册日期</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td class="hidden-xs">{!! $user->id !!}</td>
            <td>{!! $user->nickname !!}</td>
            <td>{!! $user->growth   !!}</td>
            @if (funcOpen('FUNC_MEMBER_LEVEL'))
            <td>{!! $user->level->name !!}</td>
            @endif

            <td>{!! $user->consume_total !!}</td>

            @if (funcOpen('FUNC_FUNDS'))
            <td class="hidden-xs">{!! $user->user_money !!}</td>
            @endif
            
            @if (funcOpen('FUNC_CREDITS'))
            <td class="hidden-xs">{!! $user->credits !!}</td>
            @endif
            
            @if (funcOpen('FUNC_DISTRIBUTION'))
            <td><span class="btn label label-{!! $user->is_distribute ? 'success' : 'warning' !!}" onclick="distributeUser(this,{!! $user->id !!})">{!! $user->is_distribute?'分销用户':'无分销资格' !!}</span></td>
            <td class="hidden-sm hidden-xs">{!! $user->level1 !!}</td>
            <td class="hidden-sm hidden-xs">{!! $user->level2 !!}</td>
            <td class="hidden-sm hidden-xs">{!! $user->level3 !!}</td>
            @endif
            
            <td>{!! $user->mobile !!}</td>
            <td>{!! $user->created_at !!}</td>
            <td>

                <a href="{!! route('users.show', [$user->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i>查看</a>
                <a href="javascript:;" class='btn btn-default btn-xs authMessage' data-name="{{ $user->nickname }}" data-id="{{ $user->id }}"><i class="
glyphicon glyphicon-envelope"></i>消息</a>
                <div class='btn-group'>
                 
                <!--span class="btn label label-{!! $user->status?'danger':'success' !!}" onclick="freezeUser(this,{!! $user->id !!})">{!! $user->status?'取消冻结':'冻结用户' !!}</span>
                </div-->

            </td>
        </tr>
    @endforeach
    </tbody>
</table>