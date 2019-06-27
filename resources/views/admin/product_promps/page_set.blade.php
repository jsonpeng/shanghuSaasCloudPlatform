@extends('admin.layouts.app_promp')

@section('content')
    <section class="content-header">
        <h1>
            默认分页设置
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                  <form >
                        <!-- Post Page Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('page_list', '每页显示数量:') !!}
                            {!! Form::number('page_list', $page_list, ['class' => 'form-control']) !!}
                        </div>

                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::button('保存', ['class' => 'btn btn-primary']) !!}
                        </div>
                 </form>
                  
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
<script type="text/javascript">
$('.btn').click(function(){
        var page_list=$('input[name=page_list]').val();
        if(page_list!=''){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"/zcjy/Promps/pageSetApi",
            type:"POST",
            data:"page_list="+page_list,
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
    }else{
         layer.msg('请输入分页数量', {icon: 5});
         return false;
    }
});
</script>
@endsection
