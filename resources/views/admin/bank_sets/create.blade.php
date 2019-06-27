@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
           添加银行卡
        </h1>
    </section>
    <div class="content pdall0-xs">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary mb10-xs form">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'bankSets.store']) !!}

                        @include('admin.bank_sets.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@include('admin.partials.imagemodel')
