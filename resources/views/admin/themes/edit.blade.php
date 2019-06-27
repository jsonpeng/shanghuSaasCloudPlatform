@extends('admin.layouts.app_shop')

@section('css')
    <style type="text/css">
        .product-list{
            display: inline-block; margin-right: 20px; border: 1px solid #ddd; white-space : nowrap; width: 102px; overflow: hidden;
         }
    </style>
@endsection

@section('content')
    <section class="content-header" style="margin-bottom: 0;">
        <h1>
            编辑专题
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($theme, ['route' => ['themes.update', $theme->id], 'method' => 'patch']) !!}

                        @include('admin.themes.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
   @include('partials.imagemodel')
@endsection

@include('products.partials.js')