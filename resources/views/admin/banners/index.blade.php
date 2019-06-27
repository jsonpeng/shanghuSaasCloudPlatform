@extends('admin.layouts.app')

@section('content')
    <section class="content-header mb10-xs">
        <h1 class="pull-left">横幅列表</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" href="{!! route('banners.create') !!}">添加</a>
        </h1>
    </section>
    <div class="content pdall0-xs">
        <div class="clearfix"></div>

        @include('admin.partials.message')

        <div class="clearfix"></div>
        <div class="box box-primary mb10-xs form">
            <div class="box-body">
                    @include('admin.banners.table')
            </div>
        </div>
    </div>
@endsection

