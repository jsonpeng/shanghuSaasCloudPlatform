@extends('admin.layouts.app_distribution')

@section('content')
    <section class="content-header">
        <h1 class="pull-left mb15">分佣记录</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('admin.partials.message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('admin.distribution_logs.table')
            </div>
        </div>
        <div class="tc"><?php echo $distributionLogs->render(); ?></div>
    </div>
@endsection

