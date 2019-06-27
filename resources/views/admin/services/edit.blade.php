@extends('admin.layouts.app_shop')

@section('content')
    <section class="content-header">
        <h1>
            编辑服务
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary form">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($services, ['route' => ['services.update', $services->id], 'method' => 'patch']) !!}

                        @include('admin.services.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
   @include('admin.partials.imagemodel')
@endsection

@include('admin.services.js')