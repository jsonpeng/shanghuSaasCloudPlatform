@extends('admin.layouts.app_shop')

@section('content')
    <section class="content-header">
        <h1>
            分类信息
        </h1>
    </section>
    <div class="content pdall0-xs">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('admin.categories.show_fields')
                    <a href="{!! route('categories.index') !!}" class="btn btn-default">返回</a>
                </div>
            </div>
        </div>
    </div>
@endsection
