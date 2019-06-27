@extends('admin.layouts.app_shop')

@section('content')
    <section class="content-header">
        <h1>
            创建服务
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary form">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'services.store']) !!}

                        @include('admin.services.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @include('admin.partials.imagemodel')
@endsection

@include('admin.services.js')
