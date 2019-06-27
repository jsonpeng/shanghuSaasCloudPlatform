@extends('admin.layouts.app_promp')

@section('content')
<section class="content-header">
    <h1>Team Sale</h1>
</section>
<div class="content">
    <div class="box box-primary">
        <div class="box-body">
            <div class="row" style="padding-left: 20px">
                @include('team_sales.show_fields')
                <a href="{!! route('teamSales.index') !!}" class="btn btn-default">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection