@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            分类详情
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('admin.articlecats.show_fields')
                    <a href="{!! route('articlecats.index') !!}" class="btn btn-default">返回</a>
                </div>
            </div>
        </div>
    </div>
@endsection
