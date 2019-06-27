@extends('admin.layouts.app_shop')

@section('content')
    <section class="content-header">
        <h1>
            新建预约
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary form">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'subscribes.store']) !!}

                        @include('admin.subscribes.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@include('admin.subscribes.js')
