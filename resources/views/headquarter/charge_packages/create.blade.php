@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            创建套餐
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
      {{--   <div class="box box-primary mb10-xs">
            <div class="box-body"> --}}
                <div class="row">
                    {!! Form::open(['route' => 'chargePackages.store']) !!}

                        @include('headquarter.charge_packages.fields')

                    {!! Form::close() !!}
                </div>
      {{--       </div>
        </div> --}}
    </div>
    @include('admin.partials.imagemodel')
@endsection

@include('headquarter.charge_packages.js')
