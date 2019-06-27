@extends('admin.layouts.app_distribution')

@section('content')
    <section class="content-header ">
        <h1 class="pull-left mb10-xs">分销统计</h1>
    </section>
    <div class="content pdall0-xs" style="margin-top: 15px;">
        <div class="clearfix"></div>

        @include('admin.partials.message')

        <div class="clearfix"></div>
        <div class="box box-primary mb10-xs">
            <div class="box-body">
                    分销统计信息
            </div>
        </div>
    </div>
@endsection

