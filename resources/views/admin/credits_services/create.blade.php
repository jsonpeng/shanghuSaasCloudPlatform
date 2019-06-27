@extends('admin.layouts.app_shop')

@section('content')
    <section class="content-header">
        <h1>
            添加
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'creditsServices.store']) !!}

                        @include('admin.credits_services.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        @include('admin.partial.imagemodel')
    </div>
@endsection

@include('admin.credits_services.js')
