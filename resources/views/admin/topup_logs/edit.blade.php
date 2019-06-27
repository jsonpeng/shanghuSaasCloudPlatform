@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Topup Log
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($topupLog, ['route' => ['topupLogs.update', $topupLog->id], 'method' => 'patch']) !!}

                        @include('topup_logs.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection