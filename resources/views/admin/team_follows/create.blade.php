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
                    {!! Form::open(['route' => 'teamFollows.store']) !!}

                        @include('team_follows.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
