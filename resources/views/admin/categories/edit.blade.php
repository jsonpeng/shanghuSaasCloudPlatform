@extends('admin.layouts.app_shop')

@section('content')
    <section class="content-header">
        <h1>
            编辑产品分类
        </h1>
   </section>
   <div class="content pdall0-xs">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($category, ['route' => ['categories.update', $category->id], 'method' => 'patch']) !!}
                        {!! Form::hidden('category_id', $category->id) !!} 
                        
                        @include('admin.categories.fields', ['categories' => $categories,'category' => $category])

                   {!! Form::close() !!}
               </div>
           </div>
       </div>

       @include('admin.partials.imagemodel')

   </div>
@endsection

{{-- @include('admin.categories.js') --}}
