@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
           编辑单页面
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary form">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($singelPage, ['route' => ['singelPages.update', $singelPage->id], 'method' => 'patch']) !!}

                        @include('admin.singel_pages.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection



@section('scripts')
    @include('admin.singel_pages.partials.js')
@endsection