@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Team Follow
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($teamFollow, ['route' => ['teamFollows.update', $teamFollow->id], 'method' => 'patch']) !!}

                        @include('team_follows.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection