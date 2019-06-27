@extends('admin.layouts.app_tem')

@section('content')
<section class="content-header">
    <h1 class="pull-left">用户列表</h1>
    <div>(共{!! $users_num !!}条记录)</div>
</section>

<div class="content pdall0-xs">
    <div class="clearfix"></div>
        <div class="box box-default box-solid mb10-xs" style="margin-top: 15px;">
        <div class="box-header with-border">
            <h3 class="box-title">查询</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"> <i class="fa fa-minus"></i>
                </button>
            </div>
            <!-- /.box-tools --> </div>
        <!-- /.box-header -->
        <div class="box-body">
            <form id="order_search">
                <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                    <label for="nickname">会员昵称</label>
                    <input type="text" class="form-control" name="nickname" placeholder="会员昵称" @if (array_key_exists('nickname', $input))value="{{$input['nickname']}}"@endif></div>

                <div class="form-group col-lg-2 col-md-3 col-sm-6 col-xs-6">
                    <label for="price_sort">会员等级</label>
                    <select class="form-control" name="user_level">
                        <option value="" @if (!array_key_exists('user_level', $input)) selected="selected" @endif>全部</option>
                        @foreach($users_level as $item)
                        <option value="{!! $item->
                            id !!}" @if (array_key_exists('user_level', $input) && $input['user_level']==$item->id ) selected="selected" @endif>{!! $item->name !!}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-6">
                    <label for="order_delivery">消费金额</label>
                    <select class="form-control" name="price_sort">
                        <option value="" @if (!array_key_exists('price_sort', $input)) selected="selected" @endif>全部</option>
                        <option value="0" @if (array_key_exists('price_sort', $input) && $input['price_sort']=='0' ) selected="selected" @endif>顺序</option>
                        <option value="1" @if (array_key_exists('price_sort', $input) && $input['price_sort']=='1') selected="selected" @endif>倒序</option >
                    </select>
                </div>

                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <label for="mobile">手机号</label>
                    <input type="text" class="form-control" name="mobile" placeholder="手机号" @if (array_key_exists('mobile', $input))value="{{$input['mobile']}}"@endif></div>


                <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                    <label for="order_delivery">每页显示</label>
                    <select class="form-control" name="page_list">
                        <option value="" @if (!array_key_exists('page_list', $input)) selected="selected" @endif>默认</option>
                        <option value="5" @if (array_key_exists('page_list', $input) && $input['page_list']=='5') selected="selected" @endif>5</option >
                        <option value="15" @if (array_key_exists('page_list', $input) && $input['page_list']=='15') selected="selected" @endif>15</option >
                      <option value="25" @if (array_key_exists('page_list', $input) && $input['page_list']=='25') selected="selected" @endif>25</option >
                    </select>
                </div>

                <div class="form-group col-lg-1 col-md-1 hidden-xs hidden-sm" style="padding-top: 25px;">
                    <button type="submit" class="btn btn-primary pull-right " onclick="search()">查询</button>
                </div>
                <div class="form-group col-xs-6 visible-xs visible-sm" >
                    <button type="submit" class="btn btn-primary pull-left " onclick="search()">查询</button>
                </div>
            </form>
        </div>
        <!-- /.box-body --> </div>
    <div class="clearfix"></div>
    <div class="box box-primary mb10-xs">
        <div class="box-body">
            <table class="table table-responsive" id="users-table">
                <thead>
                    <th>
                    <div>
                            <input type="checkbox" class="checkAll"></div>
                    </th>
                    <th>昵称</th>
                    <th>性别</th>
                    <th>会员等级</th>
                    <th class="hidden-xs">累计消费</th>
                    <th>手机号</th>
                    <th>注册日期</th>
                </thead>
                <tbody id="users-tbody">
                    @foreach($users as $item)
                    <tr data-userid="{!! $item->id !!}" data-name="{!! $item->nickname !!}" data-sex="{!! $item->sex !!}" data-mobile="{!! $item->mobile !!}">
                        <td></td>
                        <td>{!! $item->nickname !!}</td>
                        <td>{!! $item->sex !!}</td>
                        <td>{!! $item->level->name !!}</td>
                        <td class="hidden-xs">{!! $item->consume_total !!}</td>
                        <td>{!! $item->mobile !!}</td>
                        <td>{!! $item->created_at !!}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
          <div class="pull-left" style="margin-top:15px;">
            <input type="button" class="btn btn-primary"  value="确定" id="users_enter"></div>
    </div>
    <div class="tc">
        <?php echo $users->appends($input)->render(); ?></div>
</div>
@endsection


@section('scripts')
<script type="text/javascript">
        //全选用户
        $('.checkAll').click(function(){
                var status=$(this).is(':checked');
                console.log(status);
                if(status){
                      $('#users-tbody >tr').each(function(){
               
                         $(this).addClass('trSelected');
                     
             });
                }else{
                     $('#users-tbody >tr').each(function(){
                    
                         $(this).removeClass('trSelected');
                     
             });
                }
        });

        //单选
        $('#users-tbody >tr').click(function(){
               $(this).toggleClass('trSelected');
        });

        //确定
        $('#users_enter').click(function(){
            var selected=$('#users-tbody >tr').hasClass('trSelected');
            if(!selected){
               layer.alert('请选择商品', {icon: 2}); 
               return false;
            }
            $('#users-tbody >tr').each(function(){
                if(!$(this).hasClass('trSelected')){
                    $(this).remove();
                }
            });
            var tabHtml=$('#users-tbody').html();
            console.log(tabHtml);
            javascript:window.parent.call_back_by_user(tabHtml);
        });

</script>


@endsection