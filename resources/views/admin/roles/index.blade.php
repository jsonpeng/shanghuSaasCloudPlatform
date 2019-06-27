@extends('admin.layouts.app')

@section('content')
<div class="container-fluid" style="padding: 30px 15px;">
    <div class="row">
        <div class="col-sm-3 col-lg-2">
            <ul class="nav nav-pills nav-stacked nav-email">
                <li class="{{ Request::is('zcjy/managers*') ? 'active' : '' }}">
                    <a href="{!! route('managers.index') !!}">
                        <span class="badge pull-right"></span>
                        <i class="fa fa-user"></i> 管理员设置
                    </a>
                </li>
                <li class="{{ Request::is('zcjy/roles*') ? 'active' : '' }}">
                    <a href="{!! route('roles.index') !!}">
                        <span class="badge pull-right"></span>
                        <i class="fa fa-users"></i> 角色设置
                    </a>
                </li>
                <li class="{{ Request::is('zcjy/permissions*') ? 'active' : '' }}">
                    <a href="{!! route('permissions.index') !!}">
                        <span class="badge pull-right"></span>
                        <i class="fa fa-key"></i> 权限设置
                    </a>
                </li>
            </ul>
        </div>

        <div class="col-sm-9 col-lg-10">
            <section class="content-header">
                <h1 class="pull-left">角色管理</h1>
                <h1 class="pull-right">
                   <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('roles.create') !!}">新增</a>
                </h1>
            </section>
            <div class="content">
                <div class="clearfix"></div>

                @include('admin.partials.message')

                <div class="clearfix"></div>
                <div class="box box-primary">
                    <div class="box-body">
                            @include('admin.roles.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

