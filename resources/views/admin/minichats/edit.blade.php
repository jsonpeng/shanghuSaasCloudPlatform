@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Minichat
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($minichat, ['route' => ['minichats.update', $minichat->id], 'method' => 'patch']) !!}

                        @include('minichats.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection