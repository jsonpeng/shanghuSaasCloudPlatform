@extends('admin.layouts.app_promp')

@section('content')
    <section class="content-header">
        <h1>
            Flash Sale
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('admin.flash_sales.show_fields')
                    <a href="{!! route('flashSales.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
