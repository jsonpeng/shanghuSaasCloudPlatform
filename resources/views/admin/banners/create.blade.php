@extends('admin.layouts.app')

@section('content')
<section class="content-header mb10-xs">
    <h1>创建横幅</h1>
</section>
<div class="content pdall0-xs">
    @include('adminlte-templates::common.errors')
    <div class="box box-primary mb10-xs form">

        <div class="box-body">
            <div class="row">
                {!! Form::open(['route' => 'banners.store']) !!}

                        @include('admin.banners.fields', ['banner' => null])

                    {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection