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
                    <h1 class="pull-left">权限管理</h1>
                    <h1 class="pull-right">
                       <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('permissions.create') !!}">新增</a>
                    </h1>
                </section>
                <div class="clearfix"></div>
                <div class="content">
                        <div class="box box-default box-solid mb10-xs {!! !$tools?'collapsed-box':'' !!}" style="margin-top: 15px;">
                    <div class="box-header with-border">
                        <h3 class="box-title">查询</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"> <i class="fa fa-{!! !$tools?'plus':'minus' !!}"></i>
                            </button>
                        </div>
                        <!-- /.box-tools --> </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form id="order_search">

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <label for="nickname">显示名称</label>
                                <input type="text" class="form-control" name="display_name" placeholder="显示名称" @if (array_key_exists('display_name', $input))value="{{$input['display_name']}}"@endif></div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-6 col-xs-6">
                                <label for="price_sort">所属模块</label>
                                <select class="form-control" name="model">
                                    <option value="" @if (!array_key_exists('model', $input)) selected="selected" @endif>全部</option>
                                    <option value="系统" @if (array_key_exists('model', $input) && $input['model']=='系统') selected="selected" @endif>系统</option>
                                    <option value="商城" @if (array_key_exists('model', $input) && $input['model']=='商城') selected="selected" @endif>商城</option>
                                    <option value="促销" @if (array_key_exists('model', $input) && $input['model']=='促销') selected="selected" @endif>促销</option>
                                     <option value="分销" @if (array_key_exists('model', $input) && $input['model']=='分销') selected="selected" @endif>分销</option>
                                </select>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-6">
                                <label for="order_delivery">所属组</label>
                                <select class="form-control" name="group">
                                    <option value="" @if (!array_key_exists('group', $input)) selected="selected" @endif>全部</option>
                                    @foreach($group as $item)
                                    <option value="{!! $item['tid'] !!}" @if (array_key_exists('group', $input) && $input['group']==$item['tid'])) selected="selected" @endif>{!! $item['word'] !!}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <label for="mobile">路由</label>
                                <input type="text" class="form-control" name="name" placeholder="路由" @if (array_key_exists('name', $input))value="{{$input['name']}}"@endif></div>


                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <label for="order_delivery">类型</label>
                                <select class="form-control" name="type">
                                    <option value="" @if (!array_key_exists('type', $input)) selected="selected" @endif>全部</option>
                                    <option value="所有页面和操作" @if (array_key_exists('type', $input) && $input['type']=='所有页面和操作' ) selected="selected" @endif>所有页面和操作</option>
                                    <option value="页面" @if (array_key_exists('type', $input) && $input['type']=='页面' ) selected="selected" @endif>页面</option>
                                    <option value="操作" @if (array_key_exists('type', $input) && $input['type']=='操作' ) selected="selected" @endif>操作</option>
                            
                                </select>
                            </div>

                            <div class="form-group col-lg-1 col-md-1 hidden-xs hidden-sm" style="padding-top: 25px;">
                                <button type="submit" class="btn btn-primary pull-right " onclick="search()">查询</button>
                            </div>
                            <div class="form-group col-xs-6 visible-xs visible-sm" >
                                <button type="submit" class="btn btn-primary pull-left " onclick="search()">查询</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.box-body --> </div>
                <!-- /.box -->
                    <div class="clearfix"></div>

                    @include('admin.partials.message')

                    <div class="clearfix"></div>
                    <div class="box box-primary">
                        <div class="box-body">
                                @include('admin.permissions.table')
                        </div>
                    </div>
                    <div class="text-center">
                    <?php echo $pemissions_list->appends($input)->render(); ?></div>
                </div>
            </div>
        </div>
    </div>
@endsection


@include('admin.permissions.partials.js')

