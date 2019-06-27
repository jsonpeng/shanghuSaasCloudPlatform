@extends('admin.layouts.app_shop')

@section('content')
    <section class="content-header">
        <h1>
            管理员
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('admin.managers.show_fields')
                    <a href="{!! route('shopBranchManagers.index') !!}" class="btn btn-default">返回</a>
                </div>
            </div>
        </div>
    </div>
@endsection
