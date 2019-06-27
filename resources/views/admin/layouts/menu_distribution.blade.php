@if(funcOpen('FUNC_DISTRIBUTION'))
<li class="header">三级分销</li>

<!--li class="{{ Request::is('zcjy/distributions/stats*') ? 'active' : '' }}">
    <a href="{!! route('distributions.stats') !!}"><i class="fa fa-edit"></i><span>分销统计</span></a>
</li-->
<li class="{{ Request::is('zcjy/distributions/lists*') ? 'active' : '' }}">
    <a href="{!! route('distributions.lists') !!}"><i class="fa fa-edit"></i><span>分销商列表</span></a>
</li>
<li class="{{ Request::is('zcjy/distributions/settings*') ? 'active' : '' }}">
    <a href="{!! route('distributions.settings') !!}"><i class="fa fa-edit"></i><span>分销设置</span></a>
</li>
<li class="{{ Request::is('zcjy/distributionLogs*') ? 'active' : '' }}">
    <a href="{!! route('distributionLogs.index') !!}"><i class="fa fa-edit"></i><span>分佣日志</span></a>
</li>
@endif