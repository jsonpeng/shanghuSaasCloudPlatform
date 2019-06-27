@extends('admin.layouts.app_promp')

@section('content')
    <section class="content-header">
        <h1>
            Product Promp
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('admin.product_promps.show_fields')
                    <a href="{!! route('productPromps.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
