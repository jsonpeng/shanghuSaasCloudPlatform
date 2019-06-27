@if(funcOpen('FUNC_PRODUCT_PROMP'))
<li class="treeview {{ Request::is('zcjy/productPromps*') ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-folder"></i> <span>商品促销</span>
        <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('zcjy/productPromps') ? 'active' : '' }}">
            <a href="{!! route('productPromps.index') !!}"><i class="fa fa-edit"></i><span>商品促销</span></a>
        </li>
         <li class="{{ Request::is('zcjy/productPromps/create*') ? 'active' : '' }}">
            <a href="{!! route('productPromps.create') !!}"><i class="fa fa-edit"></i><span>添加促销</span></a>
        </li>
      
    </ul>
</li>
@endif

@if(funcOpen('FUNC_ORDER_PROMP'))
<li class="treeview {{ Request::is('zcjy/orderPromps*') ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-folder"></i> <span>订单促销</span>
        <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('zcjy/orderPromps') ? 'active' : '' }}">
            <a href="{!! route('orderPromps.index') !!}"><i class="fa fa-edit"></i><span>订单促销</span></a>
        </li>
         <li class="{{ Request::is('zcjy/orderPromps/create') ? 'active' : '' }}">
            <a href="{!! route('orderPromps.create') !!}"><i class="fa fa-edit"></i><span>添加促销</span></a>
        </li>
    </ul>
</li>
@endif

@if(funcOpen('FUNC_COUPON'))
<li class="treeview {{ Request::is('zcjy/coupons*') || Request::is('zcjy/couponRules*') ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-folder"></i> <span>优惠券</span>
        <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('zcjy/coupons') ? 'active' : '' }}">
            <a href="{!! route('coupons.index') !!}"><i class="fa fa-edit"></i><span>优惠券</span></a>
        </li>
         <li class="{{ Request::is('zcjy/coupons/create') ? 'active' : '' }}">
            <a href="{!! route('coupons.create') !!}"><i class="fa fa-edit"></i><span>添加优惠券</span></a>
        </li>
        <li class="{{ Request::is('zcjy/couponRules*') ? 'active' : '' }}">
            <a href="{!! route('couponRules.index') !!}"><i class="fa fa-edit"></i><span>自动发放</span></a>
        </li>
        <li class="{{ Request::is('zcjy/coupons/given*') ? 'active' : '' }}">
            <a href="{!! route('coupons.integer') !!}"><i class="fa fa-edit"></i><span>手动发放</span></a>
        </li>
        <!--li class="{{ Request::is('zcjy/coupons/stats') ? 'active' : '' }}">
            <a href="{!! route('coupons.stats') !!}"><i class="fa fa-edit"></i><span>统计信息</span></a>
        </li-->
    </ul>
</li>
@endif

@if(funcOpen('FUNC_FLASHSALE'))
<li class="treeview {{ Request::is('zcjy/flashSales*') ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-folder"></i> <span>秒杀/抢购</span>
        <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('zcjy/flashSales') ? 'active' : '' }}">
            <a href="{!! route('flashSales.index') !!}"><i class="fa fa-edit"></i><span>活动管理</span></a>
        </li>
       <li class="{{ Request::is('zcjy/flashSales/create') ? 'active' : '' }}">
            <a href="{!! route('flashSales.create') !!}"><i class="fa fa-edit"></i><span>添加秒杀</span></a>
        </li>
    </ul>
</li>
@endif

@if(funcOpen('FUNC_TEAMSALE'))
<li class="treeview {{ Request::is('zcjy/teamSales*') ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-folder"></i> <span>拼团</span>
        <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('zcjy/teamSales') ? 'active' : '' }}">
            <a href="{!! route('teamSales.index') !!}"><i class="fa fa-edit"></i><span>拼团管理</span></a>
        </li>
        <li class="{{ Request::is('zcjy/teamSales/create') ? 'active' : '' }}">
            <a href="{!! route('teamSales.create') !!}"><i class="fa fa-edit"></i><span>添加拼团</span></a>
        </li>
    </ul>
</li>
@endif
