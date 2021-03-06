@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            公告消息
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary form">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'notices.store']) !!}

                        @include('admin.notices.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
