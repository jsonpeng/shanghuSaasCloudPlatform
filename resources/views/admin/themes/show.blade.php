@extends('admin.layouts.app_shop')

@section('content')
    <section class="content-header">
        <h1>
            Theme
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('themes.show_fields')
                    <a href="{!! route('themes.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
