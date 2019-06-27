@extends('admin.layouts.app_shop')

@section('content')
    <section class="content-header">
        <h1>
            今日预约列表
        </h1>
    </section>
    <div class="content">

        <div class="box box-primary form">
            <div class="box-body">
                    @include('admin.subscribes.show_fields')
            </div>
        </div>
        <div class="pull-left">
             <a href="{!! route('subscribes.index') !!}" class="btn btn-default">返回</a>
        </div>

    {{--     <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('admin.subscribes.show_fields')
                    <a href="{!! route('subscribes.index') !!}" class="btn btn-default">返回</a>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
