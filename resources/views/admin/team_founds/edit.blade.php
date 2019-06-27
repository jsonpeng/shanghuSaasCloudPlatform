@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Team Found
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($teamFound, ['route' => ['teamFounds.update', $teamFound->id], 'method' => 'patch']) !!}

                        @include('team_founds.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection