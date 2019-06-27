<li class="{{ Request::is('zcjy/stat*') ? 'active' : '' }}">
    <a href="{!! route('stat.index') !!}"><i class="fa fa-edit"></i><span>统计信息</span></a>
</li>

<?php
    $active = Request::is('zcjy/orders*') ||  Request::is('zcjy/refundMoneys*');
?>

<li class="treeview @if ($active) active @endif">
    <a href="#">
    <i class="fa fa-laptop"></i>
        <span>订单管理</span>
    <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu" @if ($active) style="display: block;" @else style="display: none;" @endif>
        <li class="{{ Request::is('zcjy/orders*') && empty(Request::get('menu_type'))? 'active' : '' }}">
            <a href="{!! route('orders.index') !!}"><i class="fa fa-edit"></i><span>全部订单</span></a>
        </li>

        @if(funcOpen('FUNC_FLASHSALE'))
        <li class="{{ Request::get('menu_type')=='1'?'active':'' }}">
            <a href="{!! route('orders.index').varifyOrderType('秒杀订单') !!}"><i class="fa fa-edit"></i><span>秒杀订单</span></a>
        </li>
        @endif

        @if(funcOpen('FUNC_TEAMSALE'))
        <li class="{{ Request::get('menu_type')=='5'?'active':'' }}">
            <a href="{!! route('orders.index').varifyOrderType('拼团订单') !!}"><i class="fa fa-edit"></i><span>拼团订单</span></a>
        </li>
        @endif

        <li class="{{ Request::get('menu_type')=='6'?'active':'' }}">
            <a href="{!! route('orders.index').varifyOrderType('发货单') !!}"><i class="fa fa-edit"></i><span>发货单</span></a>
        </li>


    </ul>
</li>

<?php
    $active2 = Request::is('zcjy/products*') || Request::is('zcjy/all_products*') || Request::is('zcjy/categories*') || Request::is('zcjy/services*') || Request::is('zcjy/creditsServices*') || Request::is('zcjy/creditServiceUsers*') || Request::is('zcjy/topupGifts*') || Request::is('zcjy/topupLogs*') ||  Request::is('zcjy/discountOrders*');
?>
<li class="treeview @if($active2) active @endif">
    <a href="#">
    <i class="fa fa-laptop"></i>
        <span>产品管理</span>
    <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu" @if($active2) style="display: block;" @else style="display: none;" @endif >
       <li class="{{ Request::is('zcjy/services*') ? 'active' : '' }}">
            <a href="{!! route('services.index') !!}"><i class="fa fa-edit"></i><span>服务管理</span></a>
        </li>
        <li class="{{ Request::is('zcjy/products*') && !Request::is('zcjy/products/create') ? 'active' : '' }}">
            <a href="{!! route('products.index') !!}"><i class="fa fa-edit"></i><span>产品列表</span></a>
        </li>
        <li class="{{ Request::is('zcjy/products/create') ? 'active' : '' }}">
            <a href="{!! route('products.create') !!}"><i class="fa fa-edit"></i><span>添加产品</span></a>
        </li>
    {{--     <li class="{{ Request::is('zcjy/all_products/allLowGoods*')?'active':'' }}">
            <a href="{!! route('products.alllow') !!}"><i class="fa fa-edit"></i><span>库存报警</span></a>
        </li> --}}
        <li class="{{ Request::is('zcjy/categories*') ? 'active' : '' }}">
            <a href="{!! route('categories.index') !!}"><i class="fa fa-edit"></i><span>分类信息</span></a>
        </li>

        <li class="{{ Request::is('zcjy/creditsServices*') ? 'active' : '' }}">
            <a href="{!! route('creditsServices.index') !!}"><i class="fa fa-edit"></i><span>积分商城</span></a>
        </li>

        <li class="{{ Request::is('zcjy/creditServiceUsers*') ? 'active' : '' }}">
            <a href="{!! route('creditServiceUsers.index') !!}"><i class="fa fa-edit"></i><span>积分产品兑换记录</span></a>
        </li>

        <li class="{{ Request::is('zcjy/topupGifts*') ? 'active' : '' }}">
            <a href="{!! route('topupGifts.index') !!}"><i class="fa fa-edit"></i><span>充值服务</span></a>
        </li>

        <li class="{{ Request::is('zcjy/topupLogs*') ? 'active' : '' }}">
            <a href="{!! route('topupLogs.index') !!}"><i class="fa fa-edit"></i><span>充值记录</span></a>
        </li>

        <li class="{{ Request::is('zcjy/discountOrders*') ? 'active' : '' }}">
            <a href="{!! route('discountOrders.index') !!}"><i class="fa fa-edit"></i><span>优惠买单记录</span></a>
        </li>
            
        
        
    </ul>
</li>

<li class="treeview {{ Request::is('zcjy/technicians*') || Request::is('zcjy/users*') || Request::is('zcjy/userLevels*') || Request::is('zcjy/shopBranchManagers*')  ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-folder"></i> <span>人员管理</span>
        <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        
        @if(admin()->shop_type )
            <?php $admin_package = getAdminPackageStatus();?>
            @if($admin_package['package']['canuse_shop_num'] > 1)
            <li class="{{ Request::is('zcjy/shopBranchManagers*') ? 'active' : '' }}">
                <a href="{!! route('shopBranchManagers.index') !!}"><i class="fa fa-edit"></i><span>分店管理员管理</span></a>
            </li>
            @endif
        @endif

        <li class="{{ Request::is('zcjy/users*') || Request::is('zcjy/userLevels*') ? 'active' : '' }}">
            <a href="{!! route('users.index') !!}"><i class="fa fa-edit"></i><span>会员管理</span></a>
        </li>
        <li class="{{ Request::is('zcjy/technicians*') && !Request::is('zcjy/technicians/create') ? 'active' : '' }}">
            <a href="{!! route('technicians.index') !!}"><i class="fa fa-edit"></i><span>技师管理</span></a>
        </li>
        <li class="{{ Request::is('zcjy/technicians/create') ? 'active' : '' }}">
            <a href="{!! route('technicians.create') !!}"><i class="fa fa-bars"></i><span>添加技师</span></a>
        </li>

    </ul>
</li>

<li class="treeview {{ Request::is('zcjy/subscribes*')  ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-folder"></i> <span>预约管理</span>
        <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('zcjy/subscribes*') && !Request::is('zcjy/subscribes/watch') ? 'active' : '' }}">
            <a href="{!! route('subscribes.index') !!}"><i class="fa fa-edit"></i><span>预约管理</span></a>
        </li>
        <li class="{{ Request::is('zcjy/subscribes/watch')  ? 'active' : '' }}">
            <a href="{!! route('subscribes.watch') !!}"><i class="fa fa-edit"></i><span>预约看板</span></a>
        </li>

    </ul>
</li>





