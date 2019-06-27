@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Credit Service User
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($creditServiceUser, ['route' => ['creditServiceUsers.update', $creditServiceUser->id], 'method' => 'patch']) !!}

                        @include('credit_service_users.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection