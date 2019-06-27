@extends('admin.layouts.app_promp')

@section('content')
    <section class="content-header">
        <h1>
            创建订单优惠
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary form">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'orderPromps.store']) !!}

                        @include('admin.order_promps.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('admin.product_promps.partial.js')
@endsection