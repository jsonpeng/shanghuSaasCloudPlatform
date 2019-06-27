@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Team Lottery
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($teamLottery, ['route' => ['teamLotteries.update', $teamLottery->id], 'method' => 'patch']) !!}

                        @include('team_lotteries.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection