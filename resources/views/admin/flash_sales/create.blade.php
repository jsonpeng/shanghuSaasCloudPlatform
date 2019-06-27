@extends('admin.layouts.app_promp')

@section('content')
    <section class="content-header mb10-xs">
        <h1>
            添加描述产品
        </h1>
    </section>
    <div class="content pdall0-xs">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary form">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'flashSales.store']) !!}

                        @include('admin.flash_sales.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('admin.flash_sales.partial.js')
@endsection