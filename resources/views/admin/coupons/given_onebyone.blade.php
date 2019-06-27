@extends('admin.layouts.app_promp')

@section('content')
<div class="content">
    <div class="clearfix"></div>
    @include('admin.partials.message')
    <div class="clearfix"></div>
    <div class="box box-primary form">
        <div class="box-body">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li>
                        <a href="{!! route('coupons.integer') !!}">整体发放</span>
                    </a>
                </li>
                <li class="active">
                    <a href="javascripts:;">逐个发放</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                       <form id="coupons_form">
                    <div  class="box box-solid  col-sm-12" >
                        <div class="box-header with-border">
                            <h3 class="box-title">逐个发放</h3>
                               <div class="pull-right">
                                <button class="btn btn-primary btn-sm daterange pull-right" type="button" title="添加用户" onclick="addUserMenuFunc()"> <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body" style="display: none;" id="users_items" >
                            <div class="row" style="background-color: #edfbf8;">
                                <div class="col-md-2">编号</div>
                                <div class="col-md-3">用户名</div>
                                <div class="col-md-2">性别</div>
                                <div class="col-md-3">手机号</div>
                                 <div class="col-md-2">操作</div>
                            </div>
                        </div>

                        <div id="users_items_table" style="display: none;"></div>
                    </div>

                 
                      {{--   {!! Form::hidden('user_ids[]', null, ['class' => 'form-control','id'=>'user_id']) !!} --}}
                        <div id="coupon_option" >
                            <div class="form-group col-sm-12">
                                {!! Form::label('count', '选择发放的优惠劵:') !!}
                                    @foreach ($coupons as $coupon)
                                <label style="display: inline-block; margin-right: 15px;">
                                    {!! Form::checkbox('coupons[]', $coupon->id, in_array($coupon->id, $selectedCoupons), ['class' => 'field minimal']) !!}
                                                {!! $coupon->name !!}
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group col-sm-12">
                            {!! Form::label('count', '发放数量:') !!}
                                    {!! Form::number('count', null, ['class' => 'form-control']) !!}
                        </div>

                    </form>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-left" onclick="saveForm()">保存</button>
                    </div>
                    <!-- /.box-footer --> </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection



@section('scripts')
<script type="text/javascript">
  var user_id_arr=[];
   $('.givenByOne').click(function(){
    var html=$('#coupon_option').html();

   }); 

   $('.useritem').click(function(){
        var id=$(this).data('id');
        var status=$(this).data('status');
      if(status){
        $(this).css('background','none');
        //$('#coupons_form').hide();
        user_id_arr=delArrayByName(id,user_id_arr);
        $('#user_id').val(user_id_arr); 
        $(this).data('status',false);
      }else{
        $(this).css('background','orange');
        //$('#coupons_form').show(300);
         user_id_arr.push(id);
        $('#user_id').val(user_id_arr);
         $(this).data('status',true);
    }

   });


   function delItem(obj){
    $(obj).parent().parent().remove();
   }

   function saveForm(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"/zcjy/coupons/given",
            type:"POST",
            data:$("form").serialize(),
            success: function(data) {
              if (data.code == 0) {
                layer.msg(data.message, {icon: 1});
                location.reload();
              }else{
                layer.msg(data.message, {icon: 5});
              }
            },
            error: function(data) {
              //提示失败消息

            },
        });
        
    }
</script>
@endsection