@extends('admin.layouts.app_shop')

@section('content')
    @include('admin.partials.message')
    <div class="container-fluid" style="padding: 30px 15px;">
        <div class="row">
            <div class="col-sm-3 col-lg-2">
                <ul class="nav nav-pills nav-stacked nav-email">
                    <li class="{{ Request::is('zcjy/users*') ? 'active' : '' }}">
                        <a href="{!! route('users.index') !!}">
                            <span class="badge pull-right"></span>
                            <i class="fa fa-user"></i> 会员列表
                        </a>
                    </li>
                    <li class="{{ Request::is('zcjy/userLevels*') ? 'active' : '' }}">
                        <a href="{!! route('userLevels.index') !!}">
                            <span class="badge pull-right"></span>
                            <i class="fa fa-users"></i> 会员等级
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-sm-9 col-lg-10">
                <section class="content-header mb10-xs">
                    <h1 class="pull-left">用户等级列表</h1>
                    <h1 class="pull-right">
                       <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('userLevels.create') !!}">添加</a>
                    </h1>
                </section>
                <div class="content pdall0-xs">
                    <div class="clearfix"></div>

                    @include('admin.partials.message')

                    <div class="clearfix"></div>
                    <div class="box box-primary mb10-xs">
                        <div class="box-body">
                                @include('admin.user_levels.table')
                        </div>
                    </div>
                    <div class="text-center">
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

