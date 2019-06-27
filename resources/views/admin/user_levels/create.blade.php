@extends('admin.layouts.app_shop')

@section('content')
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
                <div class="content pdall0-xs">
                    @include('adminlte-templates::common.errors')
                    <div class="box box-primary form mb10-xs">

                        <div class="box-body">
                            <div class="row">
                                {!! Form::open(['route' => 'userLevels.store']) !!}

                                    @include('admin.user_levels.fields')

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
