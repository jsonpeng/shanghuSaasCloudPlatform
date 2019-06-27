@extends('admin.layouts.app_shop')

@section('css')
    <style>
        .delivery, .address, .price_adjust{display: none;}
        .btn-primary{margin-left: 10px;}
        .row div{line-height: 28px;}
        .box-body{overflow: hidden; padding-top: 0;}
        div.btn{line-height: initial;}
        .box{margin-bottom: 5px;}
        .btn-danger{
            color: #d9534f;
            background-color: transparent;
        }
        .btn, .form-control{height: 25px;}
        .btn{
            padding: 3px 15px;
            font-size: 12px;
        }
        label{color: #999; font-weight: normal;}
    </style>
@endsection

@section('content')
<div class="content pdall0-xs" style="max-width: 990px;">
    <div class="box box-solid">
        <!-- /.box-header -->
        <div class="box-body" style="padding: 10px;">
            <div class="btn pull-right btn-primary" onclick="printOrder({{ $order->id }})">小票打印</div>
            <a class="btn pull-right btn-primary" href="/zcjy/order/print/{{ $order->id }}">订单打印</a>
        </div>
        <!-- /.box-body --> 
    </div>

    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">基础信息</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-3">
                    <label>订单编号:</label> 
                    {!! $order->snumber !!}
                </div>
                <div class="col-md-3">
                    <label>订单状态:</label>
                    {!! $order->order_status !!}
                </div>
                <div class="col-md-3">
                    <label>物流状态:</label>
                    {!! $order->order_delivery !!}
                </div>
                <div class="col-md-3">
                    <label>支付类型:</label>
                    {!! $order->pay_type !!}
                </div>
                <div class="col-md-3">
                    <label>支付渠道:</label>
                    {!! $order->pay_platform !!}
                </div>
                <div class="col-md-3">
                    <label>支付状态:</label>
                    {!! $order->order_pay !!}
                </div>
                <div class="col-md-3">
                    <label>下单时间:</label>
                    {!! $order->created_at !!}
                </div>
                <div class="col-md-3">
                    <label>用户留言:</label>
                    {!! $order->remark !!}
                </div>
            </div>
        </div>
        <!-- /.box-body --> 
    </div>

    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">购买人信息</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <form id="address">
                    <div class="col-md-4">
                        <span class="showAddress">{!! $order->customer_name !!}</span>
                        <input type="text" class="form-control address" name="customer_name" value="{{ $order->customer_name }}"></div>
                    <div class="col-md-4">
                        <span class="showAddress">{!! $order->customer_phone !!}</span>
                        <input type="text" class="form-control address" name="customer_phone" value="{{ $order->customer_phone }}"></div>
                    <div class="col-md-12 pull-right" style="height: auto;">
                        @if ($order->order_delivery != '已发货' && $order->order_delivery != '已收货' && $order->order_status != '无效' && $order->order_status != '已取消')
                        <div class="btn btn-default pull-right showAddress" onclick="modifyAddress()">修改</div>
                        <div class="btn btn-primary pull-right address" onclick="confirmAddress({{$order->id}})">确认</div>
                        <div class="btn btn-default pull-right address" onclick="cancelAddress()">取消</div>
                        @endif
                    </div>
                </form>

            </div>
        </div>
        <!-- /.box-body --> 
    </div>

    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">商品信息</h3>
            @if ($order->order_status == '未确认' && $order->order_status != '无效' && $order->order_status != '已取消')
        {{--     <div class="pull-right">
                <button class="btn btn-primary btn-sm daterange pull-right"  title="添加商品" onclick="addProductMenuFunc(3)"> <i class="fa fa-plus"></i>
                </button>
            </div> --}}
            @endif
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row" style="background-color: #edfbf8;">
                <div class="col-md-1 col-xs-2 hidden-xs">编号</div>
                <div class="col-md-4 col-xs-4">商品</div>
                <div class="col-md-2 col-xs-2 hidden-xs">规格</div>
                <div class="col-md-1 col-xs-2">数量</div>
                <div class="col-md-1 col-xs-2">单价</div>
                <div class="col-md-1 col-xs-1 hidden-xs">总价</div>
                <div class="col-md-2 col-xs-4">修改</div>
            </div>
            @foreach($items as $item)
            <div class="row" style="border-bottom: 1px solid #f4f4f4" >
                <form id="item_form_{{ $item->
                    id }}">
                    <a class="col-md-1 col-xs-2 hidden-xs" style="line-height: 28px;" href="/zcjy/products/{{ $item->product->id }}/edit" target="_blank">{{ $item->id }}</a>
                    <div class="col-md-4 col-xs-4">
                        <img src="{{ $item->pic }}" alt="" style="height: 25px;">{{ $item->name }}</div>
                    <div class="col-md-2 col-xs-2 hidden-xs">{{ $item->unit }}</div>
                    <div class="col-md-1 col-xs-2" id="item_count_{{ $item->
                        id }}">
                        <span>{{ $item->count }}</span>
                        <input type="text" class="form-control input-sm" name="count" value="{{ $item->count }}" style="display: none;">
                    </div>
                    <div class="col-md-1 col-xs-2" id="item_price_{{ $item->
                        id }}">
                        <span>{{ $item->price }}</span>
                        <input type="text" class="form-control input-sm" name="price" value="{{ $item->price }}" style="display: none;">
                    </div>
                    <div class="col-md-1 col-xs-1 hidden-xs">{{ round($item->count * $item->price) }}</div>
                    @if ($order->order_status == '未确认' && $order->order_status != '无效' && $order->order_status != '已取消')
                    <div class="col-md-2 col-xs-4">
                        <div class='btn-group' id="item_" style="padding: 8px;">
                            <a href="javascript:;" class='btn-xs' id="item_edit_{{ $item->
                                id }}" onclick="editItem({{ $item->id }})"> <i class="glyphicon glyphicon-edit" title="编辑"></i>
                            </a>
                            <a href="javascript:;" style="display: none;" class='btn-xs' id="item_cancel_{{ $item->
                                id }}" onclick="cancelItem({{ $item->id }})">
                                <i class="glyphicon glyphicon-remove" title="取消"></i>
                            </a>
                            <a href="javascript:;" style="display: none;" class='btn-xs' id="item_confirm_{{ $item->
                                id }}" onclick="updateItem({{ $item->id }})">
                                <i class="glyphicon glyphicon-ok" title="确认"></i>
                            </a>

                            <a href="javascript:;" class='btn-danger btn-xs' id="item_delete_{{ $item->
                                id }}" onclick="delItem({{ $item->id }},{{ $order->id }},{{ $item->product_id }})">
                                <i class="glyphicon glyphicon-trash" title="确认"></i>
                            </a>
                        </div>
                    </div>
                    @endif
                </form>
            </div>
            @endforeach
        </div>
        <!-- /.box-body --> </div>

    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">费用信息</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <form id="price_adjust">
                    <div class="col-md-2"><label>应付费用:</label> {!! $order->price !!}</div>
                    <div class="col-md-2"><label>商品总价:</label> {!! $order->origin_price !!}</div>
                    @if (funcOpen('FUNC_ORDER_PROMP') && $order->preferential)<div class="col-md-2"><label>订单优惠:</label> {!! $order->preferential !!} </div>@endif
                    @if (funcOpen('FUNC_FUNDS') && $order->user_money_pay)<div class="col-md-2"><label>余额支付:</label> {!! $order->user_money_pay !!} </div>@endif
                    @if (funcOpen('FUNC_CREDITS') && $order->credits)<div class="col-md-4"><label>积分抵扣:</label> {{ $order->credits }}积分抵扣{!! $order->credits_money !!}元 </div>@endif
                    @if (funcOpen('FUNC_COUPON') && $order->coupon_money)<div class="col-md-2"><label>优惠券减免:</label> {!! $order->coupon_money !!} </div>@endif
                    @if (funcOpen('FUNC_MEMBER_LEVEL') && $order->user_level_money)<div class="col-md-2"><label>会员优惠:</label> {!! $order->user_level_money !!} </div>@endif
                    <div class="col-md-3">
                        <div class="ml0-xs">
                            <label>运费:</label>
                            <span class="showAdjust">{!! $order->freight !!}</span>
                            <input type="text" style="width: 50%;" class="form-control price_adjust" name="freight" value="{{ $order->freight }}">
                        </div>

                    </div>
                    <div class="col-md-3">
                        <label>价格调整:</label>
                        <span class="showAdjust">{!! $order->price_adjust !!}</span>
                        <input type="text" style="width: 50%;" class="form-control price_adjust" name="price_adjust" value="{{ $order->price_adjust }}">
                    </div>
                    @if ($order->order_pay == '未支付' && $order->order_status != '无效' && $order->order_status != '已取消')
                    <div class="col-md-12 pull-right" style="height: auto;">
                        <div class="btn btn-default pull-right showAdjust" onclick="modifyAdjust()">调整价格</div>
                        <div class="btn btn-primary pull-right price_adjust" onclick="confirmAdjust({{$order->id}})">确认</div>
                        <div class="btn btn-default pull-right price_adjust" onclick="cancelAdjust()">取消</div>
                    </div>
                    @endif
                </form>
            </div>
        </div>
        <!-- /.box-body --> 
    </div>

    @if (funcOpen('FUNC_FAPIAO'))
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">开票信息</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                @if ($order->invoice == '不要')
                    <div class="col-md-3">
                    <label>开票信息:</label> 
                        不开发票
                    </div>
                @else
                    <div class="col-md-3">
                        <label>开票类型:</label> 
                        {!! $order->invoice_type !!}
                    </div>
                    @if ($order->invoice_type == '公司')
                        <div class="col-md-3">
                            <label>开票名称:</label>
                            {!! $order->invoice_title !!}
                        </div>
                        <div class="col-md-3">
                            <label>税号:</label>
                            {!! $order->tax_no !!}
                        </div>
                    @endif
                    
                @endif
                
            </div>
        </div>
    </div>
    @endif

   
{{--     <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">配送信息</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <form id="delivery">
                    <div class="col-md-2">
                        <span class="showDelivery">{!! $order->delivery_company !!}</span>
                    
                      <select name="delivery_company" class="delivery">
                             <option value="" @if(empty($order->delivery_company)) selected="selected" @endif>请选择快递公司</option>
                        @foreach ($kuaidi as $child)
                            <option value="{{ $child }}" @if($order->delivery_company == $child) selected="selected" @endif>{!! $child !!}</option>
                        @endforeach
                     </select>
                    </div>
                      
                    <div class="col-md-5">
                        <span class="showDelivery">{!! $order->delivery_no !!}</span>
                        <input type="text" class="form-control delivery" name="delivery_no" value="{{ $order->delivery_no }}" placeholder="快递单号"></div>
                    @if ($order->order_delivery != '已收货' && $order->order_status != '无效' && $order->order_status != '已取消')
                    <div class="col-md-12 pull-right" style="height: auto;">
                        <div class="btn btn-default pull-right showDelivery" onclick="modifyDelivery()">修改</div>
                        <div class="btn btn-primary pull-right delivery" onclick="confirmDelivery({{$order->id}})">确认</div>
                        <div class="btn btn-default pull-right delivery" onclick="cancelDelivery()">取消</div>
                        @if(!empty($order->delivery_company) && !empty($order->delivery_no))
                         <div class="btn btn-success pull-right showDelivery" onclick="serchKuaiDi('{!! $order->delivery_company !!}','{!! $order->delivery_no !!}')">查询物流</div>
                        @endif
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div> --}}

    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">管理员备注信息</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <form id="manager_backpack">
                    <div class="col-md-12">
                        <span class="managerBack">{!! $order->backup01 !!}</span>
                        <textarea name="backup01" class="managerBackAction" style="width: 100%;margin-bottom: 10px;" rows="2">{!! $order->backup01 !!}</textarea>
                    </div>
               
                    <div class="col-md-12 pull-right" style="height: auto;">
                        <div class="btn btn-default pull-right managerBack" onclick="modifyManagerBack()">修改</div>
                        <div class="btn btn-primary pull-right managerBackAction" onclick="confirmManagerBack({{$order->id}})">确认</div>
                        <div class="btn btn-default pull-right managerBackAction" onclick="cancelManagerBack()">取消</div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">操作</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <form id="feiyong">
                    @if($order->order_delivery != '已收货')
                        <div class="col-md-12">操作备注:</div>
                        <div class="col-md-12" style="height: auto;">
                            <textarea name="operation_log" id="operation_log" style="width: 100%;" rows="2"></textarea>
                        </div>
                    @endif
                    
                    <div class="col-md-12" style="margin-top: 10px; height: auto;">
                        @if($order->order_delivery == '已收货')
                            <div class="btn btn-success">订单已完成</div>
                        @elseif ($order->order_status == '无效')
                            <div class="btn btn-default" onclick="updateStatusByButton({{$order->id}},'order_status=未确认')" >恢复订单</div>
                            <div class="btn btn-danger" onclick="deleteOrder({{$order->id}})">删除订单</div>
                        @else
                            
                            @if ($order->order_status == '未确认')
                                @if ($order->order_pay == '未支付')
                                    <div class="btn btn-primary" onclick="updateStatusByButton({{$order->id}},'order_pay=已支付')" >设置为已支付</div>
                                @else
                                    <div class="btn btn-default" onclick="updateStatusByButton({{$order->id}},'order_pay=未支付')" >设置为未支付</div>
                                @endif
                            @endif

                            @if ($order->order_pay == '已支付')
                                @if ($order->order_status == '未确认')
                                <div class="btn btn-primary" onclick="updateStatusByButton({{$order->id}},'order_status=已确认')">确认订单</div>
                                @else
                                <div class="btn btn-default" onclick="updateStatusByButton({{$order->id}},'order_status=未确认')"  >取消确认</div>
                                @endif
                            @endif


                            @if ($order->order_status == '已确认')
                                @if ($order->order_delivery == '未发货')
                                    <div class="btn btn-primary" onclick="updateStatusByButton({{$order->id}},'order_delivery=已发货')" >设置为已发货</div>
                                @else
                                    <div class="btn btn-default" onclick="updateStatusByButton({{$order->id}},'order_delivery=未发货')">设置为未发货</div>
                                @endif
                            @endif

                        <div class="btn btn-danger" onclick="updateStatusByButton({{$order->id}},'order_status=无效')">无效订单</div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
        <!-- /.box-body --> </div>


</div>

<div id="product_items"></div>
@endsection


@include('admin.orders.partial.js')
<script type="text/javascript">
    var order_id="{!! $order->id !!}";
    //添加商品方法 打开窗口
    // 选择商品返回
    function call_back_by_order(table_html)
    { 
        $('#product_items').html(table_html);
        layer.closeAll('iframe');
        $('#product_items').find('.trSelected').each(function(){
            var spec_id=$(this).data("specid");
            var product_id=$(this).data("productid");
            orderAddProductApi(spec_id,product_id);
        });
    }

    //添加商品接口
    function orderAddProductApi(spec_id,product_id){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

       $.ajax({
        url:"/zcjy/orders/addProductList" ,
        type:"POST",
        data:"spec_id="+spec_id+"&order_id="+order_id+"&product_id="+product_id,
        success:function(data){
            if(data.code==0){
               console.log("添加成功");
               updateAddProduct(order_id,"add_product=true",product_id);
            }

        }
    });
    }

    //删除商品接口
    function orderDelProductApi(item_id,order_id,product_id){
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

       $.ajax({
        url:"/zcjy/orders/delProductList/"+item_id,
        type:"POST",
        success:function(data){
            if(data.code==0){
               console.log("删除成功");
               updateDelProduct(order_id,"del_product=true",product_id);
            }

        }
    });

    }
        
    

    // 快递信息
    function modifyDelivery(){
        $('.delivery').show();
        $('.showDelivery').hide();
    }
    function confirmDelivery(id){
        event.preventDefault();
        updateOrder(id, $('#delivery').serialize()+'&_method=PATCH',true);
    }
    function cancelDelivery(){
        $('.delivery').hide();
        $('.showDelivery').show();
    }

    // 价格调整
    function modifyAdjust(){
        $('.price_adjust').show();
        $('.showAdjust').hide();
    }
    function confirmAdjust(id){
        event.preventDefault();
        updateOrder(id, $('#price_adjust').serialize()+'&_method=PATCH',true);
    }
    function cancelAdjust(){
        $('.price_adjust').hide();
        $('.showAdjust').show();
    }

    // 收货地址
    function modifyAddress(){
        $('.address').show();
        $('.showAddress').hide();
    }

    function confirmAddress(id){
        event.preventDefault();
        updateOrder(id, $('#address').serialize()+'&_method=PATCH',true);
    }

    function cancelAddress(){
        $('.address').hide();
        $('.showAddress').show();
    }


    function editItem(id) {
        $('#item_edit_'+id).hide();
        $('#item_delete_'+id).hide();
        $('#item_cancel_'+id).show();
        $('#item_confirm_'+id).show();
        $('#item_count_'+id+' span').hide();
        $('#item_count_'+id+' input').show();
        $('#item_price_'+id+' span').hide();
        $('#item_price_'+id+' input').show();
    }
    function cancelItem(id) {
        $('#item_edit_'+id).show();
        $('#item_delete_'+id).show();
        $('#item_cancel_'+id).hide();
        $('#item_confirm_'+id).hide();
        $('#item_count_'+id+' span').show();
        $('#item_count_'+id+' input').hide();
        $('#item_price_'+id+' span').show();
        $('#item_price_'+id+' input').hide();
    }
    function updateItem(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"/zcjy/items/" + id,
            type:"POST",
            data:$('#item_form_'+id).serialize()+'&_method=PATCH',
            success: function(data) {
                //提示成功消息
                if(data.code == 0){
                    location.reload();
                }
            },
            error: function(data) {
                //提示失败消息
                alert(data.message);
            },
        });
    }

    //删除商品
    function delItem(item_id,order_id,product_id){
        orderDelProductApi(item_id,order_id,product_id);
    }

    function deleteOrder(id) {
        layer.confirm('确认删除订单，此操作不可恢复', {
          btn: ['取消', '确认删除'] //按钮
        }, function(){
          layer.closeAll();
        }, function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:"/zcjy/orders/"+id+"/delete",
                type:"GET",
                data:'',
                success:function(data){
                    if(data.code==0){
                       layer.confirm('订单已删除', {
                          btn: ['知道了'] //按钮
                        }, function(){
                          window.location.href = "/zcjy/orders";
                        });
                    }else{
                        layer.msg(data.message, {icon: 5});
                    }

                }
            });
        });
    }

    function varifyProductList(){
        location.reload();
    }

    function addProductApi(obj,spec_id,product_id){
        //console.log(obj.dataset.status);
        console.log(obj);
        if(obj.dataset.status=="true"){
           $(obj).css('background','none');
            obj.dataset.status=false;
            var item_id= obj.dataset.itemid;
                 $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
              $.ajax({
            url:"/zcjy/orders/delProductList/"+item_id,
            type:"POST",
            success:function(data){
                if(data.code==0){
                    console.log("删除成功");
                }
            }
        });

        }else{
            obj.style.background="orange";
            obj.dataset.status=true;
            var order_id="{!! $order->id !!}";

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
            url:"/zcjy/orders/addProductList" ,
            type:"POST",
            data:"spec_id="+spec_id+"&order_id="+order_id+"&product_id="+product_id,
            success:function(data){
                if(data.code==0){
                   console.log("添加成功");
                   obj.dataset.itemid=data.message;
                   updateAddProduct(order_id,"add_product=true",product_id);
                }

            }
        });

        }
        
    }


    //添加商品记录
    function updateAddProduct(id,parameter,product_id){
             event.preventDefault();
            updateOrder(id, parameter+'&_method=PATCH&product_id='+product_id,true);
    }

    //删除商品记录
    function updateDelProduct(id,parameter,product_id){
             event.preventDefault();
            updateOrder(id, parameter+'&_method=PATCH&product_id='+product_id,true);
    }

    //按钮更新状态
    function updateStatusByButton(id,parameter){
         event.preventDefault();
         var data=$('#operation_log').val();
        updateOrder(id, parameter+'&_method=PATCH&operation_log='+data,true);
    }

    //确认发货
    function deliveryOrder(id){
        event.preventDefault();
        updateOrder(id, 'order_delivery=已发货&_method=PATCH',true);
    };

    function updateOrder(id, data,status) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"/zcjy/orders/" + id,
            type:"POST",
            data: data,
            success: function(data) {
                //提示成功消息
                if(data.code == 0){
                    if(status){
                    location.reload();
                }
                }
            },
            error: function(data) {
                //提示失败消息

            },
        });
    }

    //管理员修改备注信息
    function modifyManagerBack(){
        $('.managerBack').hide();
        $('.managerBackAction').show();
    }

    function confirmManagerBack(order_id){
        event.preventDefault();
        updateOrder(order_id, $('#manager_backpack').serialize()+'&_method=PATCH',true);
    }

    function cancelManagerBack(){
          $('.managerBackAction').hide();
          $('.managerBack').show();
    }


</script>