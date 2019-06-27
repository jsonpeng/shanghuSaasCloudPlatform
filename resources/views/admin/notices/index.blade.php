@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">公告消息</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('notices.create') !!}">添加</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('admin.notices.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

