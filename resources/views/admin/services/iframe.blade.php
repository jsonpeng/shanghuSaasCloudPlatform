@extends('admin.layouts.app_tem')

@section('content')
<section class="content-header mb10-xs">
    <h1 class="pull-left">服务列表</h1>
    <div>(共{!! $services_num !!}条记录)</div>
</section>

<div class="content pdall0-xs">
    <div class="clearfix"></div>
    <div class="box box-default box-solid mb10-xs">
        <div class="box-header with-border">
            <h3 class="box-title">查询</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
            <!-- /.box-tools --> </div>
        <!-- /.box-header -->
        <div class="box-body">
            <form id="service_search" action="">

                <div class="form-group col-md-2">
                    <label for="order_delivery">服务名称</label>
                    <input type="text" class="form-control" name="name" placeholder="服务名称" @if (array_key_exists('name', $input))value="{{$input['name']}}"@endif></div>
                <div class="form-group col-md-1" style="padding-top: 25px;">
                    <button type="submit" class="btn btn-primary pull-right">查询</button>
                </div>
            </form>
        </div>
        <!-- /.box-body --> </div>
    <!-- /.box -->

    <div class="clearfix"></div>
    <div class="box box-primary">
        <div class="box-body">
            <table class="table table-responsive" id="products-table">
                <thead>
                    <th>服务名称</th>
                    <th>服务类型</th>
              {{--       <th>适用店铺</th> --}}
                </thead>
                <tbody id="services-tbody">
                    @foreach($services as $item)
                        <tr data-id="{{ $item->id }}" data-name="{{ $item->name }}">
                            <td>{!! $item->name !!} @if($item->all_use == 1) {!! tag('[全场通用]') !!} @endif</td>
                            <td>{!! $item->Type !!}</td>
                        {{--     <td>{!! $item->ShopsHtml !!}</td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <div class="pull-left" style="margin-top:15px;">
            <input type="button" class="btn btn-primary"  value="确定" id="product_enter"></div>
    </div>
    <div class="tc">
        <?php echo $services->appends($input)->links(); ?></div>
</div>
@endsection


@section('scripts')
<script type="text/javascript">
       var type =null;
       @if(array_key_exists('type',$input))
            type = {{ $input['type'] }};
       @endif
        //多选服务
        $('#services-tbody >tr').click(function(){
     
                $('#services-tbody >tr').each(function(){
                    if($(this).hasClass('trSelected')){
                        //单选服务
                         @if(array_key_exists('type',$input) && $input['type'] == 2)
                         $(this).removeClass('trSelected');
                         @endif 

                    }
                });
               $(this).toggleClass('trSelected');
        });
        //确定
        $('#product_enter').click(function(){
            var selected=$('#services-tbody >tr').hasClass('trSelected');
            if(!selected){
               layer.alert('请选择服务', {icon: 2}); 
               return false;
            }
            $('#services-tbody >tr').each(function(){
                if(!$(this).hasClass('trSelected')){
                    $(this).remove();
                }
            });
            var tabHtml=$('#services-tbody').html();
            console.log(tabHtml);
            javascript:window.parent.call_back_by_many_with_service(tabHtml,type);
        });
</script>
@endsection