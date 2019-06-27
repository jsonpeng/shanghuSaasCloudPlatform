@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Distribution Log
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($distributionLog, ['route' => ['distributionLogs.update', $distributionLog->id], 'method' => 'patch']) !!}

                        @include('distribution_logs.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection