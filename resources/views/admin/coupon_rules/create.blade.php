@extends('admin.layouts.app_promp')

@section('content')
    <section class="content-header">
        <h1>
            送券规则
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary form">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'couponRules.store']) !!}

                        @include('admin.coupon_rules.fields', ['shops' => $coupons, 'selectedCoupons' => []])

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@include('admin.coupon_rules.partial.js')
