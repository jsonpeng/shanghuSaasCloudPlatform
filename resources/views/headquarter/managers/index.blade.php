@extends('admin.layouts.app')

@section('content')
<div class="container-fluid" style="padding: 30px 15px;">
    <div class="row">

        @include('headquarter.managers.left_bar')

        <div class="col-sm-9 col-lg-10">
            <section class="content-header">
                <h1 class="pull-left">{!! $input['type'] !!}列表</h1>
                <h1 class="pull-right">
                  
                    <a class="btn btn-primary pull-right" style="margin-bottom: 5px" href="{!! route('managers.create').'?type='.$input['type']  !!}">添加</a>
               
                </h1>
            </section>
            <div class="content">
                <div class="clearfix"></div>

                @include('admin.partials.message')

                <div class="clearfix"></div>
                <div class="box box-primary">
                    <div class="box-body">
                            @include('headquarter.managers.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection

@section('scripts')
<script>
    $('#copy_daili_link').click(function(){
       layer.open({
        type: 1,
        closeBtn: false,
        shift: 7,
        shadeClose: true,
        title: '获取代理商注册链接',
        content: "<div style='width:350px; padding: 0 15px;'><div style='width:320px;' class='form-group has-feedback'><p>请输入account</p><input  class='form-control' type='text'  name='account' value='' /></div>" +
        "<button style='margin-top:5%;width:80%;margin:0 auto;margin-bottom:5%;' type='button' class='btn btn-block btn-primary btn-lg' onclick='getCopyLink()'>复制链接到粘贴板</button></div>"
         });
     });
    function getCopyLink(){
        
    }
</script>
@endsection

