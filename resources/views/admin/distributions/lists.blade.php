@extends('admin.layouts.app_distribution')

@section('content')
    <section class="content-header">
        <h1 class="pull-left mb15">分销商列表</h1>
    </section>
    <div class="content pdall0-xs">
        <div class="clearfix"></div>

        @include('admin.partials.message')

        <div class="clearfix"></div>
        <div class="box box-primary mb10-xs">
            <div class="box-body">
                <table class="table table-responsive">
                    <thead>
                        <th>编号</th>
                        <th>微信昵称</th>
                        <th>手机号</th>
                        <th>可用资金</th>
                        <th>总赏金</th>
                        <th class="hidden-xs">一级会员数</th>
                        <th class="hidden-xs">二级会员数</th>
                        <th class="hidden-xs">三级会员数</th>
                        <th colspan="3">操作</th>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->nickname}}</td>
                            <td>{{$user->mobile}}</td>
                            <td>{{$user->user_money}}</td>
                            <td>{{$user->distribut_money}}</td>
                            <td class="hidden-xs">{{$user->level1}}</td>
                            <td class="hidden-xs">{{$user->level2}}</td>
                            <td class="hidden-xs">{{$user->level3}}</td>
                            <td><a href="/zcjy/users/{{$user->id}}">查看详情</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tc"><?php echo $users->render(); ?></div>
    </div>
@endsection

