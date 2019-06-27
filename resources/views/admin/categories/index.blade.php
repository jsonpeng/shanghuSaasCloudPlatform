@extends('admin.layouts.app_shop')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">分类列表</h1>
        <h1 class="pull-right">
            <a class="btn btn-primary pull-right" style="margin-bottom: 5px" href="{!! route('categories.create') !!}">添加分类</a>
        </h1>
    </section>
    <div class="content pdall0-xs">
        <div class="clearfix"></div>

        @include('admin.partials.message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('admin.categories.table')
            </div>
        </div>
    </div>
@endsection

