@extends('admin.layouts.app_promp')

@include('admin.coupons.partial.css')

@section('content')
    <section class="content-header">
        <h1 class="pb15-xs">
            新建优惠券
        </h1>
    </section>
    <div class="content pdall0-xs">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary form">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'coupons.store']) !!}

                        @include('admin.coupons.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@include('admin.coupons.partial.js')