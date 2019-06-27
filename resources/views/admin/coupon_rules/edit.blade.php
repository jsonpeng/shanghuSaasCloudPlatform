@extends('admin.layouts.app_promp')

@section('content')
    <section class="content-header">
        <h1>
            编辑规则
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary form">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($couponRule, ['route' => ['couponRules.update', $couponRule->id], 'method' => 'patch']) !!}

                        @include('admin.coupon_rules.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection

@include('admin.coupon_rules.partial.js')