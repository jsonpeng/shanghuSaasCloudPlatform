@extends('admin.layouts.app_promp')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">发放优惠券</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('admin.partials.message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li><a href="">整体发放</span></a></li>
                        <li><a href="">逐个发放</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(1)">保存</button>
                            </div>
                            <!-- /.box-footer -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
@endsection

