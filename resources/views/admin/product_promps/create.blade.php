@extends('admin.layouts.app_promp')

@section('content')
    <section class="content-header mb10-xs">
        <h1>
            创建活动
        </h1>
    </section>
    <div class="content pdall0-xs">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary form mb10-xs">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'productPromps.store']) !!}

                        @include('admin.product_promps.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials.imagemodel')
@endsection

@section('scripts')
    @include('admin.product_promps.partial.js')
@endsection
