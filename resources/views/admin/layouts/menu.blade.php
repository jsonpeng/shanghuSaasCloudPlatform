<?php $admin=admin();?>

@if($admin->type == '管理员')
<li class="{{ Request::is('zcjy/chargePackages*') ? 'active' : '' }}">
    <a href="{!! route('chargePackages.index') !!}"><i class="fa fa-edit"></i><span>收费套餐</span></a>
</li>

<li class="{{ Request::is('zcjy/word_packages*') ? 'active' : '' }}">
    <a href="{!! route('wordlist.index') !!}"><i class="fa fa-edit"></i><span>套餐条目</span></a>
</li>

<li class="{{ Request::is('zcjy/packageLogs*') ? 'active' : '' }}">
    <a href="{!! route('packageLogs.index') !!}"><i class="fa fa-edit"></i><span>套餐记录</span></a>
</li>

<li class="{{ Request::is('zcjy/managers*') ? 'active' : '' }}">
    <a href="{!! route('managers.index') !!}"><i class="fa fa-user"></i><span>人员管理</span></a>
</li>
@endif

@if($admin->type == '代理商')
<li class="{{ Request::is('zcjy/shopManagers*') &&  Request::get('type') != 'proxy' && session(admin()->id.'_manager') != '代理商' ? 'active' : '' }}">
    <a href="{!! route('shopManagers.index') !!}"><i class="fa fa-edit"></i><span>商户管理</span></a>
</li>
<li class="{{ Request::is('zcjy/shopManagers*') && Request::get('type')=='proxy'  ||  session(admin()->id.'_manager') == '代理商' && Request::is('zcjy/shopManagers*') ? 'active' : '' }}">
    <a href="{!! route('shopManagers.index') !!}?type=proxy"><i class="fa fa-edit"></i><span>代理商管理</span></a>
</li>
@endif

@if($admin->type == '代理商'  ||  $admin->type == '管理员')
<li class="{{ Request::is('zcjy/settings/setting*') ? 'active' : '' }}">
        <a href="{!! route('settings.setting') !!}"><i class="fa fa-edit"></i><span>系统设置</span></a>
</li>
@endif

@if($admin->type == '商户')
<li class="header">店铺设置</li>
<li class="treeview {{ Request::is('zcjy/setting*') || Request::is('zcjy/settings/themeSetting*') || Request::is('zcjy/singelPages*') ||  Request::is('zcjy/storeShops*') || Request::is('zcjy/notices*') ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-folder"></i> <span>基本设置</span>
        <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        
     {{--    <li class="{{ Request::is('zcjy/storeShops*') ? 'active' : '' }}">
            <a href="{!! route('storeShops.index') !!}"><i class="fa fa-edit"></i><span>店铺管理</span></a>
        </li> --}}

        <li class="{{ Request::is('zcjy/settings/setting*') ? 'active' : '' }}">
                <a href="{!! route('settings.setting') !!}"><i class="fa fa-edit"></i><span>店铺信息</span></a>
        </li>
        <li class="{{ Request::is('zcjy/settings/system') ? 'active' : '' }}">
            <a href="{!! route('settings.system') !!}"><i class="fa fa-edit"></i><span>系统功能</span></a>
        </li>

        @if( Config::get('web.FUNC_THEME') || Config::get('web.FUNC_COLOR'))
        <li class="{{ Request::is('zcjy/settings/themeSetting*') ? 'active' : '' }}">
            <a href="{!! route('settings.themeSetting') !!}"><i class="fa fa-edit"></i><span>主题设置</span></a>
        </li>
        @endif

   
        <li class="{{ Request::is('zcjy/notices*') ? 'active' : '' }}">
            <a href="{!! route('notices.index') !!}"><i class="fa fa-edit"></i><span>公告消息</span></a>
        </li>
{{--         
        @if(Config::get('web.FUNC_FOOTER'))
        <li class="{{ Request::is('zcjy/singelPages*') ? 'active' : '' }}">
            <a href="{!! route('singelPages.index') !!}"><i class="fa fa-edit"></i><span>业务介绍</span></a>
        </li>
        @endif --}}
    </ul>
</li>
@endif

@if($admin->type == '商户')
    @if(Config::get('web.FUNC_POST'))
    <li class="header">内容管理</li>
    <li class="treeview {{ Request::is('zcjy/articlecats') || Request::is('zcjy/banners*') || Request::is('zcjy/*/bannerItems*') || Request::is('zcjy/articlecats/create') || Request::is('zcjy/posts') || Request::is('zcjy/posts/create') || Request::is('zcjy/customPostTypes*') ? 'active' : '' }}">
        <a href="#">
            <i class="fa fa-folder"></i> <span>内容管理</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="{{ Request::is('zcjy/banners*') || Request::is('zcjy/*/bannerItems*') ? 'active' : '' }}">
                <a href="{!! route('banners.index') !!}"><i class="fa fa-edit"></i><span>滚动横幅</span></a>
            </li>
            <li class="{{ Request::is('zcjy/articlecats') ? 'active' : '' }}">
                <a href="{!! route('articlecats.index') !!}"><i class="fa fa-bars"></i><span>话题分类</span></a>
            </li>
            <li class="{{ Request::is('zcjy/articlecats/create') ? 'active' : '' }}">
                <a href="{!! route('articlecats.create') !!}"><i class="fa fa-bars"></i><span>添加分类</span></a>
            </li>
            <li class="{{ Request::is('zcjy/posts') ? 'active' : '' }}">
                <a href="{!! route('posts.index') !!}"><i class="fa fa-newspaper-o"></i><span>话题列表</span></a>
            </li>
            <li class="{{ Request::is('zcjy/posts/create') ? 'active' : '' }}">
                <a href="{!! route('posts.create') !!}"><i class="fa fa-newspaper-o"></i><span>添加话题</span></a>
            </li>

        </ul>
    </li>
    @endif



    <li class="{{ Request::is('zcjy/bind_mini_chat') ? 'active' : '' }}">
        <a href="{!! route('minichat.bind') !!}"><i class="fa fa-newspaper-o"></i><span>绑定小程序</span></a>
    </li>

   <li class="{{ Request::is('zcjy/package/*') ? 'active' : '' }}">
        <a href="{!! route('package.buy') !!}"><i class="fa fa-edit"></i><span>{{ getAdminPackageStatus()['status_name'] }}套餐</span></a>
    </li>


@endif

<li class="{{ Request::is('zcjy/message*') ? 'active' : '' }}">
    <a href="{!! route('message.index') !!}"><i class="fa fa-envelope-o"></i><span>站内信</span><span class="pull-right-container">
      @if(count($adminUnreadNotices))<small class="label pull-right bg-red">{{ count($adminUnreadNotices) }}</small>@endif
    </span></a>
</li>

<li class="">
    <a href="javascript:;" id="refresh"><i class="fa fa-refresh"></i><span>清理缓存</span></a>
</li>

