@extends('admin.layouts.app_promp')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">优惠券赠送规则</h1>
        <h1 class="pull-right">
            <a class="btn btn-primary pull-right" style="margin-bottom: 5px" href="{!! route('couponRules.create') !!}">添加</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('admin.partials.message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('admin.coupon_rules.table')
            </div>
        </div>
    </div>
@endsection

