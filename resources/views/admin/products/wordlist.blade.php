@extends('admin.layouts.app_shop')
<!--商品多选-->
@section('content')
<section class="content-header mb10-xs">
    <h1 class="pull-left">产品保障列表</h1>
 
    <a class="btn btn-primary pull-right" style="margin-bottom: 5px" href="{!! route('wordlist.create') !!}">添加保障信息</a>
  
</section>

<div class="content pdall0-xs">
    <div class="clearfix"></div>

    <div class="box box-primary">
        <div class="box-body">
            <table class="table table-responsive" id="products-table">
                <thead>
                    <th>产品保障</th>
                    <th>操作</th>
                </thead>
                <tbody id="products-tbody">
                    @foreach ($wordList as $item)
                    <tr class="wordlist_class">
                        <td><span class="deliveryWord{!! $item->id !!}">{!! $item->name !!}</span><input type="text" name="items" class="delivery{!! $item->id !!}" value="{!! $item->name !!}"></td>
                        <td>{!! Form::open(['route' => ['wordlist.destroy', $item->id], 'method' => 'post']) !!}
                        <div class='btn-group'>
                            <span class="btn btn-default btn-xs Showdelivery" href="javascript:;" onclick="editWordItem(this,{{ $item->id }})"><i class="glyphicon glyphicon-edit"></i>
                            </span>
                             <span class="btn btn-default btn-xs delivery" onclick="confirmDelivery(this,{{$item->id}})"><i class="glyphicon glyphicon-ok"></i></span>
                            <span class="btn btn-default btn-xs delivery" onclick="cancelDelivery(this,{{$item->id}})"><i class="glyphicon glyphicon-remove"></i></span>
                            {!! Form::button(' <i class="glyphicon glyphicon-trash"></i>
                            ', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认删除?')"]) !!}
                        </div>
                {!! Form::close() !!}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection


@section('scripts')
<script type="text/javascript">
    $(function(){
            $('.delivery').hide();
            $('.wordlist_class').each(function(){
                    $(this).children('td').find('input').hide();
            });
    });
   
    function editWordItem(obj,id){
        $(obj).hide();
        $(obj).parent().find('.delivery').show();
        $('.deliveryWord'+id).hide();
        $('.delivery'+id).show();
        $('.delivery'+id).val($('.deliveryWord'+id).text());
    }

    function cancelDelivery(obj,id){
         $(obj).parent().find('.Showdelivery').show();
         $(obj).parent().find('.delivery').hide();
         $('.delivery'+id).hide();
         $('.deliveryWord'+id).show();
    }

    function confirmDelivery(obj,id){
            $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
            $.ajax({
                url:'/zcjy/ajax/wordset/'+id,
                type:'post',
                data:'name='+$('.delivery'+id).val(),
                success:function(data){
                    if(data.code==0){
                     $(obj).parent().find('.Showdelivery').show();
                     $('.deliveryWord'+id).text(data.message);
                      $('.deliveryWord'+id).show();
                     $(obj).parent().find('.delivery').hide();
                     $('.delivery'+id).hide();

                 }else{
                    alert(data.message)
                        }
                 }
        });
    }
</script>
@endsection