@extends('admin.layouts.app')

@section('content')
    <section class="content-header mb10-xs">
        <h1>
            编辑横幅
        </h1>
   </section>
   <div class="content pdall0-xs">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary mb10-xs form">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($banner, ['route' => ['banners.update', $banner->id], 'method' => 'patch']) !!}

                        @include('admin.banners.fields', ['banner' => $banner])

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection