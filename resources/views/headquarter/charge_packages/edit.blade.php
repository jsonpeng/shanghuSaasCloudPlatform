@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            编辑套餐
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
   {{--     <div class="box box-primary mb10-xs ">
           <div class="box-body"> --}}
               <div class="row">
                   {!! Form::model($chargePackage, ['route' => ['chargePackages.update', $chargePackage->id], 'method' => 'patch']) !!}

                        @include('headquarter.charge_packages.fields')

                   {!! Form::close() !!}
       {{--         </div>
           </div> --}}
       </div>
   </div>
   @include('admin.partials.imagemodel')
@endsection

@include('headquarter.charge_packages.js')