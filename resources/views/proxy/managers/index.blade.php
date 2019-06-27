@extends('admin.layouts.app')

@section('content')
<div class="container-fluid" style="padding: 30px 15px;">
    <div class="row">

        <div class="col-sm-9 col-lg-10">
            <section class="content-header">
                <h1 class="pull-left">{{ $input['type'] }}列表</h1>
                @if($input['type'] == '商户')
                    <a href="{{ http().admin()->account }}.{{ domain() }}/register"  target="_blank" style="margin-left: 5px;">获取商户注册链接</a>
                @endif
                <h1 class="pull-right">
                    <a class="btn btn-primary pull-right" style="margin-bottom: 5px" href="{!! route('shopManagers.create') !!}">添加</a>
                </h1>
            </section>
            <div class="content">
                <div class="clearfix"></div>

                @include('admin.partials.message')

                <div class="clearfix"></div>
                <div class="box box-primary">
                    <div class="box-body">
                            @include('proxy.managers.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection

@section('scripts')
<script>
 
</script>
@endsection

