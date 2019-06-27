@extends('admin.layouts.app_shop')

@section('content')
    <section class="content-header">
        <h1>
            编辑预约
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary form">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($subscribe, ['route' => ['subscribes.update', $subscribe->id], 'method' => 'patch']) !!}

                        @include('admin.subscribes.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection

@include('admin.subscribes.js')