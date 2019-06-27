@extends('admin.layouts.app')

@section('content')
    <section class="content-header mb15">
        <h1 class="pull-left ">设置银行卡</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('bankSets.create') !!}">添加</a>
        </h1>
    </section>
    <div class="content pdall0-xs">
        <div class="clearfix"></div>

        @include('admin.partials.message')

        <div class="clearfix"></div>
        <div class="box box-primary mb10-xs form">
            <div class="box-body">
                    @include('admin.bank_sets.table')
            </div>
        </div>
        <div class="text-center">
             <div class="tc"><?php echo $bankSets->appends('')->render(); ?></div>
        </div>
    </div>
@endsection

