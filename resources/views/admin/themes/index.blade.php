@extends('admin.layouts.app_shop')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">专题列表</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-bottom: 5px" href="{!! route('themes.create') !!}">新建专题</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('admin.partials.message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('admin.themes.table')
            </div>
        </div>
        <div class="tc"><?php echo $themes->render(); ?></div>
    </div>
@endsection

