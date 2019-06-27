@extends('admin.layouts.app')

@section('content')
    <section class="content-header mb10-xs">
        <h1 class="pull-left">{{$banner->name}}</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('bannerItems.create', [$banner_id]) !!}">添加</a>
        </h1>
    </section>
    <div class="content pdall0-xs">
        <div class="clearfix"></div>

        @include('admin.partials.message')

        <div class="clearfix"></div>
        <div class="box box-primary mb10-xs">
            <div class="box-body">
                    @include('admin.banner_items.table')
            </div>
        </div>
    </div>
@endsection

