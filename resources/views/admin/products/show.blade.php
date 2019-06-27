@extends('admin.layouts.app_shop')

@section('content')
    <section class="content-header" style="height: 50px;">
        <h1 class="pull-left">产品信息</h1>
        <h1 class="pull-right">
            <a href="{!! route('products.create') !!}" class="btn btn-primary">添加产品</a>
           <a href="{!! route('products.index') !!}" class="btn btn-primary">返回</a>
        </h1>
    </section>
    <div class="row">
        <div class="col-md-12">
            <div class="content" style="padding-top: 0">
                @include('admin.products.show_fields', ['dimensions' => $dimensions])
            </div>
        </div>
    </div>
    @include('admin.partials.imagemodel_product')
@endsection


@section('scripts')
    <script type="text/javascript">
    jQuery(document).ready(function() {

        jQuery('.datetimepicker_start').datetimepicker({
            format: 'yyyy-mm-dd hh:ii:ss',
            language: 'zh_CN'

        });
        jQuery('.datetimepicker_end').datetimepicker({
            format: 'yyyy-mm-dd hh:ii:ss'
        });
    });
    </script>
@endsection