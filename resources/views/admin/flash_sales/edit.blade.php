@extends('admin.layouts.app_promp')

@section('content')
    <section class="content-header mb10-xs">
        <h1>
            编辑描述产品
        </h1>
   </section>
   <div class="content pdall0-xs">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary form ">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($flashSale, ['route' => ['flashSales.update', $flashSale->id], 'method' => 'patch']) !!}

                        @include('admin.flash_sales.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection

@section('scripts')
    @include('admin.flash_sales.partial.js')
@endsection