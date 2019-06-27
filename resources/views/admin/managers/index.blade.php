@extends('admin.layouts.app_shop')

@section('content')
<div class="container-fluid" style="padding: 30px 15px;">
    <div class="row">

        <div class="col-sm-9 col-lg-10">
            <section class="content-header">
                <h1 class="pull-left">分店铺管理员列表</h1>
    
                <h1 class="pull-right">
                    <a class="btn btn-primary pull-right" style="margin-bottom: 5px" href="{!! route('shopBranchManagers.create') !!}">添加</a>
                </h1>
            </section>
            <div class="content">
                <div class="clearfix"></div>

                @include('admin.partials.message')

                <div class="clearfix"></div>
                <div class="box box-primary">
                    <div class="box-body">
                            @include('admin.managers.table')
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

