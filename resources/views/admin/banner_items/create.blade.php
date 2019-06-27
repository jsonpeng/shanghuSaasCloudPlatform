@extends('admin.layouts.app')

@section('content')
    <section class="content-header mb10-xs">
        <h1>
            {{$banner->name}}
        </h1>
    </section>
    <div class="content pdall0-xs">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary mb10-xs form">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => ['bannerItems.store', $banner_id]]) !!}
                        <input type="hidden" name="banner_id" value="{{$banner_id}}">
                        @include('admin.banner_items.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @include('admin.partial.imagemodel')
@endsection
