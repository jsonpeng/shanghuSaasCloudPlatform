@extends('admin.layouts.app_promp')

@section('content')
    <section class="content-header">
        <h1>
            Coupon Rule
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('admin.coupon_rules.show_fields')
                    <a href="{!! route('couponRules.index') !!}" class="btn btn-default">返回</a>
                </div>
            </div>
        </div>
    </div>
@endsection
