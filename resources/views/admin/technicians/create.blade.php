@extends('admin.layouts.app_shop')

@section('content')
    <section class="content-header">
        <h1>
            添加技师
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary form">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'technicians.store']) !!}

                        @include('admin.technicians.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @include('admin.partials.imagemodel')
@endsection
