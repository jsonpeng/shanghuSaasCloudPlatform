@extends('admin.layouts.app_tem')

@section('content')
  <div class="container">
      <section class="content-header">
          <h1>
              编辑店铺
          </h1>
     </section>
     <div class="content">
         @include('adminlte-templates::common.errors')
         <div class="box box-primary">
             <div class="box-body">
                 <div class="row">
                     {!! Form::model($storeShop, ['route' => ['storeShops.update', $storeShop->id], 'method' => 'patch']) !!}

                          @include('admin.store_shops.fields')

                     {!! Form::close() !!}
                 </div>
             </div>
         </div>
     </div>
  </div>
   @include('admin.partials.imagemodel')
@endsection

@include('admin.store_shops.js')